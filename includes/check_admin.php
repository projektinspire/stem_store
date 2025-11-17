<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

// Check if user is not an admin
if ($_SESSION['role'] !== 'Admin') {
    // Log unauthorized access attempt
    error_log("Unauthorized access attempt by user ID: " . $_SESSION['user_id'] . " to " . $_SERVER['PHP_SELF']);
    
    // Show access denied message
    die("<div style='text-align:center; margin-top:50px;'>
            <h2>Access Denied</h2>
            <p>You don't have permission to access this page.</p>
            <a href='../index2.php' class='btn btn-primary'>Return to Dashboard</a>
         </div>");
}
?>
