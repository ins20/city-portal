<?php
require_once 'config.php';

if (!isAdmin()) {
    exit;
}

$query = "SELECT r.*, c.name as category_name, u.full_name as user_name 
          FROM requests r 
          LEFT JOIN categories c ON r.category_id = c.id 
          LEFT JOIN users u ON r.user_id = u.id 
          ORDER BY r.created_at DESC";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . date('d.m.Y H:i', strtotime($row['created_at'])) . "</td>
            <td>" . htmlspecialchars($row['user_name']) . "</td>
            <td>" . htmlspecialchars($row['title']) . "</td>
            <td>" . htmlspecialchars($row['category_name']) . "</td>
            <td>" . $row['status'] . "</td>
            <td>";

    if ($row['status'] == 'Новая') {
        echo "<button class='btn btn-primary btn-sm change-status' data-id='" . $row['id'] . "'>Изменить статус</button>";
    }

    echo "</td></tr>";
}