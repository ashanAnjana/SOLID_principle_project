<?php 

class DatabaseConnection
{
    public function __construct()
    {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if($conn->connect_error)
        {
            die("<h2>DataBase Connection failed:</h2>" . $conn->connect_error);
        }
        return $this->conn = $conn;
    }
}
?>