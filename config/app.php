<?php 
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'solid_principle_project');

include_once('DatabaseConnection.php');
$db = new DatabaseConnection;


function base_url($path = '')
{
    return 'http://localhost/login/' . $path;
}

function redirect($message, $path)
{
    $_SESSION['message'] = $message;
    header('Location: ' . base_url($path));
    exit;
}

function validateInput($dbcon, $input)
{
    return mysqli_real_escape_string($dbcon, $input);
}
?>