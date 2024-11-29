<?php
require_once 'config.php';

header('Content-Type: application/json');

// Получаем количество решенных заявок
$query = "SELECT COUNT(*) as count FROM requests WHERE status = 'Решена'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

echo json_encode([
    'count' => $row['count']
]);