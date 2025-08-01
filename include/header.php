<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header class="header">
        <div class="nav-container">
            <a href="index.php" class="logo">MyApp</a>
            <div class="nav-buttons">
                <a href="index.php" class="nav-btn home" href="<?= base_url('index.php'); ?>">Home</a>
                <a href="login.php" class="nav-btn" href="<?= base_url('login.php'); ?>">Login</a>
                <a href="register.php" class="nav-btn register" href="<?= base_url('register.php'); ?>">Register</a>
            </div>
        </div>
    </header>