<?php
require_once 'config.php';

// Получаем последние 4 решенные заявки
$query = "SELECT r.*, c.name as category_name 
          FROM requests r 
          LEFT JOIN categories c ON r.category_id = c.id 
          WHERE r.status = 'Решена' 
          ORDER BY r.created_at DESC 
          LIMIT 4";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo '<div class="col-md-3 mb-4">
            <div class="card solved-request">
                <img src="uploads/' . htmlspecialchars($row['image_after']) . '" 
                     class="card-img-top request-image image-after" 
                     alt="После">
                <img src="uploads/' . htmlspecialchars($row['image_before']) . '" 
                     class="card-img-top request-image image-before" 
                     alt="До">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>
                    <p class="card-text">
                        <small class="text-muted">
                            Категория: ' . htmlspecialchars($row['category_name']) . '<br>
                            Дата: ' . date('d.m.Y H:i', strtotime($row['created_at'])) . '
                        </small>
                    </p>
                </div>
            </div>
          </div>';
}