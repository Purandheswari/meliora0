<?php
session_start();

// Check if OTP is verified
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header('Location: verify_otp.php'); // Redirect if OTP is not verified
    exit();
}

// Handle password reset submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
    $new_password = $_POST['password'];

    // Validate and update password in the database
    // Example: Connect to database and update password
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'project';

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if ($conn) {
        // Use the email stored in session to update the password
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];

            // Update password in the database (without hashing)
            $query = "UPDATE `userregistration` SET `pass` = '$new_password' WHERE `email` = '$email'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Password updated successfully
                $message = "Password updated successfully.";
                // Clear relevant session variables
                unset($_SESSION['otp']);
                unset($_SESSION['otp_verified']);
                unset($_SESSION['email']);
            } else {
                $error_message = "Failed to update password. Please try again later.";
            }
        } else {
            $error_message = "Email not found in session.";
        }
    } else {
        $error_message = "Connection not established.";
    }

    mysqli_close($conn); // Close database connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #666;
            text-align: left;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>

        <?php if (isset($message)) : ?>
            <div class="message success"><?php echo $message; ?></div>
            <p>You can now <a href='userlogin1.html'>login</a> with your new password.</p>
        <?php elseif (isset($error_message)) : ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php else : ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="password">New Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <button type="submit">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
