<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    
    if ($code === $_SESSION['verification_code']) {
        echo "Verification successful! Flag: FLAG{verification_bypassed}";
    } else {
        $error = "Invalid verification code!";
    }
}

include 'verify.html';
?>
