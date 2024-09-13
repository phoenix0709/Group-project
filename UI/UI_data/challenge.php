<?php
$servername = "db";
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}

$challenges_query = "SELECT * FROM challenges";
$challenges_result = $conn->query($challenges_query);

if ($challenges_result->num_rows > 0) {
    while($row = $challenges_result->fetch_assoc()) {
        echo "<p><strong>Challenge:</strong> " . htmlspecialchars($row['name']) . "</p>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
        echo "<p><strong>Points:</strong> " . htmlspecialchars($row['points']) . "</p>";
    }
} else {
    echo "<p>No challenges available.</p>";
}

$conn->close();
?>
