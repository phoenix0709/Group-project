<?php
$dsn = 'sqlite:/path/to/your/database.sqlite';
$username = null;
$password = null;

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

header("Location: Login_or_register.html");
exit();

// sqlite3 - test
// $dbPath = '/path/to/your/database.sqlite';

// $conn = new SQLite3($dbPath);

// if (!$conn) {
//     die("Connection failed: " . $conn->lastErrorMsg());
// }

// header("Location: Login_or_register.html");
// exit();
?>
