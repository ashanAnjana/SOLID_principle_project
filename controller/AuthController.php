<?php

require_once __DIR__ . '/../services/SessionManager.php';

class AuthController
{
    private $conn;
    private $sessionManager;

    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
        $this->sessionManager = new SessionManager();
    }

    public function login($email, $password)
    {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->conn->query($query);
        
        if($result->num_rows > 0)
        {
            $user = $result->fetch_assoc();
            // For now, comparing plain text passwords
            // In production, use password_verify() with hashed passwords
            if($password === $user['password'])
            {
                return $user;
            }
        }
        return false;
    }

    public function isUserLoggedIn()
    {
        return $this->sessionManager->isUserLoggedIn();
    }

    public function logout()
    {
        return $this->sessionManager->destroySession();
    }

    public function setUserSession($user)
    {
        $this->sessionManager->setUserSession($user);
        // Regenerate session ID for security after login
        $this->sessionManager->regenerateSessionId();
    }
}
?>
