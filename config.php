<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'city-portal');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
// Добавьте эту функцию в config.php
function checkAndCreateUploadDir()
{
    $uploadDir = 'uploads';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
}
// Функция для проверки авторизации
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Функция для проверки прав администратора
function isAdmin()
{
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}