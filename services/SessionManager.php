<?php

/**
 * SessionManager - Handles all session-related operations
 * Follows Single Responsibility Principle by focusing only on session management
 */
class SessionManager
{
    /**
     * Start a new session if not already started
     */
    public function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set user session data after successful login
     * 
     * @param array $user User data from database
     */
    public function setUserSession($user)
    {
        $this->startSession();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['first_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['login_time'] = time();
    }

    /**
     * Check if user is currently logged in
     * 
     * @return bool True if user is logged in, false otherwise
     */
    public function isUserLoggedIn()
    {
        $this->startSession();
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    /**
     * Get current logged-in user ID
     * 
     * @return int|null User ID or null if not logged in
     */
    public function getCurrentUserId()
    {
        $this->startSession();
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    }

    /**
     * Get current logged-in user name
     * 
     * @return string|null User name or null if not logged in
     */
    public function getCurrentUserName()
    {
        $this->startSession();
        return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
    }

    /**
     * Get current logged-in user email
     * 
     * @return string|null User email or null if not logged in
     */
    public function getCurrentUserEmail()
    {
        $this->startSession();
        return isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;
    }

    /**
     * Get all user session data
     * 
     * @return array|null User session data or null if not logged in
     */
    public function getUserSessionData()
    {
        $this->startSession();
        if (!$this->isUserLoggedIn()) {
            return null;
        }

        return [
            'user_id' => $_SESSION['user_id'],
            'user_name' => $_SESSION['user_name'],
            'user_email' => $_SESSION['user_email'],
            'login_time' => $_SESSION['login_time'] ?? null
        ];
    }

    /**
     * Update session data
     * 
     * @param string $key Session key to update
     * @param mixed $value New value
     */
    public function updateSessionData($key, $value)
    {
        $this->startSession();
        $_SESSION[$key] = $value;
    }

    /**
     * Remove specific session data
     * 
     * @param string $key Session key to remove
     */
    public function removeSessionData($key)
    {
        $this->startSession();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destroy user session (logout)
     * 
     * @return bool True on success
     */
    public function destroySession()
    {
        $this->startSession();
        
        // Clear all session variables
        $_SESSION = [];
        
        // Delete session cookie if it exists
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy the session
        session_destroy();
        return true;
    }

    /**
     * Regenerate session ID for security
     * Useful after login to prevent session fixation attacks
     */
    public function regenerateSessionId()
    {
        $this->startSession();
        session_regenerate_id(true);
    }

    /**
     * Check if session has expired based on timeout
     * 
     * @param int $timeout Timeout in seconds (default: 30 minutes)
     * @return bool True if session has expired
     */
    public function isSessionExpired($timeout = 1800)
    {
        $this->startSession();
        
        if (!isset($_SESSION['login_time'])) {
            return true;
        }
        
        return (time() - $_SESSION['login_time']) > $timeout;
    }

    /**
     * Set session timeout warning
     * 
     * @param int $warningTime Time in seconds before expiry to show warning
     */
    public function setSessionTimeoutWarning($warningTime = 300)
    {
        $this->startSession();
        $_SESSION['timeout_warning'] = time() + $warningTime;
    }

    /**
     * Flash message functionality - set a message that will be shown once
     * 
     * @param string $key Message key
     * @param string $message Message content
     */
    public function setFlashMessage($key, $message)
    {
        $this->startSession();
        $_SESSION['flash_messages'][$key] = $message;
    }

    /**
     * Get and remove flash message
     * 
     * @param string $key Message key
     * @return string|null Message content or null if not found
     */
    public function getFlashMessage($key)
    {
        $this->startSession();
        
        if (isset($_SESSION['flash_messages'][$key])) {
            $message = $_SESSION['flash_messages'][$key];
            unset($_SESSION['flash_messages'][$key]);
            return $message;
        }
        
        return null;
    }

    /**
     * Get all flash messages and clear them
     * 
     * @return array All flash messages
     */
    public function getAllFlashMessages()
    {
        $this->startSession();
        
        $messages = $_SESSION['flash_messages'] ?? [];
        unset($_SESSION['flash_messages']);
        
        return $messages;
    }
}

?>
