
<?php
session_start();

// Destroy all session variables
$_SESSION = array();

// Destroy the session itself
session_destroy();

// Redirect to login page (userlogin1.html in this case)
header("Location: usertype.html");
exit();
?>