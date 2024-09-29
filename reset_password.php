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

            // Update password in the database
            $query = "UPDATE `userregistration` SET `pass` = '$new_password' WHERE `email` = '$email'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Password updated successfully
                echo "Password updated successfully.";
                // Clear relevant session variables
                unset($_SESSION['otp']);
                unset($_SESSION['otp_verified']);
                unset($_SESSION['email']);
            } else {
                echo "Failed to update password. Please try again later.";
            }
        } else {
            echo "Email not found in session.";
        }
    } else {
        echo "Connection not established.";
    }

    mysqli_close($conn); // Close database connection
}
?>
