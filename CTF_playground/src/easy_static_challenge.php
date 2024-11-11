<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Challenge</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        form {
            margin: 20px auto;
            width: 300px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            padding: 10px 20px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Welcome to Easy Challenge</h1>
    <p>Can you find the correct flag? Enter it below!</p>

    <!-- Form nhập flag -->
    <form method="POST" action="">
        <label for="flag">Your Flag:</label>
        <input type="text" id="flag" name="flag" required>
        <button type="submit">Submit</button>
    </form>

    <?php
    // Xử lý logic kiểm tra flag
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $flag = $_POST['flag'] ?? '';

        // Flag đúng
        $correct_flag = 'CTF{easy_static_flag}';

        // So sánh flag
        if ($flag === $correct_flag) {
            echo "<p class='success'>Correct flag! You solved the challenge.</p>";
        } else {
            echo "<p class='error'>Incorrect flag! Please try again.</p>";
        }
    }
    ?>
</body>
</html>
