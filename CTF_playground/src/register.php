<?php
$dsn = 'sqlite:/var/www/db/database.db';
try {
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
    exit();
}

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['username']) || !isset($data['password']) || !isset($data['confirm_password'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data. Please provide username, password, and confirm password."]);
        exit();
    }

    $username = trim($data['username']);
    $password = trim($data['password']);
    $confirm_password = trim($data['confirm_password']);

    if ($password !== $confirm_password) {
        http_response_code(400);
        echo json_encode(["error" => "Passwords do not match."]);
        exit();
    }

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode(["error" => "Username already exists."]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password_hash', $password_hash);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["message" => "Registration successful! You can now log in."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error: Could not register the user. Please try again."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method. Please use POST."]);
}
?>
