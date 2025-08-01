<?php 
    if(isset($_SESSION['message']))
    {
        $message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'success';
        echo "<div class='alert alert-{$message_type}'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
?>