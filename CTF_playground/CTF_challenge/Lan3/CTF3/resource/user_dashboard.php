<?php
session_start();

// Check if the user is logged in and has the correct role
if (isset($_COOKIE['role'])) {
    if ($_COOKIE['role'] === 'admin') {
        // Redirect to admin dashboard if role is admin
        header("Location: admin_dashboard.php");
        exit();
    } elseif ($_COOKIE['role'] === 'user') {
        header("Location: user_dashboard.html");
        // Display user-specific content here
    } else {
        echo "Unknown role!";
    }
} else {
    // Redirect to login page if role is not set
    header("Location: login.html");
    exit();
}
?>
