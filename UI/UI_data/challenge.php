<?php
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "ctf_db";         


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$difficulty = isset($_GET['difficulty']) ? $_GET['difficulty'] : 'all';
if ($difficulty === 'all') {
    $sql = "SELECT * FROM challenges";
} else {
    $sql = "SELECT * FROM challenges WHERE difficulty = '$difficulty'";
}

$result = $conn->query($sql);


$sql_leaderboard = "SELECT username, total_score FROM leaderboard ORDER BY total_score DESC LIMIT 10";
$result_leaderboard = $conn->query($sql_leaderboard);

$data = array(
    "challenges" => array(),
    "leaderboard" => array()
);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data['challenges'][] = $row;
    }
}


if ($result_leaderboard->num_rows > 0) {
    while($row = $result_leaderboard->fetch_assoc()) {
        $data['leaderboard'][] = $row;
    }
}


header('Content-Type: application/json');
echo json_encode($data);


$conn->close();
?>
