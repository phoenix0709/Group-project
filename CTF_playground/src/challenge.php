<?php
require 'index.php';
header("Content-Type: application/json");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$difficulty = isset($_GET['difficulty']) ? $_GET['difficulty'] : 'all';

if ($difficulty === 'all') {
    $sql = "SELECT id, name, description, difficulty FROM challenges";
    $result = $conn->query($sql);
} else {
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, name, description, difficulty FROM challenges WHERE difficulty = ?");
    $stmt->bind_param("s", $difficulty);
    $stmt->execute();
    $result = $stmt->get_result();
}

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
