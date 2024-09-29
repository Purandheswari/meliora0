<?php
$msg = ''; // Initialize the message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize input
    $uname = trim($_POST["username"]);
    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
    $mail = trim($_POST["email"]);
    $ph = trim($_POST["phone"]);
    $gender = trim($_POST["gender"]);
    $passw = trim($_POST["pass"]);
    $date = date("F j, Y, g:i a");

    // Validate email format (must end with .net)
    if (substr($mail, -8) !== "vvit.net") {
        $msg = "<h4>Email must end with '.net'. Please try again.</h4>";
    } else {
        // Database connection parameters
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

        // Check if username already exists
        $query = "SELECT * FROM `userregistration` WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Generate alternative username suggestions
            function generateRandomString($length = 4) {
                return substr(str_shuffle(str_repeat($x='0123456789', ceil($length/strlen($x)) )),1,$length);
            }

            $suggestions = "";
            for ($i = 0; $i < 5; $i++) {
                $suggestions .= "<li class='list-group-item list-group-item-light'>You can try " . $uname . generateRandomString() . "</li>";
            }

            $msg = "<h4>Username '$uname' already exists. Please try again with a different username.</h4>
                    <br />
                    <ol class='list-group list-group-flush'>$suggestions<hr /></ol>";
        } else {
            // Insert new user into database
            $query = "INSERT INTO `userregistration`(`username`, `fname`, `lname`, `email`, `phone`, `gender`, `pass`, `date`) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssssss", $uname, $fname, $lname, $mail, $ph, $gender, $passw, $date);

            if ($stmt->execute()) {
                $msg = "<h6 style='padding:10px'>Signed Up Successfully!! Now you can <a href='userlogin1.html'>Login here</a>
                        <i style='font-size:24px ;color:red;float:right' class='fa'>&#xf046;</i></h6>";
            } else {
                $msg = "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $conn->close();
    }
} else {
    // Redirect to registration form if accessed directly without POST data
    header("Location: userreg1.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Result</title>
    <style>
        body {
            background-image: url("comp.jpg");
            background-repeat: no-repeat;
            background-width: 100%;
            background-height: 100%;
            background-size: cover;
        }
        .container {
            background: white;
            margin-top: 10px;
            border: 1px solid black;
            border-radius: 10px;
        }
        .nav-ite {
            color: orangered;
            height: 10%;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <nav class="navbar-nav navbar-expand-sm bg-dark">
        <div class="nav-ite" style="margin-left:2%">
            <h2 onclick='window.new("index.html");' style="cursor:pointer">Meliora</h2>
        </div>
    </nav>
    <div class="container">
        <h6><?php echo $msg;?></h6>
    </div>
</body>
</html>
