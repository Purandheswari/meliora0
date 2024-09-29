<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST['otp'];

    // Verify OTP
    if (isset($_SESSION['otp']) && $_SESSION['otp'] == $otp) {
        // OTP is valid, redirect to password reset form
        $_SESSION['otp_verified'] = true; // Flag to indicate OTP was verified
        header('Location: reset_password_form.php');
        exit();
    } else {
        // OTP is invalid or expired
        $_SESSION['otp_verification_failed'] = true; // Flag to indicate verification failure
        header('Location: verify_otp.php'); // Redirect back to OTP verification page
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 320px;
        }
        h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 10px;
            color: #555555;
        }
        input[type=text] {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
        }
        button[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button[type=submit]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>

        <?php
        if (isset($_SESSION['otp_verification_failed'])) {
            echo '<p class="error-message">Invalid or expired OTP. Please try again.</p>';
            unset($_SESSION['otp_verification_failed']); // Clear the flag after displaying the message
        }
        ?>

        <form action="verify_otp.php" method="POST">
            <label for="otp">Enter OTP:</label>
            <input type="text" id="otp" name="otp" required>
            <button type="submit">Verify OTP</button>
        </form>
    </div>
</body>
</html>
