<?php
//include('config/app.php');
include_once('controller/RegisterController.php');

if(isset($_POST['register']))
{
    $f_name = validateInput($db->conn, $_POST['first_name']);
    $l_name = validateInput($db->conn, $_POST['last_name']);
    $email = validateInput($db->conn, $_POST['email']);
    $password = validateInput($db->conn, $_POST['password']);
    $confirm_password = validateInput($db->conn, $_POST['confirm_password']);

    $register = new RegisterController;
    $result_password = $register->confirmPassword($password, $confirm_password);
    
    if ($result_password)
    {
        $result_user_exists = $register->isUserExists($email);
        if($result_user_exists->num_rows > 0)
        {
            redirect("User already exists", 'register.php');
        }
        else
        {
            $register->register($f_name, $l_name, $email, $password);
            redirect("User registered successfully", 'register.php');
        }
    } 
    else 
    {
        redirect("Password not match", 'register.php');
    }
}
?>