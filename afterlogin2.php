<?php
$servername='localhost';
$username='root';
$password='';
$dbname='project';

$conn=mysqli_connect($servername,$username,$password,$dbname);
if($conn)
{
	$query1="SELECT * FROM `userloginfo`";
	$result=mysqli_query($conn,$query1);
	if($result)
	{
		while($row=mysqli_fetch_assoc($result))
		{
			$user=$row['user'];
			echo $user;
		}
	}		
	$query1="SELECT * FROM `userregistration`";
	$result=mysqli_query($conn,$query1);
	if($result)
	{
		while($row=mysqli_fetch_assoc($result))
		{
			if($user==$row['username'])
			{
				$fname=$row['fname'];
				$lname=$row['lname'];
				$email=$row['email'];
				$phone=$row['phone'];
				$gender=$row['gender'];
				$pass=$row['pass'];
			}
		}
	}	$query1="SELECT * FROM `complaints`";
	$result=mysqli_query($conn,$query1);
	$pend=0;
	if($result)
	{
		while($row=mysqli_fetch_assoc($result))
		{
			if($user==$row['user'])
			{
				$cme=$row['pending'];
				if($cme=='1')
				{
					$pend++;
				}
			}
		}
	}
	
	$query1="SELECT * FROM `completedcomp`";
	$result=mysqli_query($conn,$query1);
	$compl=0;
	if($result)
	{
		while($row=mysqli_fetch_assoc($result))
		{
			if($user==$row['user'])
			{	
					$compl++;	
			}
		}
	}
	
	$query1="SELECT * FROM `inprogresscomp`";
	$result3=mysqli_query($conn,$query1);
	$inpro=0;
	if($result3)
	{
		while($row=mysqli_fetch_assoc($result3))
		{
			if($user==$row['user'])
			{	
					$inpro++;	
			}
		}
	}
	
	
}
 
 ?>
<html>
	<head>
		<title>Meliora</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="main.css">
  <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            max-width: 100%;
            max-height: 100%;
        }

        .top-frame {
            /* background: linear-gradient(to bottom left, #cfcf09,rgb(238, 19, 180)); */
            background:black;
            position: fixed;
            top: 0;
            left: 0;
            right:0;
            width: 100%;
            height:14%;
            background-color:black;
            color: #fff;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center; 
           
        }

        .bottom-frame {
            top:12%;
            display: flex;
            height: calc(100vh - 3px); 
            
        }

        .left-frame {
            flex: 10%;
            background-color:black;
            padding: 20px;
            max-height: 1000px;
        
            display: flex;
            flex-direction: column;
        }

        

        .right-frame {
            flex: 70%;
            padding: 70px;
            background-color:white;
            border-left: 1px solid #ccc;
            height: 630px;
        }

        .left-menu-item {
            margin-bottom: 20px;
            padding: 17px;
            background-color: #ddd;
            cursor: pointer;
        
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
			}	
            #file3:hover #pen3{
				display:block;
			}
			.in1{
				width:100%;
				border-radius:15px;
				padding:10px;
				font-size:18px;
				
			}
			#span{
				
				font-size:21px;
			}
			td{
				border-top:1px solid aqua;
				text-align:center;
			}
			.tr{
				width:auto;
			}
			.table,.tr{
				padding:10px;
				float;left;
				border:1px solid black;
			}
			th{
				
				text-align:center;
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
			#remark{
				color:green;
				padding:10px;
				font-size:24px;
			}
            #span{
				
				font-size:16px;
			}

        .left-menu-item:hover {
            background-color:palegoldenrod
        }
        .logo {
            margin-left: 0px;
            width: 70px;
        }
	
        .chat-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            cursor: pointer;
        }

        .chat-panel {
            position: fixed;
            top: 0;
            right: -350px; /* Initially hidden off the screen */
            width: 350px;
            height: 100%;
            background-color: #f4f4f4;
            box-shadow: -2px 0 5px rgba(0,0,0,0.5);
            transition: right 0.3s ease;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .chat-panel.visible {
            right: 0; /* Slide in when visible */
        }

        .chat-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #fff;
        }

        .chat-input {
            display: flex;
        }

        .chat-input input {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .chat-input button {
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color:orange;
            color: white;
            margin-left: 10px;
            border-radius: 4px;
        }

    .chatbot-icon {
      cursor: pointer;
	  position: fixed; 
      top: 605px; 
      right: 10px; 
      z-index: 1000;
	  height: 85px;
    }

    /* Style for the chatbot container */
    .chatbot-container {
      position: absolute;
      top: 0px;
      right: 50px;
      width: 320px; /* Adjust width as needed */
      height: 108vh; /* Full height */
      background-color: #f0f0f0; /* Light background color */
      border-left: 1px solid #ccc; /* Border on the left side */
      box-shadow: 0px 0 5px rgba(0, 0, 0, 0.1); /* Shadow effect */
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      padding: 20px;
    }

    /* Hidden class to initially hide the chatbot container */
    .hidden {
      display: none;
    }

    /* Other styles for your dashboard content */
    .dashboard {
      padding: 20px;
    }
        .title {
            margin-right: auto;
            font-family:Georgia, 'Times New Roman', Times, serif;
            font-size: 30px;
            color:orangered;
			bottom: 10%
            
        }
        ::-webkit-scrollbar {
            width: 12px;
        }
        ::-webkit-scrollbar-track {
            background: black; 
        }
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: grey; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: grey; 
}
/* CSS for the input box */
#userInput {
    width: 311px;
    height: 36px;
    left: 27px;
    top: 14px;
    position: absolute;
    color: white;
    font-size: 16px;
    font-family: Poppins;
    font-weight: 500;
    line-height: 40px;
    background: transparent;
    border: none;
    outline: none;
    border-bottom: 1px solid rgba(255, 255, 255, 0.4); /* Adding a bottom border */
    padding-left: 10px; /* Padding for text */
}

/* CSS for the send message button */
#sendMessage {
    width: 30px;
    height: 30px;
    left: 281px;
    top: 33px;
    position: absolute;
    cursor: pointer;
}

/* CSS for the chatbot message box */
#chatbotMessages {
    width: 100%;
    max-height: 300px;
    overflow-y: auto;
    position: absolute;
    left: 0;
    bottom: 100px;
    padding: 10px;
}

/* CSS for individual chatbot message */
.chatbotMessage {
    background-color: #3389BB;
    color: white;
    padding: 8px;
    border-radius: 8px;
    margin-bottom: 8px;
    max-width: 80%;
    word-wrap: break-word;
}
.buton{
	color: orange;
}
.btn-logout{
	color:#ffffff;
}

.complaint-form {
            width: 100%;
            display: none;
            border-radius: 15px;
            padding: 15px;
            margin: 10px;
            background-color: white;
        }

</style>
</head>
<script>

        
async function classifyAndSubmit(event) {
            event.preventDefault();
            const issue = document.getElementById('complaintText').value;
            
            const response = await fetch('classify_issue.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ issue: issue })
            });

            const result = await response.json();

            if (result.classification === 'trivial') {
                document.getElementById('complaintFormElement').action = 'submit.php';
            } else {
                document.getElementById('complaintFormElement').action = 'usermakecomp.php';
            }

            document.getElementById('complaintFormElement').submit();
        }

        async function validateDescription() {
            const description = document.getElementById('description').value;
            const submitButton = document.getElementById('submitBtn');
            const errorMessage = document.getElementById('errorMessage');

            try {
                const response = await fetch('http://localhost:5001/classify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ issue: description })
                });

                if (!response.ok) {
                    throw new Error('Failed to classify issue');
                }

                const result = await response.json();

                if (result.classification === 'trivial') {
                    errorMessage.textContent = "Error: Trivial issues are not permitted.";
                    submitButton.disabled = true;
                } else {
                    errorMessage.textContent = "";
                    submitButton.disabled = false;
                }
            } catch (error) {
                console.error('Error contacting the classification service:', error);
                errorMessage.textContent = "Error: Unable to contact the classification service.";
                submitButton.disabled = true;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const chatIcon = document.getElementById('chatIcon');
            const chatPanel = document.getElementById('chatPanel');
            const chatMessages = document.getElementById('chatMessages');
            const chatInput = document.getElementById('chatInput');
            const sendButton = document.getElementById('sendButton');

            chatIcon.addEventListener('click', function() {
                chatPanel.classList.toggle('visible');
            });

            sendButton.addEventListener('click', function() {
                const message = chatInput.value.trim();
                if (message) {
                    displayMessage('User', message);
                    chatInput.value = '';
                    getBotResponse(message);
                }
            });

            chatInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    sendButton.click();
                }
            });

            function displayMessage(sender, message) {
                const messageElement = document.createElement('div');
                messageElement.textContent = `${sender}: ${message}`;
                chatMessages.appendChild(messageElement);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function getBotResponse(userMessage) {
                let botMessage;
                // Simple logic for different responses
                if (userMessage.toLowerCase().includes('hello')) {
                    botMessage = 'Hi there! How can I assist you today?';
                } else if (userMessage.toLowerCase().includes('how are you')) {
                    botMessage = 'I am just a bot, but I am functioning as expected! How can I help you?';
                } else if (userMessage.toLowerCase().includes('bye')) {
                    botMessage = 'Goodbye! Have a great day!';
                } else {
                    botMessage = 'I am not sure how to respond to that. Can you please rephrase?';
                }
                setTimeout(() => displayMessage('Bot', botMessage), 1000);
            }

            // Close the chat panel if clicking outside of it
            document.addEventListener('click', function(event) {
                if (!chatPanel.contains(event.target) && !chatIcon.contains(event.target)) {
                    chatPanel.classList.remove('visible');
                }
            });
        });
    
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
			function comp(){
				var make=document.getElementById("m_comp");
				var pend=document.getElementById("p_comp");
				var c=document.getElementById("c_comp");
				var i=document.getElementById("i_comp");
				var h=document.getElementById("h_comp");
				if(make.style.display=='block')
				{
					make.style.display='none';
					pend.style.display='none';
					h.style.display='none';
					c.style.display='none';
					i.style.display='none';
				}
				else
				{
					make.style.display='block';
					pend.style.display='block';
					h.style.display='block';
					i.style.display='block';
					c.style.display='block';
					
				}
			}
			function personal(){
				var e_info=document.getElementById("e_info");
				var c_pass=document.getElementById("c_pass");
				if(e_info.style.display=='block')
				{
					e_info.style.display='none';
					c_pass.style.display='none';
				}
				else
				{e_info.style.display='block';
					c_pass.style.display='block';
					
				}
			}
			function dashboard(){
				var dash=document.getElementById("dashboard");
				var einfo=document.getElementById("editinfo");
				var mcom=document.getElementById("makecomplaint");
				var pending=document.getElementById("pending");
				var history=document.getElementById("history");
				var changepass=document.getElementById("changepass");
				var inpro=document.getElementById("inpro");
				var c=document.getElementById("completed");
				c.style.display='none';
				inpro.style.display='none';
				
				einfo.style.display='none';
				mcom.style.display='none';
				pending.style.display='none';
				history.style.display='none';
				changepass.style.display='none';
				if(dash.style.display=='block')
				{
					dash.style.display='block';
				}
				else
				{dash.style.display='block';
					
				}
			}
			function editinfo()
			{
				var einfo=document.getElementById("editinfo");
				var dash=document.getElementById("dashboard");
				var mcom=document.getElementById("makecomplaint");
				var pending=document.getElementById("pending");
				var history=document.getElementById("history");
				var changepass=document.getElementById("changepass");
				var inpro=document.getElementById("inpro");
				var c=document.getElementById("completed");
				c.style.display='none';
				inpro.style.display='none';
				dash.style.display='none';
				mcom.style.display='none';
				pending.style.display='none';
				history.style.display='none';
				changepass.style.display='none';
					if(einfo.style.display=='block')
				{
					einfo.style.display='block';
				}
				else
				{einfo.style.display='block';
					
				}
			}
			function makecomplaint()
			{
				var mcom=document.getElementById("makecomplaint");
				var einfo=document.getElementById("editinfo");
				var dash=document.getElementById("dashboard");
				var pending=document.getElementById("pending");
				var history=document.getElementById("history");
				var changepass=document.getElementById("changepass");
				var inpro=document.getElementById("inpro");
				var c=document.getElementById("completed");
				c.style.display='none';
				inpro.style.display='none';
				dash.style.display='none';
				einfo.style.display='none';
				pending.style.display='none';
				history.style.display='none';
				changepass.style.display='none';
				
					if(mcom.style.display=='block')
				{
				}
				else
				{mcom.style.display='block';
					
				}
			}
			function pending()
			{
					var pending=document.getElementById("pending");
					var mcom=document.getElementById("makecomplaint");
				var einfo=document.getElementById("editinfo");
				var dash=document.getElementById("dashboard");
				var history=document.getElementById("history");
				var changepass=document.getElementById("changepass");
				var inpro=document.getElementById("inpro");
				var c=document.getElementById("completed");
				c.style.display='none';
				inpro.style.display='none';
				dash.style.display='none';
				einfo.style.display='none';
				mcom.style.display='none';
				history.style.display='none';
				changepass.style.display='none';
					if(pending.style.display=='block')
				{
					pending.style.display='block';
				}
				else
				{pending.style.display='block';
					
				}
			}
			function history()
			{	var history=document.getElementById("history");
			var pending=document.getElementById("pending");
					var mcom=document.getElementById("makecomplaint");
				var einfo=document.getElementById("editinfo");
				var dash=document.getElementById("dashboard");
				var inpro=document.getElementById("inpro");
				var c=document.getElementById("completed");
				c.style.display='none';
				inpro.style.display='none';
				var changepass=document.getElementById("changepass");
				dash.style.display='none';
				einfo.style.display='none';
				mcom.style.display='none';
				pending.style.display='none';
				changepass.style.display='none';
					if(history.style.display=='block')
				{
					history.style.display='block';
				}
				else
				{
					history.style.display='block';
				}
				
			}
			function changepass()
			{
				var changepass=document.getElementById("changepass");
				var history=document.getElementById("history");
			var pending=document.getElementById("pending");
					var mcom=document.getElementById("makecomplaint");
				var einfo=document.getElementById("editinfo");
				var inpro=document.getElementById("inpro");
				inpro.style.display='none';
				var dash=document.getElementById("dashboard");
				var c=document.getElementById("completed");
				c.style.display='none';
				dash.style.display='none';
				einfo.style.display='none';
				mcom.style.display='none';
				pending.style.display='none';
				history.style.display='none';
					if(changepass.style.display=='block')
				{
					changepass.style.display='block';
				}
				else
				{
					changepass.style.display='block';
				}
			}
			function completed(){
				var changepass=document.getElementById("changepass");
				var history=document.getElementById("history");
				var pending=document.getElementById("pending");
				var mcom=document.getElementById("makecomplaint");
				var einfo=document.getElementById("editinfo");
				var inpro=document.getElementById("inpro");
				var dash=document.getElementById("dashboard");
				var c=document.getElementById("completed");
				changepass.style.display='none';
				inpro.style.display='none';
				dash.style.display='none';
				einfo.style.display='none';
				mcom.style.display='none';
				pending.style.display='none';
				history.style.display='none';
				if(c.style.display=='block')
				{
					c.style.display='block';
				}
				else
				{
					c.style.display='block';
				}
			}
			function inpro(){
				var changepass=document.getElementById("changepass");
				var history=document.getElementById("history");
				var pending=document.getElementById("pending");
				var mcom=document.getElementById("makecomplaint");
				var einfo=document.getElementById("editinfo");
				var inpro=document.getElementById("inpro");
				var dash=document.getElementById("dashboard");
				var c=document.getElementById("completed");
				changepass.style.display='none';
				c.style.display='none';
				dash.style.display='none';
				einfo.style.display='none';
				mcom.style.display='none';
				pending.style.display='none';
				history.style.display='none';
				if(inpro.style.display=='block')
				{
					inpro.style.display='block';
				}
				else
				{
					inpro.style.display='block';
				}
			}
            function showHome() {
            window.location.href="index.html";
        }
		function toggleChatbot() {
      var chatbotContainer = document.getElementById('chatbotContainer');
      chatbotContainer.classList.toggle('hidden');
    }
    function toggleChatbotPanel() {
        var panel = document.getElementById('chatbotPanel');
        if (panel.style.display === 'none') {
            panel.style.display = 'block';
        } else {
            panel.style.display = 'none';
        }
    }

    function sendMessage() {
        var messageInput = document.getElementById('chatInput');
        var message = messageInput.value.trim();
        if (message !== '') {
            // Send message to backend (e.g., via AJAX) and handle response
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'http://localhost:5000/chatbot', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    displayMessage(response.response, 'bot');
                }
            };
            var data = JSON.stringify({query: message});
            xhr.send(data);

            // Clear input field after sending message
            messageInput.value = '';
        }
    }

    function displayMessage(message, sender) {
        var chatMessages = document.getElementById('chatMessages');
        var messageElement = document.createElement('div');
        messageElement.textContent = sender + ': ' + message;
        messageElement.classList.add('chat-message');
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll to bottom of chat messages
    }
		</script>



<body>

    <div class="top-frame">
        <div class="logo">
        <img src="logo.jpg" alt="Your Logo" height="70px" width="85px"></div>
        <div class="title">
        <h3>Meliora</h3>
		<img src="chatbot.jpeg" alt="Chatbot" class="chatbot-icon" id="chatIcon">
		<!--<img src="chatbot.jpeg" alt="Chatbot Icon" class="chatbot-icon" onclick="toggleChatbot()">-->
        </div>
		<div style="width:50%" >
				<a class="btn btn-danger" style="float:right;padding-left:30px;padding-right:30px;margin:10px;" href="userlogin1.html">Logout</a>
		</div>
    </div>
	<div class="container">
        
        <div id="chatPanel" class="chat-panel">
            <div class="chat-header">Chatbot</div>
            <div class="chat-messages" id="chatMessages">
                <!-- Messages will be displayed here -->
            </div>
            <div class="chat-input">
                <input type="text" id="chatInput" placeholder="Type your message...">
                <button id="sendButton" class="buton">Send</button>
            </div>
        </div>
		
    </div>
    <!--<div id="chatbotContainer" class="chatbot-container hidden">
     Include the chatbot mini screen HTML content here 
    <div style="width: 370px; height: 744px; position: relative; background: linear-gradient(168deg, black 0%, rgba(0, 56.87, 88.86, 0.60) 100%); border-radius: 40px; overflow: hidden">
        <div style="width: 237px; height: 544px; left: 76px; top: 0px; position: absolute">
            <div style="width: 285px; height: 440px; left: 0px; top: -18px; position: absolute; background: linear-gradient(180deg, #3389BB 0%, rgba(35.13, 105.22, 145.97, 0.12) 78%, rgba(51, 137, 187, 0) 100%)"></div>
            <div style="width: 287px; height: 456px; left: 0px; top: 140px; position: absolute">
                <img style="width: 287px; height: 456px; left: 0px; top: 0px; position: absolute" src="https://via.placeholder.com/287x456" />
                <img style="width: 287px; height: 256px; left: 0px; top: 0px; position: absolute" src="chatbot1.jpg" />
            </div>
			<div id="chatMessages" style="height: 200px; overflow-y: scroll;"></div>

            <div style="left: 29px; top: 49px; position: absolute; color: white; font-size: 36px; font-family: Inter; font-weight: 800; word-wrap: break-word">Welcome!</div>
        </div>
        <div style="width: 247px; height: 247px; left: 71px; top: 655px; position: absolute; background: #3389BB; box-shadow: 200px 200px 200px; border-radius: 9999px; filter: blur(200px)"></div>
        <div style="width: 468px; height: 54px; left: -33px; top: -19px; position: absolute"></div>
        <div style="left: 76px; top: 605px; position: absolute; color: white; font-size: 24px; font-family: Poppins; font-weight: 600; line-height: 40px; word-wrap: break-word">How can I help you?</div>
        <div style="width: 364px; height: 64px; left: 19px; top: 683px; position: absolute">
            <div style="width: 364px; height: 64px; left: 0px; top: 0px; position: absolute; background: rgba(0, 0, 0, 0.60); border-radius: 20px"></div>
			<input type="text" id="userInput" placeholder="Type your message..." style="margin-top: 10px;">
            <button onclick="sendMessage()" style="margin-top: 10px;">Send</button>
		</div>-->

  <script>
    // Function to display chatbot's response
    function displayResponse(response) {
      var chatMessages = document.getElementById("chatMessages");
      var newMessage = document.createElement("div");
      newMessage.textContent = "Chatbot: " + response;
      chatMessages.appendChild(newMessage);
    }

    // Function to send user's message to the chatbot
    function sendMessage() {
      var userInput = document.getElementById("userInput").value;
      displayResponse(userInput); // Display user's message
      // Send user's message to the chatbot (you would replace this with your actual chatbot logic)
      fetch('/chatbot', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message: userInput })
      })
      .then(response => response.json())
      .then(data => {
        displayResponse(data.response); // Display chatbot's response
      })
      .catch(error => {
        console.error('Error:', error);
      });
      document.getElementById("userInput").value = ""; // Clear input field
    }
  </script>

        </div>
    </div>
</div>


    <div class="bottom-frame">
        <div class="left-frame">
            <div class="left-menu-item" onclick="showHome()">Home</div>
            <div class="left-menu-item" onclick="showHome()">Home</div>
            <div class="left-menu-item" onclick="dashboard()">Dashboard</div>
            <div class="left-menu-item" onclick="editinfo()">Profile</div>
            <div class="left-menu-item" onclick="makecomplaint()">Make Complaint</div>
            <div class="left-menu-item" onclick="inpro()">Inprogress Complaint</div>
            <div class="left-menu-item" onclick="completed()">Completed complaints</div>
            <div class="left-menu-item" onclick="history()">History</div>
        </div>
       <!-- <div class="right-frame">
            <iframe id="content-frame" width="100%" height="90%" frameborder="0"></iframe>
        </div>
    </div>-->
        
    <!--<script>
        
        function showHome() {
            window.location.href="index.html";
        }
        function dashboard() {
            document.getElementById('content-frame').src = 'dashboard.html';
        }

        function editinfo() {
            document.getElementById('content-frame').src = 'profile.html';
        }

        function makecomplaint() {
            document.getElementById('content-frame').src = 'makecomplaint.html';
        }

        function inpro() {
            document.getElementById('content-frame').src = 'inpro.html';
        }

        function completed() {
            document.getElementById('content-frame').src = 'completed.html';
        }

        function history() {
            document.getElementById('content-frame').src = 'history.html';
        }
    </script>-->
    <div class="right-frame">
    <!--<div id="main" style="width:78%;float:left;" >-->
			<!----------------------------------------------------------------------------------------DASHBOARD-->
			
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
			</div>
			
			<!----------------------------------------------------------------------------------------DASHBOARD-->
			<!----------------------------------------------------------------------------------------editinfo-->
			<!--<div class="" id="editinfo" style="width:90%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:rgba(32, 76, 5, 0.1);border:1px solid aqua;">
				<h4>Personal Information<hr /></h4>
				<form class="form" action="userupdateinfo" method="POST" style="width:100%;">
					<span id="span">First Name</span><input type="text"  name="fname" class="form-control in1" placeholder="First name" value="<?php echo $fname; ?>"><br />
					<span id="span">Last Name</span><input type="text" name="lname" class="form-control in1" placeholder="Last name" value="<?php echo $lname; ?>"><br />
					<span id="span">Email</span><input type="text" name="email" class="form-control in1" placeholder="Email" value="<?php echo $email; ?>"><br />
					<span id="span">Phone number</span><input type="text" name="phone" class="form-control in1" placeholder="Phone number" value="<?php echo $phone; ?>"><br />
					<span id="span">Gender</span>
					<select name="gender" class="form-control in1" style="padding:2px;"  value="<?php echo $gender; ?>">
						<option>Male</option>
						<option>Fe Male</option>
					</select><br />
					<input type="submit"  class="btn btn-success " style="width:auto ;padding:10px;padding-left:50px;padding-right:50px;"  value="save"><br />
				</form>
			</div>-->
            <div class="" id="editinfo" style="width:90%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:white;">
    <h4 style="color:orangered;">Personal Information<hr /></h4>
    <form class="form" action="userupdateinfo" method="POST" style="width:100%;">
        <span id="span">First Name</span><input type="text" name="fname" class="form-control in1" placeholder="First name" value="<?php echo $fname; ?>"><br />
        <span id="span">Last Name</span><input type="text" name="lname" class="form-control in1" placeholder="Last name" value="<?php echo $lname; ?>"><br />
        <span id="span">Email</span><input type="text" name="email" class="form-control in1" placeholder="Email" value="<?php echo $email; ?>"><br />
        <span id="span">Phone number</span><input type="text" name="phone" class="form-control in1" placeholder="Phone number" value="<?php echo $phone; ?>"><br />
        <span id="span">Gender</span>
        <select name="gender" class="form-control in1" style="padding:2px;" value="<?php echo $gender; ?>">
            <option>Male</option>
            <option>Female</option> <!-- Corrected typo -->
        </select><br />
        <input type="submit" class="btn btn-success" style="width:auto ;padding:10px;padding-left:50px;padding-right:50px;" value="save"><br />
    </form>
</div>

     

    <!-- Existing content and structure of afterlogin.php -->
    
    <div id="makecomplaint" class="complaint-form">
        <h4 style="color:orangered;">Make a complaint<hr /></h4>
        <form id="complaintFormElement" class="form" action="" method="POST" style="width:100%;" enctype="multipart/form-data" onsubmit="return classifyAndSubmit(event)">
            <span id="span2">Category</span>
            <select id="category" name="category" style="width:30%;border-radius:12px;height:37px;">
                <option>Other</option>
                <option>Faculty</option>
                <option>Student</option>
            </select><br/><br/>
            <span id="span2">Domain</span>
            <select id="Domain" name="Domain" style="width:30%;border-radius:12px;height:37px;">
                <option>Academics</option>
                <option>Personal</option>
                <option>Infrastructure</option>
            </select><br/><br/>
            <span id="span">Complaint</span>
            <textarea id="complaintText" name="comp" class="form-control in1" placeholder="Feel free to write. Your complaint is secure." style="height:200px;"></textarea><br />
            <br /><span id="span">Regarding File (If any) Max Size 2Mb</span><input name="f2" type="file" class="form-control">
            <br />
            <input type="submit" class="btn btn-success" style="width:auto; padding:10px; padding-left:50px; padding-right:50px;" value="Send"><br />
        </form>
    </div>


<!--?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $issue = $_POST['issue'];

    // Replace with your actual URL where Flask is running
    $url = 'http://localhost:5001/classify';
    $data = array('issue' => $issue);
    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error contacting the classification service' . $http_response_header[0]);
    }

    $classification = json_decode($result, true);

    if ($classification['classification'] === 'trivial') {
        echo "<script>alert('Error: Trivial issues are not permitted');</script>";
    } else {
        // Insert code to save issue to the database or perform other actions
        echo "Issue submitted successfully";
    }
}
?>-->

    </div>

			
			<!----------------------------------------------------------------------------------------editinfo-->
						<!----------------------------------------------------------------------------------------makecomp-->
			<!--<div class="" id="makecomplaint" style="width:100%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:white;">
				<h4 style="color:orangered;">Make a complaint<hr /></h4>
				<form class="form" action="usermakecomp.php" method="POST" style="width:100%;" enctype="multipart/form-data">
					<span id="span2">Category</span>
					<select id="category" name="category" style="width:30%;border-radius:12px;height:37px;"> 
						<option>Other</option>
						<option>Faculty</option>
						<option>Student</option>
					</select><br/><br/>
				    <span id="span2" style="margin-left:20px;">Sub Categry</span>
					<input type="text" name="subcategory" style="width:30%;border-radius:5px;height:37px; border:.8px solid aqua;" placeholder="Please Enter a subcategory..">
					<br /><br />
                    
					<span id="span2">Nature of Complaint</span><input type="text" name="nature" class="form-control in2" placeholder="Regarding to ...."><br />
					<span id="span2">Domain</span>
                    <select id="Domain" name="Domain" style="width:30%;border-radius:12px;height:37px;"> 
						<option>Academics</option>
						<option>Personal</option>
						<option>Infrastructure</option>
					</select></br><br/>
                    <span id="span">Complaint</span>
					<textarea name="comp" class="form-control in1" placeholder="Feel free to write. Your complaint is secure." style="height:200px;"></textarea><br />
					<br /><span id="span">Regarding File (If any) Max Size 2Mb</span><input name="f2" type="file" class="form-control" >
				<br />
					<input type="submit"  class="btn btn-success " style="width:auto ;padding:10px;padding-left:50px;padding-right:50px;"  value="Send"><br />
				</form>
			</div>-->
			
			<!----------------------------------------------------------------------------------------makecomp-->
			<!----------------------------------------------------------------------------------------pending-->
			<div class="" id="pending" style="width:90%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:rgba(32, 76, 5, 0.1);border:1px solid aqua;">
				<h4>>Pending Information<hr /></h4>
				<?php
	$query1="SELECT * FROM `complaints`";
	$result=mysqli_query($conn,$query1);
	$num=0;
	if($result)
	{						echo "<table class='table'><tr class='tr'>";
									echo "<th>Number</th><th>Category</th><th>Sub-Category</th><th>Nature</th><th>Date & Time</th><th>File</th><th>Complaints</th></tr>";
									$num=0;
		while($row=mysqli_fetch_assoc($result))
		{
			if($user==$row['user'])
			{
				$cme=$row['pending'];
				if($cme=='1')
				{							$num++;
											$cate=$row['category'];
											$subcate=$row['subcategory'];
											$nat=$row['nature'];
											$da=$row['date'];
											$fil=$row['file'];
											$co=$row['comp'];
											echo "<tr class='tr'>
											<td>$num</td>
											<td>$cate</td>
											<td>$subcate</td>
											<td>$nat</td>
											<td>$da</td>";
											if($fil==""||$fil=='0')
											{
												
											echo "<td>No file</td>";
											}
											else{
											echo "<td><a href='$fil' target='_blank'>view file</a></td>";
											}
											echo "<td style='width:200px;'>";
											echo $co;
											echo "</td>
											</tr>";
				}
			}
		}
		echo "</table>";
	}
	if($num==0)
	{
		echo "Still there is no record";
	}
				?>
			</div>
			
			<!----------------------------------------------------------------------------------------pending-->
			<!----------------------------------------------------------------------------------------inpro-->
			<div class="" id="inpro" style="width:90%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:white">
				<h4 style="color:orangered;">Inprogress Complaints<hr /></h4>
				<?php
				$num=0;
				$query1="SELECT * FROM `complaints`";
				$seeme="SELECT * FROM `inprogresscomp`";
				$resolt=mysqli_query($conn,$seeme);
					
					if($resolt)
					{
						while($cmp=mysqli_fetch_assoc($resolt))
						{
							$tellme=$cmp['user'];
						if($user==$tellme)
						{
							$inid=$cmp['compnum'];
							$remark=$cmp['remarks'];
						$result=mysqli_query($conn,$query1);
						
						if($result)
							{
							while($row=mysqli_fetch_assoc($result))
								{				
										$id=$row['id'];
										if($id==$inid)
										{
											$num++;
											$cate=$row['category'];
											$subcate=$row['subcategory'];
											$nat=$row['nature'];
											$da=$row['date'];
											$fil=$row['file'];
											$co=$row['comp'];
											echo "<h5 class='tr'>											
											Number:$num			
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
											 Complaint-categoty:<span id='span'> $cate</span><br />
											 Complaint-Subcategoty:   <span id='span'>$subcate</span><br />
											 Complaint-Nature:        <span id='span'>$nat</span><br />
											 Complaint-Date:          <span id='span'>$da</span><br />
											 COMLAINT >               <span id='span'>$co</span><br /></h6><br /><hr />";
										}
										
									
								}
							}
						}
						}
					}
	if($num==0)
	{
		echo "Still there is no record";
	}
				?>
			</div>
			
			<!----------------------------------------------------------------------------------------inpro-->
			<!----------------------------------------------------------------------------------------completed-->
			<div class="" id="completed" style="width:90%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:white">
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
							$tellme=$coomp['user'];
						if($user==$tellme)
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
											$cate=$row['category'];
											$subcate=$row['subcategory'];
											$nat=$row['nature'];
											$da=$row['date'];
											$fil=$row['file'];
											$co=$row['comp'];
											echo "<h5 class='tr'>											
											Number:$num			
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
											 Complaint-categoty:<span id='span'> $cate</span><br />
											 Complaint-Subcategoty:   <span id='span'>$subcate</span><br />
											 Complaint-Nature:        <span id='span'>$nat</span><br />
											 Complaint-Date:          <span id='span'>$da</span><br />
											 COMLAINT >               <span id='span'>$co</span><br /></h6><br /><hr />";
										}
										
									
								}
							}
						}
						}
					}		
				?>
			</div>
			
			<!----------------------------------------------------------------------------------------completed-->
			<!----------------------------------------------------------------------------------------history-->
			<div class="" id="history" style="width:90%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:white">
				<h4 style="color:orangered;">History Information<hr /></h4>
				<?php
					$conn=mysqli_connect($servername,$username,$password,$dbname);
					if($conn)
						{
							$query1="SELECT * FROM `complaints`";
							$result=mysqli_query($conn,$query1);
							if($result)
								{
									$num=0;
									echo "<table class='table'><tr class='tr'>";
									echo "<th>Number</th><th>Category</th><th>Sub-Category</th><th>Nature</th><th>Date & Time</th><th>File</th><th>Complaints</th></tr>";
									while($row=mysqli_fetch_assoc($result))
									{ 
										if($user==$row['user'])
										{$num++;
											$cate=$row['category'];
											$subcate=$row['subcategory'];
											$nat=$row['nature'];
											$da=$row['date'];
											$fil=$row['file'];
											$co=$row['comp'];
											echo "<tr class='tr'>
											<td>$num</td>
											<td>$cate</td>
											<td>$subcate</td>
											<td>$nat</td>
											<td>$da</td>";
											if($fil==""||$fil=='0')
											{
												
											echo "<td>No file</td>";
											}
											else{
											echo "<td><a href='$fil' target='_blank'>view file</a></td>";
											}
											echo "<td style='width:200px;'>";
											echo $co;
											echo "</td>
											</tr>";
											
										}
									}
									echo "</table>";
									if($num==0)
									{
										echo "NO complaint made yet.";
									}
								}
						}
				?>
			</div>
			
			<!----------------------------------------------------------------------------------------history-->
			<!----------------------------------------------------------------------------------------changepass-->
			<div class="" id="changepass" style="width:90%;display:none;border-radius:15px;padding:15px;margin:10px;background-color:rgba(32, 76, 5, 0.1);border:1px solid aqua;">
				<h4>>Change Password<hr /></h4>
				<form class="form" action="userchangepass.php" method="POST" style="width:100%;">
				
					<span id="span">Enter OLD password</span><input type="password"  name="oldpass" class="form-control in1" placeholder="Old Password..."><br />		
					<span id="span">Enter new Password</span><input type="password" name="newpass" class="form-control in1" placeholder="New Password..."><br />
					<span id="span">Re-enter new password</span><input type="password" name="renewpass" class="form-control in1" placeholder="Re-enter New Password..."><br />
					
					<input type="submit"  class="btn btn-success " style="width:auto ;padding:10px;padding-left:50px;padding-right:50px;"  value="save"><br />
				</form>
			</div>
			
			<!----------------------------------------------------------------------------------------changepass-->
		</div>
    </div>
    </div>
	</body>
</html>
        



  		