<?php
// Kết nối cơ sở dữ liệu
require 'index.php';
session_start(); // Bắt đầu phiên làm việc
header("Content-Type: application/json"); // Định dạng phản hồi JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận dữ liệu JSON từ yêu cầu
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra dữ liệu đầu vào
    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Dữ liệu không hợp lệ. Vui lòng cung cấp username và password."]);
        exit();
    }

    $username = trim($data['username']);
    $password = trim($data['password']);

    // Kiểm tra rỗng
    if (empty($username) || empty($password)) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Username và password không được để trống."]);
        exit();
    }

    // Tìm kiếm người dùng trong cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $user['id'];
            http_response_code(200); // OK
            echo json_encode(["message" => "Đăng nhập thành công", "user_id" => $user['id']]);
        } else {
            // Mật khẩu sai
            http_response_code(401); // Unauthorized
            echo json_encode(["error" => "Mật khẩu không chính xác."]);
        }
    } else {
        // Không tìm thấy tài khoản
        http_response_code(404); // Not Found
        echo json_encode(["error" => "Không tìm thấy người dùng."]);
    }
} else {
    // Phương thức không hợp lệ
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Yêu cầu không hợp lệ. Vui lòng sử dụng phương thức POST."]);
}
?>
