<?php
// Kết nối cơ sở dữ liệu
require '../index.php'; // Sử dụng file config đã có để kết nối DB
session_start();
header("Content-Type: application/json"); // Định dạng phản hồi là JSON

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Bạn chưa đăng nhập. Vui lòng đăng nhập để tiếp tục."]);
    exit();
}

try {
    // Truy vấn lấy danh sách thử thách
    $sql = "SELECT id, name, description, points FROM challenges ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $challenges = [];
        while ($row = $result->fetch_assoc()) {
            $challenges[] = [
                "id" => $row['id'],
                "name" => $row['name'],
                "description" => $row['description'],
                "points" => $row['points']
            ];
        }
        http_response_code(200); // OK
        echo json_encode($challenges);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(["error" => "Không có thử thách nào được tìm thấy."]);
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Lỗi hệ thống: " . $e->getMessage()]);
}
?>
