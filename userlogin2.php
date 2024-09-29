<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted form data
    $user = $_POST['username'];
    $pass = $_POST['pass'];
    $date = date("F j, Y, g:i a");

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

    // Prepare SQL query
    $query = "SELECT * FROM `userregistration` WHERE `username` = ? AND `pass` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user details
        $row = $result->fetch_assoc();
        $fname = $row['fname'];
        $lname = $row['lname'];

        // Store user info in session
        $_SESSION['user_id'] = $row['id']; // Assuming 'id' is the unique identifier in your userregistration table
        $_SESSION['username'] = $user;

        // Insert log info (example)
        $query = "INSERT INTO `userloginfo`(`fname`, `lname`, `user`, `date`) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $fname, $lname, $user, $date);
        $stmt->execute();

        // Redirect to afterlogin.php
        header("Location: afterlogin4.php");
        exit();
    } else {
        // Invalid credentials, redirect back to login page with error message
        header("Location: userlogin1.html?error=invalid_credentials");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
