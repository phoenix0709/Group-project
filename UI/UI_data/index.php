<?php
$host = 'db';
$db = 'ctf_db';
$user = 'user';
$pass = 'userpassword';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

mysqli_close($conn);
?>
