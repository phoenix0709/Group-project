<?php
$servername = "db"; 
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_data = [
    'full_name' => $_POST['full-name'],
    'new_username' => $_POST['new-username'],
    'new_password' => $_POST['new-password'],
    'confirm_password' => $_POST['confirm-password'],
    'phone_number' => $_POST['phone-number'],
    'new_gmail' => $_POST['new-gmail'],
    'birth_of_date' => $_POST['Birth_of_date'],
    'gender' => $_POST['gender']
];

if ($user_data['new_password'] !== $user_data['confirm_password']) {
    echo "Password and confirmation do not match.";
    exit();
}

$password_hash = password_hash($user_data['new_password'], PASSWORD_BCRYPT);

function register_user($conn, $user_data, $password_hash) {
    $sql = "INSERT INTO users (full_name, username, password_hash, phone_number, gmail, birth_of_date, gender) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", 
        $user_data['full_name'], 
        $user_data['new_username'], 
        $password_hash, 
        $user_data['phone_number'], 
        $user_data['new_gmail'], 
        $user_data['birth_of_date'], 
        $user_data['gender']
    );

    if ($stmt->execute()) {
        echo "Registration successful! Redirecting to login page.";
        header("Location: /login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

register_user($conn, $user_data, $password_hash);

$conn->close();
?>
