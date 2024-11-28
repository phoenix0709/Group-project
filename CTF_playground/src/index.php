<?php
// Đường dẫn đầy đủ tới file SQLite
$dsn = 'sqlite:/var/www/db/database.db';

try {
    // Kết nối với cơ sở dữ liệu SQLite
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Kiểm tra xem file cơ sở dữ liệu có tồn tại không
    if (!file_exists('/var/www/db/database.db')) {
        die("Database file not found. Please check the path.");
    }
} catch (PDOException $e) {
    // Hiển thị lỗi nếu kết nối thất bại
    die("Connection failed: " . $e->getMessage());
}

// Điều hướng tới trang Login_or_register.html
header("Location: Login_or_register.html");
exit();
?>

