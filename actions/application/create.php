<?php
require_once '../../utils/connect.php';
$title = $_POST['title'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];
$imageBefore = $_FILES['imageBefore'];
$user_id = $_SESSION['user']['id'];

$sql = "INSERT INTO application (id, title, description, category_id, imageBefore, user_id) VALUES (UUID(),'$title', '$description', '$category_id', '$imageBefore', '$user_id')";

$result = $conn->query($sql);