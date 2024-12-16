<?php
$servername = "db";
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";

if (!isset($_POST['id']) || !isset($_POST['flag'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid input. Both 'id' and 'flag' are required."
    ]);
    exit;
}

$challenge_id = intval($_POST['id']);
$user_flag = trim($_POST['flag']);

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT flag FROM challenges WHERE challenge_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $challenge_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        echo json_encode([
            "status" => "error",
            "message" => "Challenge not found."
        ]);
    } else {
        $correct_flag = $result['flag'];

        if ($user_flag === $correct_flag) {
            echo json_encode([
                "status" => "success",
                "message" => "Correct flag! Well done."
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Incorrect flag. Try again."
            ]);
        }
    }
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
?>
