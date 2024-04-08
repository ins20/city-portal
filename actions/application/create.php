<?php
require_once '../../utils/connect.php';
$title = $_POST['title'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];
$user_id = '94065f45-f4ff-11ee-a2ad-708bcdaba73d';
$file = $_FILES['imageBefore'];
$imageBefore = addslashes(file_get_contents($_FILES['imageBefore']['tmp_name']));


$sql = "INSERT INTO application (id, title, description, category_id, imageBefore, user_id) VALUES (UUID(),'$title', '$description', '$category_id', '$imageBefore', '$user_id')";
$result = $conn->query($sql);

header('Location: /profile.php');
