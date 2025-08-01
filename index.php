<?php
    include('config/app.php');
    include_once('controller/AuthController.php');
    
    $auth = new AuthController;
    $isLoggedIn = $auth->isUserLoggedIn();
    
    include('include/header.php');
?>

<div class="container">
    <?php include('message.php'); ?>
    
    <?php if($isLoggedIn): ?>
        <!-- Redirect logged-in users to dashboard -->
        <script>window.location.href = 'dashboard.php';</script>
    <?php else: ?>
        <!-- Content for guests -->
        <div class="hero-section">
            <h1>Welcome to MyApp</h1>
            <p class="lead">Your secure login and registration system</p>
            
            <div class="features" style="margin-top: 3rem;">
                <h5>Features:</h5>
                <ul style="text-align: left; max-width: 400px; margin: 1rem auto;">
                    <li>Secure user registration</li>
                    <li>Email-based authentication</li>
                    <li>Session management</li>
                    <li>Responsive design</li>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.hero-section, .welcome-section {
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

.cta-buttons a {
    padding: 0.75rem 1.5rem;
    border-radius: 5px;
    font-weight: 500;
}

.features ul {
    list-style-type: none;
    padding: 0;
}

.features li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.features li:last-child {
    border-bottom: none;
}
</style>

</body>
</html>