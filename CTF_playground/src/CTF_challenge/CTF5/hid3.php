<?php
if (isset($_GET['debug']) && base64_decode($_GET['debug']) == 'true') {
    echo "<h1>Congratulations!</h1>";
    echo "<p>Your flag: flag{mUlT1_stAg3_bYpAsS_sUcceSS}</p>";
} else {
    echo "<h1>Welcome, Admin!</h1>";
    echo "<p>You don't seem to be in the right mode to view this page.</p>";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Stage 3</title>
</head>
</html>