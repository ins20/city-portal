<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Городские проблемы</a>
            <div class="navbar-nav ms-auto">
                <?php if (isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Панель администратора</a>
                    </li>
                <?php endif; ?>
                <a class="nav-link" href="logout.php">Выход</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Мои заявки</h2>

        <!-- Форма создания заявки -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createRequestModal">
            Создать заявку
        </button>

        <!-- Фильтр по статусу -->
        <div class="mb-3">
            <select id="statusFilter" class="form-select">
                <option value="">Все статусы</option>
                <option value="Новая">Новая</option>
                <option value="Решена">Решена</option>
                <option value="Отклонена">Отклонена</option>
            </select>
        </div>

        <!-- Таблица заявок -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Категория</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody id="requestsTable">
                    <!-- Данные будут загружены через AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно создания заявки -->
    <div class="modal fade" id="createRequestModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Создать заявку</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createRequestForm">
                        <div class="mb-3">
                            <label class="form-label">Название</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select class="form-select" name="category_id" id="categorySelect" required>
                                <?php
                                $query = "SELECT * FROM categories ORDER BY name";
                                $result = $conn->query($query);
                                echo "<option value=''>Выберите категорию</option>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Фото проблемы</label>
                            <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png,.bmp" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Создать заявку</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Загрузка заявок
            function loadRequests(status = '') {
                $.get('get_requests.php', { status: status }, function (data) {
                    $('#requestsTable').html(data);
                });
            }

            // Создание заявки
            $('#createRequestForm').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: 'create_request.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $('#createRequestModal').modal('hide');
                            loadRequests();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            // Удаление заявки
            $(document).on('click', '.delete-request', function () {
                if (confirm('Вы действительно хотите удалить заявку?')) {
                    let requestId = $(this).data('id');
                    $.post('delete_request.php', { id: requestId }, function (response) {
                        if (response.success) {
                            loadRequests();
                        } else {
                            alert(response.message);
                        }
                    });
                }
            });

            // Фильтрация по статусу
            $('#statusFilter').on('change', function () {
                loadRequests($(this).val());
            });

            // Начальная загрузка
            loadRequests();
        });
    </script>
</body>

</html>