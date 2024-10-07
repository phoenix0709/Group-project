<?php
header('X-Flag-Part1: CTF{say_}');

echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head><meta charset="UTF-8"><title>CTF Challenge - In Progress</title></head>';
echo '<body><h1>Challenge In Progress...</h1></body>';
echo '<body><h2>May be you need check the Network and try again</h2></body>';
echo '<script>';
echo 'setTimeout(function() {';
echo '  fetch("hidden.php");'; 
echo '}, 2000);'; 
echo '</script>';
echo '</html>';
?>
