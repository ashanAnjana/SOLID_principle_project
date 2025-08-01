<?php

class RegisterController
{
    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }
    public function register($f_name, $l_name, $email, $password)
    {
        $query = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$f_name', '$l_name', '$email', '$password')";
        $result = $this->conn->query($query);
        return $result;
    }

    public function isUserExists($email)
    {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->conn->query($query);
        return $result;
    }

    public function confirmPassword($password, $confirm_password)
    {
        if($password != $confirm_password)
        {
            return false;
        }
        return true;
    }
}
