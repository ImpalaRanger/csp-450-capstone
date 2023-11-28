<?php

session_start();

if (isset($_POST['fromAuth']) && isset($_POST['fromAuth']) == '01') {
    $_SESSION['id'] = $_POST['user_id'];
}
else if (!isset($_SESSION['id'])){
    header('Location: /450Capstone/csp-450-capstone/LoginSignup/login.html');
    die();
}


$id = $_SESSION['id'];
$con = new mysqli("localhost", "root", "mysql", "therapy");

if($con->connect_error) {
    exit('Could not connect');
}
?>


