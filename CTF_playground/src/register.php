<?php
$dsn = 'sqlite:/path/to/your/database.sqlite';
$username = null;
$password = null;

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        die("Username already exists.");
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password_hash', $password_hash);

    if ($stmt->execute()) {
        header("Location: Login_or_register.html");
        exit();
    } else {
        die("Error: Could not register the user.");
    }
}
?>
