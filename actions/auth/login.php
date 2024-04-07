<?php
require_once '../../utils/connect.php';

$login = $_POST['login'];
$password = $_POST['password'];


$sql = "SELECT * FROM user WHERE login = '$login'";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (password_verify($password, $row['password'])) {
    session_start();
    $_SESSION['user'] = $row;
    header('Location: /profile.php');
}
?>