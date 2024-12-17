<?php
session_start();

//Hardcoded credentials
$valid_username = 'user123';
$valid_password = 'password987';

// Function to encode Base64
function encryptRole($role) {
    return base64_encode($role);
}

// Function to decode Base64
function decryptRole($encryptedRole) {
    return base64_decode($encryptedRole);
}

// Check credentials
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Invalidate the session every new login attempt
    $_SESSION['valid'] = false;

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['valid'] = true;  // Set the session to valid if credentials are correct
    }

    if (!$_SESSION['valid']) {  // Check if the session is set to valid
        echo "<h1>Invalid credentials!</h1>";
        echo "<p>Invalid username or password. Try again!</p>";
    } else {
        setcookie("role", encryptRole("user"), time() + 3600, "/"); // Set the cookie for user's role
        header('Location: hid2.php');
        exit(); // Ensure no further code is executed
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Stage 1</title>
</head>
</html>
