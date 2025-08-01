<?php

require_once 'User.php';

/**
 * AdminUser class - represents an administrator user
 * Follows LSP - can be substituted anywhere User is expected
 * Extends functionality while maintaining the same interface
 */
class AdminUser extends User
{
    private $adminLevel;
    private $lastAdminAction;

    public function __construct($id, $firstName, $lastName, $email, $adminLevel = 1)
    {
        parent::__construct($id, $firstName, $lastName, $email, 'admin');
        $this->adminLevel = $adminLevel;
        $this->lastAdminAction = null;
    }

    /**
     * Admin users have extensive permissions
     */
    public function getPermissions(): array
    {
        $basePermissions = [
            'view_profile',
            'edit_profile',
            'change_password',
            'view_dashboard',
            'manage_users',
            'view_all_users',
            'delete_users',
            'modify_user_permissions',
            'access_admin_panel',
            'view_system_logs',
            'backup_system',
            'manage_settings'
        ];

        // Super admin gets additional permissions
        if ($this->adminLevel >= 2) {
            $basePermissions = array_merge($basePermissions, [
                'manage_admins',
                'system_configuration',
                'database_access',
                'security_settings'
            ]);
        }

        return $basePermissions;
    }

    /**
     * Admin users can access all resources
     */
    public function canAccess(string $resource): bool
    {
        // Admins can access everything, but we still validate
        $restrictedResources = [];
        
        // Super admin restrictions (if any)
        if ($this->adminLevel < 2) {
            $restrictedResources = ['system_config', 'database_direct'];
        }

        return !in_array($resource, $restrictedResources);
    }

    /**
     * Display name includes admin designation
     */
    public function getDisplayName(): string
    {
        $level = $this->adminLevel >= 2 ? 'Super Admin' : 'Admin';
        return $this->getFullName() . " ({$level})";
    }

    /**
     * Get admin level
     */
    public function getAdminLevel(): int
    {
        return $this->adminLevel;
    }

    /**
     * Set admin level
     */
    public function setAdminLevel(int $level): void
    {
        if ($level >= 1 && $level <= 3) {
            $this->adminLevel = $level;
        }
    }

    /**
     * Check if user can manage other users
     */
    public function canManageUser(User $user): bool
    {
        // Admins can manage regular users
        if ($user instanceof RegularUser) {
            return true;
        }

        // Only super admins can manage other admins
        if ($user instanceof AdminUser) {
            return $this->adminLevel >= 2 && $this->adminLevel > $user->getAdminLevel();
        }

        return false;
    }

    /**
     * Override login behavior for admin users
     */
    protected function performLogin(): bool
    {
        if (!parent::performLogin()) {
            return false;
        }

        // Additional admin login checks
        $this->logAdminAction('login');
        return true;
    }

    /**
     * Log admin actions for audit trail
     */
    public function logAdminAction(string $action, array $details = []): void
    {
        $this->lastAdminAction = [
            'action' => $action,
            'timestamp' => date('Y-m-d H:i:s'),
            'details' => $details,
            'admin_id' => $this->getId(),
            'admin_level' => $this->adminLevel
        ];

        // In a real application, this would be logged to database or file
        error_log("Admin Action: " . json_encode($this->lastAdminAction));
    }

    /**
     * Get last admin action
     */
    public function getLastAdminAction(): ?array
    {
        return $this->lastAdminAction;
    }

    /**
     * Get admin dashboard data with additional admin info
     */
    public function getDashboardData(): array
    {
        return [
            'welcome_message' => "Welcome, " . $this->getDisplayName() . "!",
            'user_type' => 'Administrator',
            'admin_level' => $this->adminLevel,
            'permissions' => $this->getPermissions(),
            'last_login' => date('Y-m-d H:i:s'),
            'admin_tools' => [
                'user_management',
                'system_logs',
                'settings',
                'backup_tools'
            ]
        ];
    }

    /**
     * Perform admin-specific actions
     */
    public function performAdminAction(string $action, array $params = []): bool
    {
        if (!in_array($action, $this->getPermissions())) {
            return false;
        }

        $this->logAdminAction($action, $params);
        
        // Simulate admin action execution
        switch ($action) {
            case 'manage_users':
                return $this->manageUsers($params);
            case 'backup_system':
                return $this->backupSystem();
            case 'view_system_logs':
                return $this->viewSystemLogs();
            default:
                return true;
        }
    }

    private function manageUsers(array $params): bool
    {
        // Implementation for user management
        return true;
    }

    private function backupSystem(): bool
    {
        // Implementation for system backup
        return true;
    }

    private function viewSystemLogs(): bool
    {
        // Implementation for viewing system logs
        return true;
    }
}
