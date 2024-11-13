<?php
require 'index.php';
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Bạn chưa đăng nhập. Vui lòng đăng nhập để tiếp tục."]);
    exit();
}

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "ID thử thách không được cung cấp."]);
    exit();
}

$challenge_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT id, name, description, points FROM challenges WHERE id = ?");
$stmt->bind_param("i", $challenge_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $challenge = $result->fetch_assoc();
    http_response_code(200);
    echo json_encode($challenge);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Thử thách không được tìm thấy."]);
}
