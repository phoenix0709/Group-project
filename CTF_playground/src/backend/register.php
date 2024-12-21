<?php
$servername = "db"; 
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error); #check for connect
}
$new_username = $_POST['new-username'];
$new_password = $_POST['new-password'];
$confirm_password = $_POST['confirm-password'];

if ($new_password !== $confirm_password) {
    echo "Password does not match.";
} else {
    $password_hash = password_hash($new_password, PASSWORD_BCRYPT);


    $sql = "INSERT INTO users (username, password_hash) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_username, $password_hash);

    if ($stmt->execute()) {
        header("Location: /frontend/challenges/Challenge.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>