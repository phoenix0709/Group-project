<?php
// Connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ctf_users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['username'];
    $user_password = $_POST['password'];

main
    // Fetch user data from database
    $sql = "SELECT * FROM users WHERE username = '$user_name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($user_password, $user['password'])) {
            echo "Login successful!";
            // Redirect to the challenge page or any other page
            header("Location: Challenge.html");
            exit();
        } else {
            echo "Invalid password. Please try again.";
        }

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Kiểm tra mật khẩu
    if (password_verify($password, $row['password_hash'])) {
        header("Location: /Challenge.html");
        exit();
main
    } else {
        echo "Username not found. Please register.";
    }
}

$conn->close();
?>
