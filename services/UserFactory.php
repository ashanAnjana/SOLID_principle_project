<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/RegularUser.php';
require_once __DIR__ . '/../models/AdminUser.php';
require_once __DIR__ . '/../models/GuestUser.php';

/**
 * UserFactory - Creates appropriate user objects based on type
 * Demonstrates LSP - all created users can be used interchangeably
 */
class UserFactory
{
    /**
     * Create user object from database data
     */
    public static function createFromDatabase(array $userData): User
    {
        $userType = $userData['user_type'] ?? 'regular';
        
        switch ($userType) {
            case 'admin':
                $adminLevel = $userData['admin_level'] ?? 1;
                return new AdminUser(
                    $userData['id'],
                    $userData['first_name'],
                    $userData['last_name'],
                    $userData['email'],
                    $adminLevel
                );
                
            case 'regular':
                return new RegularUser(
                    $userData['id'],
                    $userData['first_name'],
                    $userData['last_name'],
                    $userData['email']
                );
                
            case 'guest':
                return new GuestUser(
                    $userData['session_id'] ?? null,
                    $userData['ip_address'] ?? null
                );
                
            default:
                // Default to regular user for unknown types
                return new RegularUser(
                    $userData['id'],
                    $userData['first_name'],
                    $userData['last_name'],
                    $userData['email']
                );
        }
    }

    /**
     * Create guest user
     */
    public static function createGuest($sessionId = null, $ipAddress = null): GuestUser
    {
        return new GuestUser($sessionId, $ipAddress);
    }

    /**
     * Create regular user
     */
    public static function createRegularUser($id, $firstName, $lastName, $email): RegularUser
    {
        return new RegularUser($id, $firstName, $lastName, $email);
    }

    /**
     * Create admin user
     */
    public static function createAdminUser($id, $firstName, $lastName, $email, $adminLevel = 1): AdminUser
    {
        return new AdminUser($id, $firstName, $lastName, $email, $adminLevel);
    }

    /**
     * Create user from session data
     */
    public static function createFromSession(array $sessionData): User
    {
        if (empty($sessionData) || !isset($sessionData['user_id'])) {
            return self::createGuest();
        }

        return self::createFromDatabase($sessionData);
    }

    /**
     * Determine user type from email or other criteria
     */
    public static function determineUserType(string $email): string
    {
        // Simple logic - in real app, this might check database or config
        if (strpos($email, 'admin@') === 0) {
            return 'admin';
        }
        
        if (strpos($email, 'guest@') === 0) {
            return 'guest';
        }
        
        return 'regular';
    }

    /**
     * Upgrade user type (e.g., regular to admin)
     */
    public static function upgradeUser(User $user, string $newType, array $additionalData = []): User
    {
        $userData = $user->toArray();
        $userData['user_type'] = $newType;
        
        // Add additional data for specific user types
        if ($newType === 'admin' && isset($additionalData['admin_level'])) {
            $userData['admin_level'] = $additionalData['admin_level'];
        }
        
        return self::createFromDatabase($userData);
    }

    /**
     * Validate user type
     */
    public static function isValidUserType(string $userType): bool
    {
        return in_array($userType, ['regular', 'admin', 'guest']);
    }

    /**
     * Get available user types
     */
    public static function getAvailableUserTypes(): array
    {
        return [
            'regular' => 'Regular User',
            'admin' => 'Administrator',
            'guest' => 'Guest User'
        ];
    }
}
