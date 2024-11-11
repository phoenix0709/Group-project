<?php
require 'index.php';
header("Content-Type: application/json");       

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$difficulty = isset($_GET['difficulty']) ? $_GET['difficulty'] : 'all';
if ($difficulty === 'all') {
    $sql = "SELECT * FROM challenges";
} else {
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM challenges WHERE difficulty = ?");
    $stmt->bind_param("s", $difficulty);
    $stmt->execute();
    $result = $stmt->get_result();
}

$sql_leaderboard = "SELECT username, total_score FROM leaderboard ORDER BY total_score DESC LIMIT 10";
$result_leaderboard = $conn->query($sql_leaderboard);

$data = array(
    "challenges" => array(),
    "leaderboard" => array()
);

// Fetch challenges
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data['challenges'][] = $row;
    }
}

// Fetch leaderboard
if ($result_leaderboard->num_rows > 0) {
    while ($row = $result_leaderboard->fetch_assoc()) {
        $data['leaderboard'][] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>


