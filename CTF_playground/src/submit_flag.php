<?php
// Function to handle flag submission
function submitFlag() {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['challenge_id'], $data['flag'])) {
        sendError(400, 'Invalid input');
        return;
    }

    $challenge_id = $data['challenge_id'];
    $flag = $data['flag'];

    // Xử lý thử thách tĩnh với challenge_id = 100
    if ($challenge_id == 100) { // Challenge ID 100 cho thử thách tĩnh
        $correct_flag = "CTF{easy_static_flag}";
        if ($flag === $correct_flag) {
            echo json_encode(['message' => 'Correct flag!']);
        } else {
            echo json_encode(['message' => 'Incorrect flag!']);
        }
        return;
    }

    // Tiếp tục logic cũ cho các thử thách khác
    $servername = "localhost";  
    $username = "root";         
    $password = "userpassword";             
    $dbname = "ctf_db";         

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        sendError(500, 'Connection failed: ' . $conn->connect_error);
        return;
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT flag FROM challenges WHERE id = ?");
    $stmt->bind_param("i", $challenge_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $challenge = $result->fetch_assoc();

        if ($challenge['flag'] === $flag) {
            echo json_encode(['message' => 'Correct flag!']);
        } else {
            echo json_encode(['message' => 'Incorrect flag!']);
        }
    } else {
        echo json_encode(['message' => 'Challenge not found!']);
    }

    $stmt->close();
    $conn->close();
}

function sendError($status, $message) {
    http_response_code($status);
    echo json_encode(['error' => $message]);
}

// Gọi hàm xử lý
submitFlag();
