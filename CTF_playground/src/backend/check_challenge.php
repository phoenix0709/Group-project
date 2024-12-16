<?php
// Include database configuration file
$servername = "db";
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";
/**
 * Function to check a challenge by its ID
 *
 * @param int $challenge_id The ID of the challenge to check
 * @return string JSON response with challenge data or an error message
 */
function check_challenge($challenge_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM challenges WHERE id = ?");
    $stmt->bind_param("i", $challenge_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $challenge = $result->fetch_assoc();
        return json_encode([
            'status' => 'success',
            'data' => $challenge
        ]);
    } else {
        return json_encode([
            'status' => 'error',
            'message' => 'Challenge not found'
        ]);
    }
}

// Handle incoming GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $challenge_id = intval($_GET['id']);
    header('Content-Type: application/json');
    echo check_challenge($challenge_id);
} else {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request'
    ]);
}
?>
