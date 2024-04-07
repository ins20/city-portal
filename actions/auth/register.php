<?php
require_once '../../utils/connect.php';

$login = $_POST['login'];
$password = $_POST['password'];
$fullName = $_POST['fullName'];
$email = $_POST['email'];

$hash = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO user (id, login, password, fullName, email) VALUES (UUID(), '$login', '$hash', '$fullName', '$email')";
$result = $conn->query($sql);

