<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Городские проблемы</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Городской портал</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (!isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Вход</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="modal"
                                data-bs-target="#registerModal">Регистрация</a>
                        </li>
                    <?php else: ?>
                        <?php if (isAdmin()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php">Панель администратора</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cabinet.php">Личный кабинет</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Выход</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2>Решенные проблемы</h2>
                <h3>Сделаем лучше вместе!</h3>

                <div class="solved-counter">
                    Решено проблем: <span id="solvedCount">
                        <?php
                        $query = "SELECT COUNT(*) as count FROM requests WHERE status = 'Решена'";
                        $result = $conn->query($query);
                        $row = $result->fetch_assoc();
                        echo $row['count'];
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row" id="solvedRequests">
            <!-- Здесь будут отображаться решенные заявки -->
        </div>
    </div>

    <!-- Модальное окно входа -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Вход</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label class="form-label">Логин</label>
                            <input type="text" class="form-control" name="login" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно регистрации -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Регистрация</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        <div class="mb-3">
                            <label class="form-label">ФИО</label>
                            <input type="text" class="form-control" name="full_name" pattern="^[а-яА-ЯёЁ\s-]+$"
                                title="Только кириллические буквы, дефис и пробелы" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Логин</label>
                            <input type="text" class="form-control" name="login" pattern="^[a-zA-Z]+$"
                                title="Только латинские буквы" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Введите корректный email адрес"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Повторите пароль</label>
                            <input type="password" class="form-control" name="password_confirm" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="agreement" required>
                            <label class="form-check-label">Согласие на обработку персональных данных</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>