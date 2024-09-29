<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('hostname', 'username', 'password', 'database'); // Update with your database details

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $_POST['query'];
$query = $conn->real_escape_string($query); // Escape the query to prevent SQL injection
$sql = "SELECT * FROM `complaints` WHERE `user` LIKE '%$query%' OR `comp` LIKE '%$query%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usr = $row['user'];
        $comp = $row['comp'];
        echo "<div class='suggestion-item' onclick='selectSuggestion(\"$usr: $comp\")'>$usr: $comp</div>";
    }
} else {
    echo "<div class='suggestion-item'>No results found</div>";
}

$conn->close();
?>
