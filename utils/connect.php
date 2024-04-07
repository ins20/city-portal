<?php
//server with default setting (user 'root' with no password)
$host = 'localhost';  // server 
$user = 'root';
$password = "";
$database = 'city-portal';   //Database Name  

// establishing connection
$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

