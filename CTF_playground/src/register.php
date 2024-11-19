<?php
$servername = "db";
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";
// require 'index.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận dữ liệu JSON từ yêu cầu
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra dữ liệu đầu vào
    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(["error" => "Dữ liệu không hợp lệ. Vui lòng cung cấp username và password."]);
        exit();
    }

    $username = trim($data['username']);
    $password = trim($data['password']);

    // Kiểm tra username rỗng
    if (empty($username) || empty($password)) {
        http_response_code(400);
        echo json_encode(["error" => "Username hoặc password không được để trống."]);
        exit();
    }

    // Kiểm tra độ dài password
    if (strlen($password) < 6) {
        http_response_code(400);
        echo json_encode(["error" => "Mật khẩu phải có ít nhất 6 ký tự."]);
        exit();
    }

    // Kiểm tra username đã tồn tại
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        http_response_code(409); // Conflict
        echo json_encode(["error" => "Username đã tồn tại. Vui lòng chọn tên khác."]);
        exit();
    }

    // Mã hóa mật khẩu bằng bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Thêm người dùng vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        http_response_code(201); // Created
        echo json_encode(["message" => "Đăng ký thành công."]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Lỗi hệ thống. Không thể tạo tài khoản."]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Yêu cầu không hợp lệ. Vui lòng sử dụng phương thức POST."]);
}

