<?php
// Include the autoload file from Composer
require 'vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); // Create a new PHPMailer instance

try {
    // Enable verbose debug output
    $mail->SMTPDebug = 2; // 2 for detailed debug output
    $mail->Debugoutput = 'html'; // Output debug info in HTML format

    // Server settings
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'melioravvit@gmail.com'; // SMTP username
    $mail->Password = 'ejbk jbny djme svlu'; // SMTP password (Google app-specific password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to

    // Recipients
    $mail->setFrom('melioravvit@gmail.com', 'Admin'); // Sender's email address and name
    $mail->addAddress('21bq1a42d3@gmail.com'); // Add a recipient (replace with actual recipient email)

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Test Email'; // Email subject
    $mail->Body = 'This is a test email to verify PHPMailer configuration.'; // Email body content

    $mail->send(); // Send the email
    echo 'Message has been sent'; // Success message
} catch (Exception $e) {
    // Handle exceptions if email is not sent successfully
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
