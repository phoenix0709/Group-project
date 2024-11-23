<?php
// Kết nối cơ sở dữ liệu
require 'index.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data. Please provide username and password."]);
        exit();
    }

    $username = trim($data['username']);
    $password = trim($data['password']);

    if (empty($username) || empty($password)) {
        http_response_code(400);
        echo json_encode(["error" => "Username or password cannot be empty."]);
        exit();
    }

    if (strlen($password) < 6) {
        http_response_code(400);
        echo json_encode(["error" => "Password must be at least 6 characters long."]);
        exit();
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        http_response_code(409);
        echo json_encode(["error" => "Username already exists. Please choose a different username."]);
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(["message" => "Registration successful."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "System error. Unable to create account."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Invalid request. Please use the POST method."]);
}
?>
