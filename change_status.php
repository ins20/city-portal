<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'Доступ запрещен']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = (int) $_POST['request_id'];
    $status = $conn->real_escape_string($_POST['status']);

    if ($status == 'Решена') {
        // Проверка загруженного файла
        if (!isset($_FILES['image_after']) || $_FILES['image_after']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'Необходимо загрузить фото решения']);
            exit;
        }

        checkAndCreateUploadDir();

        $file = $_FILES['image_after'];
        $filename = uniqid() . '_' . str_replace(' ', '_', $file['name']);
        $upload_path = 'uploads/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            $query = "UPDATE requests SET status = 'Решена', image_after = '$filename' WHERE id = $request_id";
        } else {
            echo json_encode(['success' => false, 'message' => 'Ошибка сохранения файла']);
            exit;
        }
    } else {
        $reason = $conn->real_escape_string($_POST['rejection_reason']);
        $query = "UPDATE requests SET status = 'Отклонена', rejection_reason = '$reason' WHERE id = $request_id";
    }

    if ($conn->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка обновления статуса']);
    }
    exit;
}