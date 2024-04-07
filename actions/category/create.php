<?php
require_once '../../utils/connect.php';
$name = $_POST['name'];

$sql = "INSERT INTO category (id, name) VALUES (UUID(),'$name')";
$result = $conn->query($sql);

header('Location: /admin.php');

