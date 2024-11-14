<?php
$servername = "db";
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$data = json_decode(file_get_contents('php://input'), true);
$challenge_id = intval($data['id']);
$userFlag = $data['flag'];

$sql = "SELECT flag, score FROM challenges WHERE id = $challenge_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $correctFlag = $row['flag'];
    $score = $row['score'];

    if ($userFlag === $correctFlag) {
        echo json_encode(['correct' => true, 'score' => $score]);
    } else {
        echo json_encode(['correct' => false]);
    }
} else {
    echo json_encode(['error' => 'Challenge not found']);
}

$conn->close();
?>
