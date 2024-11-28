<?php

$dsn = 'sqlite:/var/www/db/database.db';
try {
    $conn = new PDO($dsn); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
    exit();
}

session_start(); 
header("Content-Type: application/json"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data. Please provide both username and password."]);
        exit();
    }

    $username = trim($data['username']);
    $password = trim($data['password']);

    if (empty($username) || empty($password)) {
        http_response_code(400);
        echo json_encode(["error" => "Username and password cannot be empty."]);
        exit();
    }

    // Query the database to find the user
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            http_response_code(200); 
            echo json_encode(["message" => "Login successful", "user_id" => $user['id']]);
        } else {
            http_response_code(401); 
            echo json_encode(["error" => "Incorrect password."]);
        }
    } else {
        http_response_code(404); 
        echo json_encode(["error" => "User not found."]);
    }
} else {

    http_response_code(405); 
    echo json_encode(["error" => "Invalid request method. Please use POST."]);
}
?>
