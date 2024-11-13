<?php
session_start();
include 'database.php';

$db = connect_db();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $db->query("SELECT * FROM users WHERE username = '$user' AND password = '$pass'");
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        $_SESSION['username'] = $user;

        $_SESSION['verification_code'] = '123456';
        header("Location: verify.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}

include 'login.html';
?>
