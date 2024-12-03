<?php
session_start();

$servername = "db";
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    header("Location: login_or_register.html"); 
    exit();
}

$username = $_SESSION['username'];

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT full_name, username, phone, email, dob, gender FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userData = array(
        "full_name" => $row['full_name'],
        "username" => $row['username'],
        "phone" => $row['phone'],
        "email" => $row['email'],
        "dob" => $row['dob'],
        "gender" => $row['gender']
    );
    echo json_encode($userData); 
} else {
    echo json_encode(["error" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
