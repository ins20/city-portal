<?php
require_once '../../utils/connect.php';
$id = $_GET['id'];
echo $id;
$sql = "DELETE FROM category WHERE id = '$id'";
$result = $conn->query($sql);

header("Location: /admin.php");