<?php
$servername = "db";
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

if (isset($_GET['id'])) {
    $challenge_id = intval($_GET['id']);  
    
    $stmt = $conn->prepare("SELECT * FROM challenges WHERE challenge_id = ?");  
    $stmt->bind_param("i", $challenge_id);  
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $challenge = $result->fetch_assoc();
        echo json_encode($challenge);  
    } else {
        echo json_encode(['error' => 'Challenge not found']);  
    }

    $stmt->close();  
} else {
    echo json_encode(['error' => 'No ID provided']);  
}

$conn->close();  
?>
