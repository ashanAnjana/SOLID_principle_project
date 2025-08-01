<?php 
    include('config/app.php');
    include('include/header.php'); 
    include('code/authenticat_code.php');
?>

<div class="container">
    <h4>Create Account</h4>
    <?php include('message.php'); ?>
    <form action="" method="POST">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" name="register" class="btn btn-primary">Create Account</button>
    </form>
    
    <div class="login-link">
        Already have an account? <a href="login.php">Sign in here</a>
    </div>
</div>