<?php
$servername = "db"; 
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
header('Content-Type: application/json');

// Get the request method and path
$request_method = $_SERVER['REQUEST_METHOD'];
$path_info = $_SERVER['REQUEST_URI'] ?? '/';

// Remove query string from request URI
$path_info = strtok($path_info, '?');

// Route requests to the appropriate handler
switch ($path_info) {
    case '/api/users/register':
        if ($request_method === 'POST') {
            require 'users.php';
            registerUser();
        } else {
            sendError(405, 'Method Not Allowed');
        }
        break;

    case '/api/users/login':
        if ($request_method === 'POST') {
            require 'users.php';
            loginUser();
        } else {
            sendError(405, 'Method Not Allowed');
        }
        break;

    case '/api/challenges/submit':
        if ($request_method === 'POST') {
            require 'challenges.php';
            submitFlag();
        } else {
            sendError(405, 'Method Not Allowed');
        }
        break;

    default:
        sendError(404, 'Not Found');
}

// Function to send error responses
function sendError($code, $message) {
    http_response_code($code);
    echo json_encode(['error' => $message]);
    exit;
}
