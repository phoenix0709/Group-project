<?php
$correct_username = 'admin';
$correct_password = 'supersecretpassword';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $correct_username && $password === $correct_password) {
        echo "<h1>Congratulations!</h1>";
        echo "<p>Your flag is: CTF{hihi}</p>";
    } else {
        echo "<h1>Invalid credentials!</h1>";
        echo "<p>Try again.</p>";
    }
} else {
    header('Location: login.html');
    exit;
}
?>
