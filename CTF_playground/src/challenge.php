<?php
$servername = "db"; 
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $challenge_id = intval($_GET['id']);
    $sql = "SELECT * FROM challenges WHERE id = $challenge_id";
} else {
    $sql = "SELECT * FROM challenges";
}

$result = $conn->query($sql);
$challenges = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $challenges[] = $row;
    }
}

$conn->close();

echo json_encode($challenges);
?>
