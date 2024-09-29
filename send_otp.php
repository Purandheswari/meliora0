<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Check if email is submitted
if (isset($_POST['email'])) {
    // Generate a random OTP (6-digit)
    $otp = rand(100000, 999999);

    // Store OTP and email in session for verification
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $_POST['email']; // Store email in session

    // Retrieve user's email from form submission
    $to = $_POST['email'];
    $subject = 'Password Reset OTP';
    $message = 'Your OTP for password reset is: ' . $otp;

    // Send email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings for Gmail SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'melioravvit@gmail.com'; // Replace with your actual email address
        $mail->Password = 'ejbk jbny djme svlu'; // Replace with your Gmail app-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('melioravvit@gmail.com', 'Meliora'); // Static sender Gmail address
        $mail->addAddress($to); // Dynamic recipient Gmail address

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Enable verbose debug output
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';

        // Attempt to send email
        if ($mail->send()) {
            echo 'OTP sent successfully to ' . $to;
            // Redirect to OTP verification page
            header('Location: verify_otp.php');
            exit();
        } else {
            echo 'Failed to send OTP. Please try again later.';
            echo '<br>Error: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Email not provided.';
}
?>
