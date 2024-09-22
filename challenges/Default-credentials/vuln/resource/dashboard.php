<?php
// Default credentials (admin:password)
$valid_username = 'admin';
$valid_password = 'password';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username === $valid_username && $password === $valid_password) {
        echo "<h1>Congratulations!</h1>";
        echo "<p>Here's your flag: CTF{security_default_credentials}</p>";
    } else {
        echo "<h1>Invalid credentials!</h1>";
        echo "<p>Invalid username or password. Try again!</p>";
    }
}   else {
        header('Location: login.html');
        exit;
}
?>