<?php
$username = $_POST['user'];
$compid = $_POST['compid'];
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="main.css">
    <title>Admin</title>
    <style>
        input {
            margin: 20px;
        }
        .nav-item {
            padding: 0px;
            width: 100%;
            color: white;
        }
        .btn1 {
            width: 200px;
            padding: 20px;
        }
        .btn1:hover {
            background: #17a2b8;
        }
        .navbar ul {
            padding: 0px;
            border: 1px solid white;
            width: 100%;
        }
        .now {
            display: none;
        }
        .navbar {
            background-color: black;
        }
		.btn:hover{
			background-color:orangered;
		}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <h1 class="navbar-brand">Admin</h1>
            <div class="ml-auto">
                <a class="btn btn-success mr-2" href="afteradminlogin.php">Back to Dashboard</a>
                <a class="btn btn-danger" href="adminlogin1.html">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 style="padding-top: 10px;">Complete the In-progress complaint here</h2>
        <hr />
        <form class="forum" method="POST" action="solveinpro2.php">
            <h5>
                USER NAME
                <input type="text" name="user" value="<?php echo $username;?>" class="now">
                <input type="text" name="complaintnum" value="<?php echo $compid;?>" class="now">
                <p class="form-control" style="width: 25%; display: inline-block; background: lightgrey;"><?php echo $username;?></p>
                COMPLAINT NUMBER
                <p class="form-control" style="width: 15%; display: inline-block; background: lightgrey;"><?php echo $compid;?></p>
                <hr />
                Enter Remarks here<br />
                <textarea type="text" name="remark" class="form-control" style="height: 200px" placeholder="Enter Remark here to complete this complaint."></textarea>
                <input type="submit" value="Complete this Complaint" class="btn btn-success" style="padding-left: 2%; padding-right: 2%; margin-left: 5%;">
                <a class="btn btn-light" style="padding-left: 2%; padding-right: 2%; margin-left: 1%;" href="afteradminlogin.php">Back to Portal</a>
            </h5>
        </form>
    </div>
</body>
</html>
