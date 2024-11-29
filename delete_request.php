<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Необходима авторизация']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = (int) $_POST['id'];
    $user_id = $_SESSION['user_id'];

    // Проверяем, что заявка принадлежит пользователю и имеет статус "Новая"
    $query = "SELECT * FROM requests WHERE id = $request_id AND user_id = $user_id AND status = 'Новая'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $request = $result->fetch_assoc();

        // Удаляем файл
        if (file_exists('uploads/' . $request['image_before'])) {
            unlink('uploads/' . $request['image_before']);
        }

        // Удаляем запись из БД
        if ($conn->query("DELETE FROM requests WHERE id = $request_id")) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ошибка удаления заявки']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Заявка не найдена или не может быть удалена']);
    }
    exit;
}