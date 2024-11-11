<?php
// Define the correct flag
$correct_flag = "CTF{say_}"; // Replace with actual flag for LAN2

// Get the flag from the request (POST/GET)
$user_flag = isset($_POST['flag']) ? $_POST['flag'] : '';

// Check the flag
if ($user_flag === $correct_flag) {
    echo "Correct! Well done.";
} else {
    echo "Incorrect flag.";
}
?>