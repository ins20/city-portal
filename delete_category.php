<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'Доступ запрещен']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = (int) $_POST['id'];

    // Удаляем категорию (связанные заявки удалятся автоматически благодаря ON DELETE CASCADE)
    if ($conn->query("DELETE FROM categories WHERE id = $category_id")) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка удаления категории']);
    }
    exit;
}