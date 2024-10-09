<?php
$servername = "db"; 
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$new_username = $_POST['new-username'];
$new_password = $_POST['new-password'];
$confirm_password = $_POST['confirm-password'];

// Kiểm tra mật khẩu có khớp hay không
if ($new_password !== $confirm_password) {
    echo "Passwords do not match.";
    exit();
}

// Băm mật khẩu trước khi lưu
$password_hash = password_hash($new_password, PASSWORD_BCRYPT);

// Kiểm tra tên người dùng đã tồn tại chưa
$sql_check = "SELECT * FROM users WHERE username=?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $new_username);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "Username already exists. Choose another.";
    exit();
}

// Chèn người dùng mới vào cơ sở dữ liệu
$sql = "INSERT INTO users (username, password_hash) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $new_username, $password_hash);

if ($stmt->execute()) {
    header("Location: /Challenge.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
