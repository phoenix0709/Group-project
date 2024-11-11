<?php
// Define the correct flag
$correct_flag = "CTF{hihi}"; // Replace with actual flag for LAN1

// Get the flag from the request (POST/GET)
$user_flag = isset($_POST['flag']) ? $_POST['flag'] : '';

// Check the flag
if ($user_flag === $correct_flag) {
    echo "Correct! Well done.";
} else {
    echo "Incorrect flag.";
}
?>