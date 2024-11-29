<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Необходима авторизация']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $category_id = (int) $_POST['category_id'];
    $user_id = $_SESSION['user_id'];

    // Проверка загруженного файла
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Ошибка загрузки файла']);
        exit;
    }

    $file = $_FILES['image'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/bmp'];
    $max_size = 10 * 1024 * 1024; // 10MB

    if (!in_array($file['type'], $allowed_types)) {
        echo json_encode(['success' => false, 'message' => 'Неверный формат файла']);
        exit;
    }

    if ($file['size'] > $max_size) {
        echo json_encode(['success' => false, 'message' => 'Файл слишком большой']);
        exit;
    }

    // Проверяем и создаем директорию если нужно
    checkAndCreateUploadDir();

    // Сохранение файла
    $filename = uniqid() . '_' . str_replace(' ', '_', $file['name']); // Заменяем пробелы на подчеркивания
    $upload_path = 'uploads/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        $query = "INSERT INTO requests (user_id, title, description, category_id, image_before) 
                  VALUES ($user_id, '$title', '$description', $category_id, '$filename')";

        if ($conn->query($query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ошибка сохранения заявки']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка сохранения файла']);
    }
    exit;
}