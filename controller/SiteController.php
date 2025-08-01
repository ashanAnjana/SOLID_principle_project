<?php

class SiteController
{
    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    public function getUserData($user_id)
    {
        $query = "SELECT * FROM users WHERE id = '$user_id'";
        $result = $this->conn->query($query);
        
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc();
        }
        return false;
    }

    public function updateUserProfile($user_id, $first_name, $last_name, $email)
    {
        $query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email' WHERE id = '$user_id'";
        $result = $this->conn->query($query);
        return $result;
    }

    public function checkAuth()
    {
        if(!isset($_SESSION['user_id'])) {
            redirect("Please login first", 'login.php', 'warning');
        }
    }
}
?>
