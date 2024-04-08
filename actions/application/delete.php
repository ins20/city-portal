<?php
require_once '../../utils/connect.php';
$id = $_GET['id'];
echo $id;
$sql = "DELETE FROM application WHERE id = '$id'";
$result = $conn->query($sql);

header("Location: /profile.php");