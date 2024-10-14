<?php

// Database connection (replace with actual credentials)
function getDatabaseConnection() {
    return new PDO('mysql:host=localhost;dbname=mydb', 'root', '');
}

// Register a new user
function registerUser() {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['username'], $data['email'], $data['password'])) {
        sendError(400, 'Invalid input');
    }

    $username = $data['username'];
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_BCRYPT);

    try {
        $db = getDatabaseConnection();
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);

        echo json_encode(['message' => 'User registered successfully']);
    } catch (PDOException $e) {
        sendError(500, 'Server error: ' . $e->getMessage());
    }
}

// Login a user
function loginUser() {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['username'], $data['password'])) {
        sendError(400, 'Invalid input');
    }

    $username = $data['username'];
    $password = $data['password'];

    try {
        $db = getDatabaseConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Return a token or session ID (simplified version)
            echo json_encode(['message' => 'Login successful', 'user_id' => $user['id']]);
        } else {
            sendError(401, 'Invalid credentials');
        }
    } catch (PDOException $e) {
        sendError(500, 'Server error: ' . $e->getMessage());
    }
}
