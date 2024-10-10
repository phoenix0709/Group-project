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
    } else {
        echo "Username not found. Please register.";
    }
}

$conn->close();
?>
