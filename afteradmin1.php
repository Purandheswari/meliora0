<?php
session_start();
$servername='localhost';
$username='root';
$password='';
$dbname='project';

$conn=mysqli_connect($servername,$username,$password,$dbname);
if($conn)
{
	$query1="SELECT * FROM `complaints`";
	$result=mysqli_query($conn,$query1);
	$pend=0;
	$full=0;
	if($result)
	{
		while($row=mysqli_fetch_assoc($result))
		{
			
				$cme=$row['pending'];
				if($cme=='1')
				{
					$pend++;
				}
			
		}
	}
	$full+=$pend;
	$query1="SELECT * FROM `completedcomp`";
	$result=mysqli_query($conn,$query1);
	$compl=0;
	if($result)
	{
		while($row=mysqli_fetch_assoc($result))
		{
					$full++;
					$compl++;	
			
		}
	}
	$query1="SELECT * FROM `inprogresscomp`";
	$result=mysqli_query($conn,$query1);
	$inpro=0;
	if($result)
	{
		while($row=mysqli_fetch_assoc($result))
		{
				
					$inpro++;	
					$full++;
			
		}
	}

}
$positiveCountSql = "SELECT COUNT(*) AS count FROM feedback WHERE classification = 'positive'";
$positiveCountResult = $conn->query($positiveCountSql);
$positiveCount = $positiveCountResult->fetch_assoc()['count'];

$negativeCountSql = "SELECT COUNT(*) AS count FROM feedback WHERE classification = 'negative'";
$negativeCountResult = $conn->query($negativeCountSql);
$negativeCount = $negativeCountResult->fetch_assoc()['count'];
// Include the PHPMailer script and the sendEmail function
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'db_connection.php'; // Your database connection file

if (isset($_POST['compid']) && isset($_POST['user'])) {
    $compid = $_POST['compid'];
    $user = $_POST['user'];

    // Fetch the email address of the user
    $query = "SELECT u.email FROM userregistration u JOIN complaints c ON u.username = c.user WHERE c.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $compid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userEmail = $row['mail'];

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'melioravvit@gmail.com';             // SMTP username
            $mail->Password = 'ejbk jbny djme svlu';              // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('melioravvit@gmail.com', 'Admin');
            $mail->addAddress('21bq1a42d3@vvit.net');                        // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Complaint Resolved';
            $mail->Body    = 'Dear ' . $user . ',<br><br>Your complaint with ID ' . $compid . ' has been resolved.<br><br>Best regards,<br>Admin';
            $mail->AltBody = 'Dear ' . $user . ',\n\nYour complaint with ID ' . $compid . ' has been resolved.\n\nBest regards,\nAdmin';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No user found with the given complaint ID.";
    }
} else {
    echo "Invalid request.";
}

?>

<html>
	<head>   
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="main.css">
  <title>Meliora</title>
  
  
  
  <style>

	body{
		color: white;
	}
	input{
		margin:20px;
	}
    .card {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      margin-bottom: 30px;
    }

    .card-body {
      font-size: 1.2em;
	  width: 320px;
	  height: 150px;
    }

    .card-footer {
      font-size: 0.9em;
    }

    .chart-container {
      position: relative;
      height: 40vh;
      width: 100%;
    }

	.nav-item{
		padding:0px;
		width:100%;
        color: white;
	}
	.bg-info1{
		background-color: black;
	}
	.bg-dark1{
		background-color: black;
	}
	.btn1{
		width:200px;
		padding:20px;
		background-color:orange;
	}
	.btn1:hover{
		background:black;
	}
	.tab-hov{
		background-color: white;
		color:black;
	}
	
	.navbar ul{
		padding:0px;
	
		width:100%;
	}
	#file1,#file2,#file3{
				display:inline-block;
				font-size:160px;
				margin-left:50px;
				color:gray;
				padding:20px;
				border-bottom:1px solid black;
			}
			#file1:hover{
				border:1px solid black;
				color:orange;
			}
			#file1:hover #pen{
				display:block;
			}
			#file2:hover{
				border:1px solid black;
				color:orange;
			}
				#file2:hover #pen2{
				display:block;
			}
			#file3:hover{
				border:1px solid black;
				color:orange;
			}	#file3:hover #pen3{
				display:block;
			}
			.tr{
				width:auto;
				float;left;
				border:1px solid black;
			}
			h5 {
				padding:15px;
			}
			
			#file12:hover #pen{
				display:block;
			}
			#pen,#pen2,#pen3{
				display:none;
				font-size:18px;
				text-align:center;
				border-bottom:0.5px solid black;
			}
			#specialchk
			{
				background-color:black;
				color:white;
				float:right;
				border:1px solid white;
				border-radius:10px;
				width:auto;
			}
			
			h6{
				padding:10px;
				border-bottom:1px solid black;
				border-left:1px solid black;
				border-right:1px solid black;
			}
			#span{
				color:black;
				padding:5px;
			}
			.now{
				display:none;
			}
			#remark{
				color:grey;
				font-size:20px;
			}
			.thead{
				font-size:large;
			}
            .search-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .search-container input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-left: 10px;
        }
        .search-container .search-icon {
            font-size: 20px;
        }
        .complaint-item {
            display: block;
        }


  </style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>

function filterComplaints(event) {
    const searchTerm = event.target.value;
    if (searchTerm.length > 0) {
        $.ajax({
            url: 'search_complaints.php',
            type: 'POST',
            data: { query: searchTerm },
            success: function (data) {
                console.log(data); // Log the returned data
                $('#suggestions').html(data).show();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    } else {
        $('#suggestions').hide();
    }
}

function selectSuggestion(suggestion) {
    $('#searchBar').val(suggestion);
    $('#suggestions').hide();
    // Optionally, you can trigger another function here to filter the displayed complaints based on the selected suggestion
}


    // Optionally, you can trigger another function here to filter the displayed complaints based on the selected suggestio
	
			function callsh()
			{
				if(document.getElementById("sh_menu").style.display=='block')
				{
					document.getElementById("sh_menu").style.display='none';
				}
				else {
					document.getElementById("sh_menu").style.display='block';
				}
			}
			function comp()
			{
				var p=document.getElementById("p_comp");
				var f=document.getElementById("f_comp");
				var i=document.getElementById("i_comp");
				if(document.getElementById('ccomp').style.display=='block')
				{
					p.style.display='none';
					document.getElementById('ccomp').style.display='none';
					f.style.display='none';
					i.style.display='none';
					
				}
				else
				{
					p.style.display='block';
					document.getElementById('ccomp').style.display='block';
					f.style.display='block';
					i.style.display='block';
					
				}
			}
			function manageuser(){
				var l=document.getElementById("l_user");
				if(l.style.display=='none')
				{
					l.style.display='block';
					document.getElementById('a_user').style.display='block';
				}
				else
				{
					l.style.display='none';
					document.getElementById('a_user').style.display='none';
					
				}
			}
			function dashboard()
			{
				var dash=document.getElementById('dashboard');
				var luser=document.getElementById('logindata');
				var auser=document.getElementById('alluser');
				var full=document.getElementById('fullhistory');
				var inpro=document.getElementById('inprocomp');
				var comp=document.getElementById('complcomp');
				var pend=document.getElementById('pending');
				if(dash.style.display=='block')
				{
					luser.style.display='none';
					auser.style.display='none';
					full.style.display='none';
					inpro.style.display='none';
					comp.style.display='none';
					pend.style.display='none';
				}
				else
				{
					dash.style.display='block';
					luser.style.display='none';
					auser.style.display='none';
					full.style.display='none';
					inpro.style.display='none';
					comp.style.display='none';
					pend.style.display='none';
				}
			}
			function pending()
			{
				var pend=document.getElementById('pending');
				var dash=document.getElementById('dashboard');
				var luser=document.getElementById('logindata');
				var auser=document.getElementById('alluser');
				var full=document.getElementById('fullhistory');
				var inpro=document.getElementById('inprocomp');
				var comp=document.getElementById('complcomp');
				if(pend.style.display=='block')
				{
					dash.style.display='none';
					luser.style.display='none';
					auser.style.display='none';
					full.style.display='none';
					inpro.style.display='none';
					comp.style.display='none';
				}
				else
				{
					
					pend.style.display='block';
					dash.style.display='none';
					luser.style.display='none';
					auser.style.display='none';
					full.style.display='none';
					inpro.style.display='none';
					comp.style.display='none';
				}
				
			}
				function complcomp()
			{
				var comp=document.getElementById('complcomp');
				var pend=document.getElementById('pending');
				var dash=document.getElementById('dashboard');
				var luser=document.getElementById('logindata');
				var auser=document.getElementById('alluser');
				var full=document.getElementById('fullhistory');
				var inpro=document.getElementById('inprocomp');
				if(comp.style.display=='block')
				{
					dash.style.display='none';
					luser.style.display='none';
					auser.style.display='none';
					full.style.display='none';
					inpro.style.display='none';
					pend.style.display='none';
				}
				else
				{
					
					comp.style.display='block';
					dash.style.display='none';
					luser.style.display='none';
					auser.style.display='none';
					full.style.display='none';
					inpro.style.display='none';
					pend.style.display='none';
				}
				
			}	
			function inpro()
			{
				var inpro=document.getElementById('inprocomp');
				var comp=document.getElementById('complcomp');
				var pend=document.getElementById('pending');
				var dash=document.getElementById('dashboard');
				var luser=document.getElementById('logindata');
				var auser=document.getElementById('alluser');
				var full=document.getElementById('fullhistory');
				if(inpro.style.display=='block')
				{
					dash.style.display='none';
					luser.style.display='none';
					auser.style.display='none';
					full.style.display='none';
					pend.style.display='none';
					comp.style.display='none';
				}
				else
				{
					
					inpro.style.display='block';
					dash.style.display='none';
					luser.style.display='none';
					auser.style.display='none';
					full.style.display='none';
					pend.style.display='none';
					comp.style.display='none';
				}
				
			}
				
			function full()
			{
				var full=document.getElementById('fullhistory');
				var inpro=document.getElementById('inprocomp');
				var comp=document.getElementById('complcomp');
				var pend=document.getElementById('pending');
				var dash=document.getElementById('dashboard');
				var luser=document.getElementById('logindata');
				var auser=document.getElementById('alluser');
				if(full.style.display=='block')
				{
					dash.style.display='none';
					luser.style.display='none';
					auser.style.display='none';
					pend.style.display='none';
					inpro.style.display='none';
					comp.style.display='none';
				}
				else
				{
					
					full.style.display='block';
					dash.style.display='none';
					luser.style.display='none';
					auser.style.display='none';
					pend.style.display='none';
					inpro.style.display='none';
					comp.style.display='none';
				}
				
			}
			function auser()
			{
				var auser=document.getElementById('alluser');
					var full=document.getElementById('fullhistory');
				var inpro=document.getElementById('inprocomp');
				var comp=document.getElementById('complcomp');
				var pend=document.getElementById('pending');
				var dash=document.getElementById('dashboard');
				var luser=document.getElementById('logindata');
				if(auser.style.display=='block')
				{
					
					dash.style.display='none';
					luser.style.display='none';
					full.style.display='none';
					pend.style.display='none';
					inpro.style.display='none';
					comp.style.display='none';
				}
				else
				{
					auser.style.display='block';
					dash.style.display='none';
					luser.style.display='none';
					full.style.display='none';
					pend.style.display='none';
					inpro.style.display='none';
					comp.style.display='none';
				}
				
			}function luser()
			{
				var luser=document.getElementById('logindata');
				var full=document.getElementById('fullhistory');
				var inpro=document.getElementById('inprocomp');
				var auser=document.getElementById('alluser');
				var comp=document.getElementById('complcomp');
				var pend=document.getElementById('pending');
				var dash=document.getElementById('dashboard');
				if(luser.style.display=='none')
				{
					dash.style.display='none';
					full.style.display='none';
					pend.style.display='none';
					inpro.style.display='none';
					auser.style.display='none';
					comp.style.display='none';
					
					document.getElementById("logindata").style.display="block";
				}
				else
				{
					
					document.getElementById("logindata").style.display="block";
					
					dash.style.display='none';
					auser.style.display='none';
					full.style.display='none';
					pend.style.display='none';
					inpro.style.display='none';
					comp.style.display='none';
				}
				
			}
	</script>
  </head>
  <body>
  
  
		<nav class="navbar-nav navbar-expand-sm bg-info1" style="margin:0px;padding:0px;top:0px;">
		
<i class="fa fa-reorder" onclick="callsh()" style="cursor:pointer;font-size:24px;margin:20px 2px 0px 20px;color:white"></i>
		<div class="nav-item item1" style="margin-left:0%">
		<!--<img src="admin.png" style="border-radius:15%;margin-left:0%;float:left" width="70px" height="80px">-->
				<h3  style="float:left;cursor:pointer;margin:15px 2px 0px 20px;">Admin</h3>
						
		</div>
				<div style="width:50%" >
				<a class="btn btn-danger" style="float:right;padding-left:30px;padding-right:30px;margin:10px;" href="adminlogin1.html">Logout</a>
		</div>
		
		</nav>
		<nav  class="navbar navbar1 bg-dark1" style="float:left;margin:0px;display:block;padding:0px;box-shadow:.2px 1px 2px 1px;" id="sh_menu">
			<!-- Links -->
			<ul class="navbar-nav" style="width:100%;">
			
					
				
				<li class="nav-item" style="width:100%;border-bottom:2px solid white;" >
					<a class="btn btn-dark btn1" onclick="dashboard()" href="#">Dashboard</a>
				</li>
				<!--<li class="nav-item">
					<a class="btn btn-dark btn1" onclick="comp()" href="#">Manage Complaints</a>
				</li>-->
				<!--<li class="nav-item">
					<a class="btn btn-dark btn1" onclick="pending()" href="#">Pending <br />complaints<p id="specialchk"><?php echo $pend;?></p></a>
				</li>-->
 
				<!--<li class="nav-item">
        <a class="btn btn-dark btn1" onclick="pending()" href="#">Pending <br />complaints<p id="specialchk"><?php echo $pend; ?></p></a>
    </li>-->
	<li class="nav-item">
        <a class="btn btn-dark btn1" onclick="pending()" href="#">Pending <br />complaints<p id="specialchk"><?php echo $pend; ?></p></a>
    </li>

     <li class="nav-item"> 
					<a class="btn btn-dark btn1" onclick="inpro()"  href="#">In progress<p id="specialchk"><?php echo $inpro;?></p></a>
				</li>

				<!--<li class="nav-item">
        <a class="btn btn-dark btn1" onclick="pending()" href="#">Pending <br />complaints<p id="specialchk"><?php echo $pend; ?></p></a>
    </li>-->


				<li class="nav-item">
					<a class="btn btn-dark btn1" onclick="complcomp()"href="#">Complete <br />Complaints<p id="specialchk"><?php echo $compl; ?></p></a>
				</li>
				<li class="nav-item">
					<a class="btn btn-dark btn1" onclick="full()"  href="#">ALL Complaints<br /> history<p id="specialchk"><?php echo $full;?></p></a>
				</li>
					
				<li class="nav-item"  style="border-top:2px solid white;">
					<a class="btn btn-dark btn1" onclick="manageuser()" href="#">Manage Users</a>
				</li>
				<li class="nav-item" id="a_user" style="display:none;border-top:1.2px solid white;">
					<a class="btn btn-dark btn1" onclick="auser()"   href="#">All users data</a>
				</li>
				<li class="nav-item" id="l_user"  style="display:none">
					<a class="btn btn-dark btn1" onclick="luser()"   href="#">User Login info</a>
				</li>
				<li class="nav-item">
                <a class="btn btn-dark btn1" href="view_feedback.php?type=positive">Positive Feedbacks<br /><p id="specialchk"><?php echo $positiveCount;?></p></a>
            </li>
            <li class="nav-item">
                <a class="btn btn-dark btn1" href="view_feedback.php?type=negative">Negative Feedbacks<br /><p id="specialchk"><?php echo $negativeCount;?></p></a>
            </li>
	  
			</ul>
		</nav>
		
		<div id="main" style="width:78%;float:left;" >
			<!----------------------------------------------------------------------------------------DASHBOARD-->
			
			<!--<div class="" id="dashboard" style="width:100%;display:block;padding:20px;">
			<h4 style="color:orangered;">Dashboard<hr/></h4>
				<div id="file1" onclick="pending()" style="cursor:pointer;">
					<i class="fa fa-file-text" style=""></i>
					<p id="file12" style="display:block;font-size:15px;text-align:center;">Pending complaints<div id="pen"><?php echo $pend; ?></div></p>
				</div>
					<div id="file2">
						<i class="fa fa-file-text" style="cursor:pointer;" onclick="inpro()"></i>
						<p id="file22" style="display:block;font-size:15px;text-align:center;">in progress complaints<div id="pen2"><?php echo $inpro; ?></div></p>
					</div>
						<div id="file3">
							<i class="fa fa-file-text" style="cursor:pointer;" onclick="complcomp()"></i>
							<p id="file32" style="display:block;font-size:15px;text-align:center;">Completed complaints<div id="pen3"><?php echo $compl; ?></div></p>
						</div>
			</div>-->

			<div class="" id="dashboard" style="width:100%;display:block;padding:20px;">
			<h4 style="color:orangered;">Dashboard<hr/></h4>
				<div id="file1" onclick="pending()" style="cursor:pointer;">
					<i class="fa fa-file-text" style=""></i>
					<p id="file12" style="display:block;font-size:15px;text-align:center;">Pending complaints<div id="pen"><?php echo $pend; ?></div></p>
				</div>
					<div id="file2" onclick="inpro()" style="cursor:pointer;">
						<i class="fa fa-file-text" style=""></i>
						<p id="file22" style="display:block;font-size:15px;text-align:center;">in progress complaints<div id="pen2"><?php echo $inpro; ?></div></p>
					</div>
						<div id="file3" onclick="completed()" style="cursor:pointer;">
							<i class="fa fa-file-text" style=""></i>
							<p id="file32" style="display:block;font-size:15px;text-align:center;">Completed complaints<div id="pen3"><?php echo $compl; ?></div></p>
						</div>
							<!----------------------------------------------------------------------------------------DASHBOARD-->
				
		
				<!----------------------------------------------------------------------------------------pending-->
				<!--<div class="container mt-4">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="card bg-primary text-white" onclick="pending()">
                    <div class="card-body">
                        <i class="fa fa-file-text"></i>
                        Pending Complaints
                    </div>
                    <div class="card-footer">
                        <span class="small text-white"><?php echo $pend; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card bg-warning text-white" onclick="inpro()">
                    <div class="card-body">
                        <i class="fa fa-file-text"></i>
                        In Progress Complaints
                    </div>
                    <div class="card-footer">
                        <span class="small text-white"><?php echo $inpro; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card bg-success text-white" onclick="complcomp()">
                    <div class="card-body">
                        <i class="fa fa-file-text"></i>
                        Completed Complaints
                    </div>
                    <div class="card-footer">
                        <span class="small text-white"><?php echo $compl; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <!-- Include Bootstrap and FontAwesome JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

           
		<div class="" id="pending" style="width:auto;display:none;border-radius:15px;padding:15px;margin:10px;background-color:white">
        <h4 style="color:orangered;">Pending Complaints<hr /></h4>
        <div class="search-container">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchBar" onkeyup="filterComplaints(event)" placeholder="Search by user or complaint details">
        </div>

				<?php
					$query1="SELECT * FROM `complaints`";
					$result=mysqli_query($conn,$query1);
						$num=0;
				
						if($result)
						{
							while($row=mysqli_fetch_assoc($result))
								{
									
									$cme=$row['pending'];
									if($cme=='1')
									{
										
										$num++;
											$id=$row['id'];
											$usr=$row['user'];
											$cate=$row['category'];
											
											$nat=$row['nature'];
											$da=$row['date'];
											$fil=$row['file'];
											$co=$row['comp'];
											echo "<h5 class='tr'>
											
											<form method='POST' action='solvepend1.php'>
											<input type='text' name='user' value='$usr' class='now'>
											<input type='text' name='compid' value='$id' class='now'>
											<input type='submit' value='solve it' style='float:right;margin:0px;' class='btn btn-info' >
											</form>
											
											Number:$num  
											User: $usr  
																					
											</h5>";
											echo"<h6>File:               ";
											if($fil==""||$fil=='0')
											{
												
											echo "<span id='span'>No file</span><br />";
											}
											else{
											echo "<a href='$fil' target='_blank'>view file</a><br />";
											}
											echo 
											 
										     //Domain :        <span id='span'>$subcate</span><br />
											 "Date:          <span id='span'>$da</span><br />
											 Complaint :               <span id='span'>$co</span><br /></h6><br /><hr />";
										
									}
								}
						}
											
				?>
			</div>
			
			<!----------------------------------------------------------------------------------------pending-->
			<!----------------------------------------------------------------------------------------inprogress-->
			
			<div class="" id="inprocomp" style="width:97%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:white">
			<h4 style="color:orangered;">In progress Complaints<hr /></h4>
			<?php
				$num=0;
				$query1="SELECT * FROM `complaints`";
				$seee="SELECT * FROM `inprogresscomp`";
				$reso=mysqli_query($conn,$seee);
					
					if($reso)
					{
						while($inpro=mysqli_fetch_assoc($reso))
						{
							$inid=$inpro['compnum'];
						$result=mysqli_query($conn,$query1);
						
						if($result)
							{
							while($row=mysqli_fetch_assoc($result))
								{				
										$id=$row['id'];
										if($id==$inid)
										{
											$num++;
											$usr=$row['user'];
											$cate=$row['category'];
											
											$nat=$row['nature'];
											$da=$row['date'];
											$fil=$row['file'];
											$co=$row['comp'];
											echo "<h5 class='tr'>
											
											<form method='POST' action='solveinpro2.php'>
										
    <input type='hidden' name='complaint_id' value='<?php echo $complaint_id; ?>'>
    <input type='hidden' name='user_email' value='<?php echo $user_email; ?>'>
    <input type='submit' value='Complete_it' style='float:right;margin:0px;' class='btn btn-secondary'>
</form>

											
											
											Number:$num  
											User: $usr  				
											</h5>";
											echo"<h6>File:";
											if($fil==""||$fil=='0')
											{
												
											echo "<span id='span'>No file</span><br />";
											}
											else{
											echo "<a href='$fil' target='_blank'>view file</a><br />";
											}
											 echo "Complaint - categoty:<span id='span'> $cate</span><br />
											
											Domain:        <span id='span'>$nat</span><br />
											 Complaint - Date:          <span id='span'>$da</span><br />
											Complaint :               <span id='span'>$co</span><br /></h6><br /><hr />";
										}
										
									
								}
							}
						}
					}
				?>
			</div>
			
			<!----------------------------------------------------------------------------------------inprogress-->
			<!----------------------------------------------------------------------------------------completed-->
			
			<div class="" id="complcomp" style="width:97%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:black;">
			<h4 style="color:orangered;">Completed Complaints<hr /></h4>
				<?php
				$num=0;
				$query1="SELECT * FROM `complaints`";
				$seee="SELECT * FROM `completedcomp`";
				$reso=mysqli_query($conn,$seee);
					
					if($reso)
					{
						while($coomp=mysqli_fetch_assoc($reso))
						{
							$cid=$coomp['compnum'];
							$remark=$coomp['remark'];
						$result=mysqli_query($conn,$query1);
						
						if($result)
							{
							while($row=mysqli_fetch_assoc($result))
								{				
										$id=$row['id'];
										if($id==$cid)
										{
											$num++;
											$usr=$row['user'];
											$cate=$row['category'];
											
											$nat=$row['nature'];
											$da=$row['date'];
											$fil=$row['file'];
											$co=$row['comp'];
											echo "<h5 class='tr'>											
											Number:$num  
											User: $usr  				
											</h5>
											<h6>
											 Remark :<span id='remark'>$remark</span><br />
											";
											echo"File:               ";
											if($fil==""||$fil=='0')
											{
												
											echo "<span id='span'>No file</span><br />";
											}
											else{
											echo "<a href='$fil' target='_blank'>view file</a><br />";
											}
											 echo "
											 Complaint - categoty:<span id='span'> $cate</span><br />
											
											 Domain :        <span id='span'>$nat</span><br />
											 Complaint - Date:          <span id='span'>$da</span><br />
											 Complaint :               <span id='span'>$co</span><br /></h6><br /><hr />";
										}
										
									
								}
							}
						}
					}
				?>
			</div>
			
			<!----------------------------------------------------------------------------------------inprogress-->
			<!----------------------------------------------------------------------------------------full-->
			
			<div class="" id="fullhistory" style="width:97%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:black;">
			<h4 style="color:orangered;">Full history of Complaints<hr /></h4>
				<h5>Pending Complaints<hr /></h5>
				<?php
					$query1="SELECT * FROM `complaints`";
					$result=mysqli_query($conn,$query1);
						$num=0;
				
						if($result)
						{
							while($row=mysqli_fetch_assoc($result))
								{
									
									$cme=$row['pending'];
									if($cme=='1')
									{
										
										$num++;
											$id=$row['id'];
											$usr=$row['user'];
											$cate=$row['category'];
											$subcate=$row['subcategory'];
											$nat=$row['nature'];
											$da=$row['date'];
											$fil=$row['file'];
											$co=$row['comp'];
											echo "<h6 class='tr'>
											
											<form method='POST' action='solvepend1.php'>
											<input type='text' name='user' value='$usr' class='now'>
											<input type='text' name='compid' value='$id' class='now'>
											<input type='submit' value='solve it' style='float:right;margin:0px;' class='btn btn-info' >
											</form>
											
											Number:$num  
											User: $usr  
																					
											</h6>";
											echo"<h6>File:               ";
											if($fil==""||$fil=='0')
											{
												
											echo "<span id='span'>No file</span><br />";
											}
											else{
											echo "<a href='$fil' target='_blank'>view file</a><br />";
											}
											 echo "Complaint - categoty:<span id='span'> $cate</span><br />
											 
											 Domain :        <span id='span'>$nat</span><br />
											 Complaint - Date:          <span id='span'>$da</span><br />
											 Complaint :               <span id='span'>$co</span><br /></h6><br /><hr />";
										
									}
								}
						}
						
						
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						echo "<br /br /><h5>Inprogress Complaints<hr /></h5>";
						$num=0;
				$query1="SELECT * FROM `complaints`";
				$seee="SELECT * FROM `inprogresscomp`";
				$reso=mysqli_query($conn,$seee);
					
					if($reso)
					{
						while($inpro=mysqli_fetch_assoc($reso))
						{
							$inid=$inpro['compnum'];
						$result=mysqli_query($conn,$query1);
						
						if($result)
							{
							while($row=mysqli_fetch_assoc($result))
								{				
										$id=$row['id'];
										if($id==$inid)
										{
											$num++;
											$usr=$row['user'];
											$cate=$row['category'];
											$subcate=$row['subcategory'];
											$nat=$row['nature'];
											$da=$row['date'];
											$fil=$row['file'];
											$co=$row['comp'];
											echo "<h6 class='tr'>
											
											<form method='POST' action='solveinpro1.php'>
											<input type='text' name='user' value='$usr' class='now'>
											<input type='text' name='compid' value='$id' class='now'>
											<input type='submit' value='complete it' style='float:right;margin:0px;' class='btn btn-secondary' >
											</form>
											
											Number:$num  
											User: $usr  				
											</h6>";
											echo"<h6>File:               ";
											if($fil==""||$fil=='0')
											{
												
											echo "<span id='span'>No file</span><br />";
											}
											else{
											echo "<a href='$fil' target='_blank'>view file</a><br />";
											}
											 echo "Complaint - categoty:<span id='span'> $cate</span><br />
											 
											 Domain :        <span id='span'>$nat</span><br />
											 Complaint - Date:          <span id='span'>$da</span><br />
											 Complaint :               <span id='span'>$co</span><br /></h6><br /><hr />";
										}
										
									
								}
							}
						}
					}
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						echo "<br /br /><h5>Completed Complaints<hr /></h5>";	

				$num=0;
				$query1="SELECT * FROM `complaints`";
				$seee="SELECT * FROM `completedcomp`";
				$reso=mysqli_query($conn,$seee);
					
					if($reso)
					{
						while($coomp=mysqli_fetch_assoc($reso))
						{
							$cid=$coomp['compnum'];
							$remark=$coomp['remark'];
						$result=mysqli_query($conn,$query1);
						
						if($result)
							{
							while($row=mysqli_fetch_assoc($result))
								{				
										$id=$row['id'];
										if($id==$cid)
										{
											$num++;
											$usr=$row['user'];
											$cate=$row['category'];
											$subcate=$row['subcategory'];
											$nat=$row['nature'];
											$da=$row['date'];
											$fil=$row['file'];
											$co=$row['comp'];
											echo "<h6 class='tr'>											
											Number:$num  
											User: $usr  				
											</h6>
											<h6>
											 Remark :<span id='remark'>$remark</span><br />
											";
											echo"File:               ";
											if($fil==""||$fil=='0')
											{
												
											echo "<span id='span'>No file</span><br />";
											}
											else{
											echo "<a href='$fil' target='_blank'>view file</a><br />";
											}
											 echo "
											 Complaint - categoty:<span id='span'> $cate</span><br />
											 
											 Domain :        <span id='span'>$nat</span><br />
											 Complaint-Date:          <span id='span'>$da</span><br />
											 Complaint :              <span id='span'>$co</span><br /></h6><br /><hr />";
										}
										
									
								}
							}
						}
					}						
					////////////////////////////////////////////////////////
			?>
			</div>
			
			<!----------------------------------------------------------------------------------------full-->
		
			<!----------------------------------------------------------------------------------------all-user-->
			
			<div class="" id="alluser" style="width:97%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:white">
			<h4 style="color:orangered;">All Users data<hr /></h4>
				<?php
					$num=0;
					$userss="SELECT * FROM `userregistration`";
					$result786=mysqli_query($conn,$userss);
					if($result786)
					{
						while($rowuser=mysqli_fetch_assoc($result786))
						{$num++;
							$fnamen=$rowuser['fname'];
							$lnamen=$rowuser['lname'];
							$usern=$rowuser['username'];
							$mailn=$rowuser['email'];
							$phonen=$rowuser['phone'];
							$gendern=$rowuser['gender'];
							$daten=$rowuser['date'];
							echo"
							<table class='tab-hov'> 
								<tr class='thead'><th>Number : </th><th>$num</th></tr>
								<tr><td>First Name : </td><td>$fnamen</td></tr>
								<tr><td>Last Name : </td><td>$lnamen</td></tr>
								<tr><td>Username : </td><td>$usern</td></tr>
								<tr><td>Email : </td><td>$mailn</td></tr>
								<tr><td>Phone Number : </td><td>$phonen</td></tr>
								<tr><td>Gender : </td><td>$gendern</td></tr>
								<tr><td>Date : </td><td>$daten</td></tr><hr /><br />
								</table>
								";
						}
					}
				
				?>
			</div>
			
			<!----------------------------------------------------------------------------------------all-user-->
					<!----------------------------------------------------------------------------------------Login-->	
		<div class="" id="logindata" style="width:97%;float:left;display:none;border-radius:15px;padding:15px;margin:10px;background-color:white">
			<h4 style="color:orangered;">Login data<hr /></h4>
				<?php
					$num=0;
					$users="SELECT * FROM `userloginfo`";
					$result78=mysqli_query($conn,$users);
					if($result78)
					{
						while($rowuser=mysqli_fetch_assoc($result78))
						{$num++;
							$fnamen=$rowuser['fname'];
							$lnamen=$rowuser['lname'];
							$usern=$rowuser['user'];
							$daten=$rowuser['date'];
							echo"
							<table class='tab-hov'> 
								<tr class='thead'><th>Number</th><th>$num</th></tr>
								<tr><td>First Name : </td><td>$fnamen</td></tr>
								<tr><td>Last Name : </td><td>$lnamen</td></tr>
								<tr><td>Username : </td><td>$usern</td></tr>
								<tr><td>Date : </td><td>$daten</td></tr><hr /><br />
								</table>
								";
						}
					}
					
				?>
			</div>
			
			<!----------------------------------------------------------------------------------------Login-->
			
			</div>
	</body>
</html>