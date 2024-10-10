<?php
session_start();

// Function to encode Base64
function encryptRole($role) {
    return base64_encode($role);
}

// Function to decode Base64
function decryptRole($encryptedRole) {
    return base64_decode($encryptedRole);
}

// Set the role of the user
if (isset($_COOKIE['role'])) {
    $role = decryptRole($_COOKIE['role']);
} else {
    $role = 'user';
}

// Check for user's role
if ($role === 'admin') {
    header('Location: hid3.php');
} else {
    echo "<h1>Welcome!</h1>";
    echo "<p>You are an user. Nothing to see here.</p>";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Stage 2</title>
</head>
</html>