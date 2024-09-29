<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $pass = $_POST['passw'];
    
    if (validateAdminCredentials($name, $pass)) {
        $_SESSION['admin_name'] = $name;
        
        header("Location: afteradminlogin.php");
        exit();
    } else {
        readfile('adminlogin2.html');
    }
} else {
    readfile('adminlogin2.html');
}

function validateAdminCredentials($username, $password) {
    
    $admin_username = "admin"; // Temporary admin username
    $admin_password = "adminpassword"; // Temporary admin password
    
    if ($username == $admin_username && $password == $admin_password) {
        return true;
    } else {
        return false;
    }
}
?>
