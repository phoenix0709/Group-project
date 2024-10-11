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
main

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full-name'];
    $user_name = $_POST['new-username'];
    $user_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];
    $phone_number = $_POST['phone-number'];
    $email = $_POST['new-gmail'];
    $birth_date = $_POST['Birth_of_date'];
    $gender = $_POST['gender'];

    // Check if passwords match
    if ($user_password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Check if username already exists
    $sql = "SELECT * FROM users WHERE username = '$user_name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Username already exists. Choose another.";
    } else {
        // Hash the password
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        // Insert user data into database
        $sql = "INSERT INTO users (full_name, username, password, phone_number, email, birth_date, gender) 
                VALUES ('$full_name', '$user_name', '$hashed_password', '$phone_number', '$email', '$birth_date', '$gender')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
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
main
}

$stmt->close();
$conn->close();
?>
