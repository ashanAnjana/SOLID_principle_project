<?php 
    include('config/app.php');
    include('include/header.php'); 
    include('code/login_code.php');
?>

<div class="container">
    <h4>Sign In</h4>
    <?php include('message.php'); ?>
    <form action="" method="POST">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary">Sign In</button>
    </form>
    
    <div class="login-link">
        Don't have an account? <a href="register.php">Create one here</a>
    </div>
</div>
</body>
</html>
