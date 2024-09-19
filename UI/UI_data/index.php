<?php
$servername = "db"; 
$username = "user";
$password = "userpassword";
$dbname = "ctf_db";


$conn = new mysqli($servername, $username, $password, $dbname);
#common format to connect to db in docker
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
