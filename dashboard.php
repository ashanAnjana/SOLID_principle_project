<?php 
    include('config/app.php');
    include_once('controller/AuthController.php');
    include_once('controller/SiteController.php');
    
    $auth = new AuthController;
    $site = new SiteController;
    
    // Check if user is logged in
    $site->checkAuth();
    
    include('include/header.php'); 
?>

<div class="container">
    <?php include('message.php'); ?>
    
    <div class="welcome-section">
        <h4>Welcome Back, <?= $_SESSION['user_name']; ?>!</h4>
        <p class="lead">You are successfully logged in to your account.</p>
        
        <div class="user-info">
            <h5>Your Account Information:</h5>
            <p><strong>Name:</strong> <?= $_SESSION['user_name']; ?></p>
            <p><strong>Email:</strong> <?= $_SESSION['user_email']; ?></p>
        </div>
        
        <div class="dashboard-actions">
            <a href="logout.php" class="btn btn-primary" style="background-color: #dc3545; margin-top: 1rem; display: inline-block; text-decoration: none;">Logout</a>
        </div>
    </div>
</div>

<style>
.welcome-section {
    text-align: center;
    padding: 2rem 0;
}

.lead {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 1.5rem;
}

.user-info {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin: 2rem 0;
    text-align: left;
}

.dashboard-actions a {
    padding: 0.75rem 1.5rem;
    border-radius: 5px;
    font-weight: 500;
}
</style>

</body>
</html>
