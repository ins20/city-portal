<?php
require_once 'config.php';

if (isAdmin()) {
    // Для админа показываем с кнопкой удаления
    $query = "SELECT * FROM categories ORDER BY name";
    $result = $conn->query($query);
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>
                    <button class='btn btn-danger btn-sm delete-category' data-id='" . $row['id'] . "'>Удалить</button>
                </td>
              </tr>";
    }
} else {
    // Для обычного пользователя возвращаем options для select
    $query = "SELECT * FROM categories ORDER BY name";
    $result = $conn->query($query);
    
    echo "<option value=''>Выберите категорию</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
    }
}