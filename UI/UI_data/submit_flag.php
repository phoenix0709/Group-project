<?php
$correct_flag = "FLAG{correct_flag}";
$user_flag = $_POST['flag'];

if ($user_flag === $correct_flag) {
    echo "Correct flag! You earned 100 points!";
} else {
    echo "Incorrect flag. Try again!";
}
?>
