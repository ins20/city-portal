<?php
require_once 'config.php';

$user_id = $_SESSION['user_id'];
$status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';

$query = "SELECT r.*, c.name as category_name 
          FROM requests r 
          LEFT JOIN categories c ON r.category_id = c.id 
          WHERE r.user_id = $user_id";

if ($status) {
    $query .= " AND r.status = '$status'";
}

$query .= " ORDER BY r.created_at DESC";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . date('d.m.Y H:i', strtotime($row['created_at'])) . "</td>
            <td>" . htmlspecialchars($row['title']) . "</td>
            <td>" . htmlspecialchars($row['description']) . "</td>
            <td>" . htmlspecialchars($row['category_name']) . "</td>
            <td>" . $row['status'] . "</td>
            <td>";
    
    if ($row['status'] == 'Новая') {
        echo "<button class='btn btn-danger btn-sm delete-request' data-id='" . $row['id'] . "'>Удалить</button>";
    }
    
    echo "</td></tr>";
}