<?php
include('config/app.php');
include_once('controller/AuthController.php');

$auth = new AuthController;
$auth->logout();

redirect("You have been logged out successfully", 'login.php', 'success');
?>
