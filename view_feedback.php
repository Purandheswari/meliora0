<?php
session_start();


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

$type = $_GET['type'];
if ($type == 'positive') {
    $classification = 'positive';
    $title = "Positive Feedbacks";
} else {
    $classification = 'negative';
    $title = "Negative Feedbacks";
}

// Fetch feedback based on classification
$feedbackSql = "SELECT * FROM feedback WHERE classification = ?";
$stmt = $conn->prepare($feedbackSql);
$stmt->bind_param("s", $classification);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: orangered;
            text-align: center;
        }
        .feedback-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .feedback-table th, .feedback-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .feedback-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .nav-item a {
            display: block;
            padding: 10px;
            background: #333;
            color: white;
            text-decoration: none;
            margin: 5px 0;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo $title; ?></h2>
        <table class="feedback-table">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Purpose</th>
                <th>Satisfaction</th>
                <th>Rating</th>
                <th>Submitted At</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['purpose']; ?></td>
                        <td><?php echo $row['satisfaction']; ?></td>
                        <td><?php echo $row['rating']; ?></td>
                        <td><?php echo $row['reg_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No feedback found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
