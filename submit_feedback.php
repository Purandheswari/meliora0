<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$purpose = $_POST['purpose'];
$satisfaction = $_POST['satisfaction'];
$rating = $_POST['rating'];

// Classify the feedback
$classification = ($rating >= 3) ? 'positive' : 'negative';

$sql = "INSERT INTO feedback (name, email, purpose, satisfaction, rating, classification)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $email, $purpose, $satisfaction, $rating, $classification);

if ($stmt->execute()) {
    echo "Feedback submitted successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
