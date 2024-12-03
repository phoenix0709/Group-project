<?php
$servername = "db";
$username = "user"; 
$password = "userpassword"; 
$dbname = "ctf_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM leaderboard";
$result = $conn->query($sql);

$leaderboard = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }
}

$conn->close();

echo json_encode($leaderboard);
?>
