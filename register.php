<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $conn->real_escape_string($_POST['full_name']);
    $login = $conn->real_escape_string($_POST['login']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Проверка уникальности логина
    $checkLogin = $conn->query("SELECT id FROM users WHERE login = '$login'");
    if ($checkLogin->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Этот логин уже занят'
        ]);
        exit;
    }

    // Проверка email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => 'Неверный формат email'
        ]);
        exit;
    }

    // Хеширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Добавление пользователя в базу
    $query = "INSERT INTO users (full_name, login, email, password) 
              VALUES ('$fullName', '$login', '$email', '$hashedPassword')";

    if ($conn->query($query)) {
        // Автоматическая авторизация после регистрации
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['is_admin'] = 0;

        echo json_encode([
            'success' => true,
            'message' => 'Регистрация успешно завершена'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Ошибка при регистрации: ' . $conn->error
        ]);
    }
    exit;
}