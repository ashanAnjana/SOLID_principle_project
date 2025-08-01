<?php

require_once 'User.php';

/**
 * GuestUser class - represents an unauthenticated/temporary user
 * Follows LSP - can be substituted anywhere User is expected
 * Provides minimal functionality for non-authenticated users
 */
class GuestUser extends User
{
    private $sessionId;
    private $ipAddress;

    public function __construct($sessionId = null, $ipAddress = null)
    {
        // Guest users have minimal data
        parent::__construct(0, 'Guest', 'User', 'guest@system.local', 'guest');
        $this->sessionId = $sessionId ?? session_id();
        $this->ipAddress = $ipAddress ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $this->isActive = true; // Guests are always "active" for their session
    }

    /**
     * Guest users have very limited permissions
     */
    public function getPermissions(): array
    {
        return [
            'view_public_content',
            'register',
            'login',
            'view_home'
        ];
    }

    /**
     * Guest users can only access public resources
     */
    public function canAccess(string $resource): bool
    {
        $allowedResources = [
            'home',
            'login',
            'register',
            'about',
            'contact',
            'public_content',
            'terms',
            'privacy'
        ];

        return in_array($resource, $allowedResources);
    }

    /**
     * Display name for guest users
     */
    public function getDisplayName(): string
    {
        return 'Guest User';
    }

    /**
     * Get session ID
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * Get IP address
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * Override getId to return session-based ID
     */
    public function getId(): int
    {
        return 0; // Guests always have ID 0
    }

    /**
     * Override getEmail to return system email
     */
    public function getEmail(): string
    {
        return 'guest@system.local';
    }

    /**
     * Guests cannot be deactivated in the traditional sense
     */
    public function deactivate(): void
    {
        // For guests, deactivation means ending the session
        $this->isActive = false;
    }

    /**
     * Override login behavior for guest users
     */
    protected function performLogin(): bool
    {
        // Guests are already "logged in" as guests
        return true;
    }

    /**
     * Check if guest can perform specific action
     */
    public function canPerformAction(string $action): bool
    {
        $allowedActions = [
            'view_public_content',
            'attempt_login',
            'attempt_register'
        ];

        return in_array($action, $allowedActions);
    }

    /**
     * Get guest dashboard data (limited)
     */
    public function getDashboardData(): array
    {
        return [
            'welcome_message' => "Welcome, Guest! Please login or register to access more features.",
            'user_type' => 'Guest',
            'permissions' => $this->getPermissions(),
            'session_id' => $this->sessionId,
            'suggestions' => [
                'Login to access your account',
                'Register for a new account',
                'Browse public content'
            ]
        ];
    }

    /**
     * Convert guest to registered user (when they register)
     */
    public function convertToRegisteredUser($id, $firstName, $lastName, $email): RegularUser
    {
        require_once 'RegularUser.php';
        return new RegularUser($id, $firstName, $lastName, $email);
    }

    /**
     * Override toArray to include guest-specific data
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['sessionId'] = $this->sessionId;
        $data['ipAddress'] = $this->ipAddress;
        return $data;
    }

    /**
     * Override validateData for guests
     */
    public function validateData(): bool
    {
        // Guests don't need traditional validation
        return !empty($this->sessionId);
    }

    /**
     * Track guest activity
     */
    public function trackActivity(string $activity): void
    {
        $activityLog = [
            'session_id' => $this->sessionId,
            'ip_address' => $this->ipAddress,
            'activity' => $activity,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // In a real application, this would be logged to database or file
        error_log("Guest Activity: " . json_encode($activityLog));
    }
}
