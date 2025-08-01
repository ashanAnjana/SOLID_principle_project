<?php

require_once 'models/User.php';
require_once 'models/RegularUser.php';
require_once 'models/AdminUser.php';
require_once 'models/GuestUser.php';

/**
 * Liskov Substitution Principle (LSP) Demonstration
 * 
 * This demo proves that any User subclass can be substituted
 * for the base User class without breaking functionality.
 */

/**
 * UserManager class that works with ANY User type
 * This proves LSP - it doesn't need to know the specific user type
 */
class UserManager
{
    /**
     * Process any user type - demonstrates LSP
     * This method works with User base class but accepts any subclass
     */
    public function processUser(User $user): array
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getDisplayName(),
            'email' => $user->getEmail(),
            'permissions' => $user->getPermissions(),
            'can_access_admin' => $user->canAccess('admin'),
            'can_access_dashboard' => $user->canAccess('dashboard'),
            'user_type' => $user->getUserType(),
            'is_active' => $user->isActive()
        ];
    }

    /**
     * Batch process multiple users of different types
     * Demonstrates LSP with polymorphism
     */
    public function processMultipleUsers(array $users): array
    {
        $results = [];
        foreach ($users as $user) {
            // LSP in action: we don't care about the specific type
            $results[] = $this->processUser($user);
        }
        return $results;
    }

    /**
     * Authorization check that works with any User type
     */
    public function authorizeUserForResource(User $user, string $resource): bool
    {
        // LSP: This method works regardless of which User subclass is passed
        return $user->canAccess($resource);
    }

    /**
     * Generate user report - works with any User subclass
     */
    public function generateUserReport(User $user): string
    {
        $permissions = implode(', ', $user->getPermissions());
        
        return "User Report:\n" .
               "Name: {$user->getDisplayName()}\n" .
               "Email: {$user->getEmail()}\n" .
               "Type: {$user->getUserType()}\n" .
               "Permissions: {$permissions}\n" .
               "Status: " . ($user->isActive() ? 'Active' : 'Inactive') . "\n";
    }
}

// ============================================================================
// LSP DEMONSTRATION
// ============================================================================

echo "<h1>Liskov Substitution Principle (LSP) Demonstration</h1>\n";
echo "<pre>\n";

// Create different user types
$regularUser = new RegularUser(1, 'John', 'Doe', 'john@example.com');
$adminUser = new AdminUser(2, 'Jane', 'Smith', 'jane@example.com');
$guestUser = new GuestUser(3, 'Guest', 'User', 'guest@example.com');

$userManager = new UserManager();

echo "=== LSP Test 1: Single User Processing ===\n";
echo "Processing different user types with the same method:\n\n";

// LSP in action: same method works with all user types
$regularResult = $userManager->processUser($regularUser);
$adminResult = $userManager->processUser($adminUser);
$guestResult = $userManager->processUser($guestUser);

echo "Regular User: " . json_encode($regularResult, JSON_PRETTY_PRINT) . "\n\n";
echo "Admin User: " . json_encode($adminResult, JSON_PRETTY_PRINT) . "\n\n";
echo "Guest User: " . json_encode($guestResult, JSON_PRETTY_PRINT) . "\n\n";

echo "=== LSP Test 2: Batch Processing ===\n";
echo "Processing array of mixed user types:\n\n";

// LSP: Array can contain any User subclass
$mixedUsers = [$regularUser, $adminUser, $guestUser];
$batchResults = $userManager->processMultipleUsers($mixedUsers);

foreach ($batchResults as $index => $result) {
    echo "User " . ($index + 1) . ": " . $result['name'] . " (" . $result['user_type'] . ")\n";
    echo "  Permissions: " . implode(', ', $result['permissions']) . "\n";
    echo "  Can access admin: " . ($result['can_access_admin'] ? 'Yes' : 'No') . "\n\n";
}

echo "=== LSP Test 3: Authorization ===\n";
echo "Testing resource access with different user types:\n\n";

$resources = ['dashboard', 'admin', 'profile', 'reports'];
$users = [
    'Regular' => $regularUser,
    'Admin' => $adminUser,
    'Guest' => $guestUser
];

foreach ($users as $userType => $user) {
    echo "{$userType} User Access:\n";
    foreach ($resources as $resource) {
        $hasAccess = $userManager->authorizeUserForResource($user, $resource);
        echo "  {$resource}: " . ($hasAccess ? '✓ Allowed' : '✗ Denied') . "\n";
    }
    echo "\n";
}

echo "=== LSP Test 4: Report Generation ===\n";
echo "Generating reports for different user types:\n\n";

foreach ($users as $userType => $user) {
    echo "--- {$userType} User Report ---\n";
    echo $userManager->generateUserReport($user);
    echo "\n";
}

echo "=== LSP PROOF SUMMARY ===\n";
echo "✓ All User subclasses can be used interchangeably\n";
echo "✓ UserManager methods work with any User type\n";
echo "✓ No type checking or instanceof needed\n";
echo "✓ Polymorphism works correctly\n";
echo "✓ Behavior is consistent across all subclasses\n";
echo "\nLiskov Substitution Principle is successfully demonstrated!\n";

echo "</pre>\n";
?>
