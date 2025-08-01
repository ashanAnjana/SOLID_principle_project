<?php
include_once('controller/AuthController.php');

if(isset($_POST['login']))
{
    $email = validateInput($db->conn, $_POST['email']);
    $password = validateInput($db->conn, $_POST['password']);

    $auth = new AuthController;
    $user = $auth->login($email, $password);
    
    if($user)
    {
        $auth->setUserSession($user);
        redirect("Login successful! Welcome " . $user['first_name'], 'dashboard.php', 'success');
    }
    else
    {
        redirect("Invalid email or password", 'login.php', 'danger');
    }
}
?>
