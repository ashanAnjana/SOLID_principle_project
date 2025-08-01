<?php

require_once 'User.php';

/**
 * RegularUser class - represents a standard user
 * Follows LSP - can be substituted anywhere User is expected
 */
class RegularUser extends User
{
    private $preferences;

    public function __construct($id, $firstName, $lastName, $email)
    {
        parent::__construct($id, $firstName, $lastName, $email, 'regular');
        $this->preferences = [];
    }

    /**
     * Regular users have basic permissions
     */
    public function getPermissions(): array
    {
        return [
            'view_profile',
            'edit_profile',
            'change_password',
            'view_dashboard'
        ];
    }

    /**
     * Regular users can access basic resources
     */
    public function canAccess(string $resource): bool
    {
        $allowedResources = [
            'dashboard',
            'profile',
            'settings',
            'logout'
        ];

        return in_array($resource, $allowedResources);
    }

    /**
     * Display name for regular users
     */
    public function getDisplayName(): string
    {
        return $this->getFullName();
    }

    /**
     * Set user preferences
     */
    public function setPreference(string $key, $value): void
    {
        $this->preferences[$key] = $value;
    }

    /**
     * Get user preference
     */
    public function getPreference(string $key, $default = null)
    {
        return $this->preferences[$key] ?? $default;
    }

    /**
     * Get all preferences
     */
    public function getPreferences(): array
    {
        return $this->preferences;
    }

    /**
     * Override login behavior for regular users
     */
    protected function performLogin(): bool
    {
        // Regular users might have additional login steps
        // e.g., check if account is verified, not suspended, etc.
        return $this->isActive();
    }

    /**
     * Check if user can perform specific action
     */
    public function canPerformAction(string $action): bool
    {
        $allowedActions = [
            'update_profile',
            'change_password',
            'view_own_data'
        ];

        return in_array($action, $allowedActions);
    }

    /**
     * Get user dashboard data
     */
    public function getDashboardData(): array
    {
        return [
            'welcome_message' => "Welcome back, " . $this->getFirstName() . "!",
            'user_type' => 'Regular User',
            'permissions' => $this->getPermissions(),
            'last_login' => date('Y-m-d H:i:s')
        ];
    }
}
