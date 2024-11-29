<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $conn->real_escape_string($_POST['login']);
    $password = $_POST['password'];

    $query = "SELECT id, password, is_admin FROM users WHERE login = '$login'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin'];

            echo json_encode([
                'success' => true,
                'is_admin' => $user['is_admin']
            ]);
            exit;
        }
    }

    echo json_encode([
        'success' => false,
        'message' => 'Неверный логин или пароль'
    ]);
    exit;
}