<?php
require 'vendor/autoload.php'; // Adjust path as per your project structure

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$compnum = $_POST["complaintnum"];
$user = $_POST['user'];
$remark = $_POST['remark'];

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'project';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start transaction
$conn->begin_transaction();

try {
    // Fetch the complaint details from inprogresscomp
    $sql = "SELECT * FROM inprogresscomp WHERE compnum = '$compnum'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_email = $row['user']; // Get the email to use later

        // Insert the complaint into completedcomp with the remark
        // Send email notification
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'melioravvit@gmail.com'; // Your Gmail address
        $mail->Password = 'ejbk jbny djme svlu'; // Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipient email address
        $mail->addAddress('21bq1a42d3@vvit.net'); // Use the email fetched earlier

        // Email content
        $mail->setFrom('melioravvit@gmail.com', 'Admin');
        $mail->isHTML(true);
        $mail->Subject = 'Completion Notification';
        $mail->Body = 'Your issue/complaint has been resolved successfully.';

        // Send email
        $mail->send();
        echo 'Message has been sent and complaint updated successfully.';

        $insert_sql = "INSERT INTO completedcomp (compnum, user, remark) VALUES ('$compnum', '$user', '$remark')";
        $conn->query($insert_sql);

        // Delete the complaint from inprogresscomp
        $delete_sql = "DELETE FROM inprogresscomp WHERE compnum = '$compnum'";
        $conn->query($delete_sql);

        // Commit transaction
        $conn->commit();


    } else {
        echo "No complaint found with number: $compnum";
        $conn->rollback();
    }

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "Error updating complaint: " . $e->getMessage();
}

$conn->close();
?>
