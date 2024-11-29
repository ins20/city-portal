<?php
require_once 'config.php';

if (!isAdmin()) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Городские проблемы</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="cabinet.php">Личный кабинет</a>
                <a class="nav-link" href="logout.php">Выход</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <ul class="nav nav-tabs" id="adminTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#requests">Заявки</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#categories">Категории</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Вкладка заявок -->
            <div class="tab-pane fade show active" id="requests">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Пользователь</th>
                                <th>Название</th>
                                <th>Категория</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="requestsAdminTable">
                            <!-- Данные будут загружены через AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Вкладка категорий -->
            <div class="tab-pane fade" id="categories">
                <form id="addCategoryForm" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="category_name" placeholder="Название категории"
                            required>
                        <button class="btn btn-primary" type="submit">Добавить категорию</button>
                    </div>
                </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Название категории</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTable">
                        <!-- Данные будут загружены через AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Модальное окно изменения статуса -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Изменить статус заявки</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="changeStatusForm">
                        <input type="hidden" name="request_id">
                        <div class="mb-3">
                            <label class="form-label">Новый статус</label>
                            <select class="form-select" name="status" required>
                                <option value="Решена">Решена</option>
                                <option value="Отклонена">Отклонена</option>
                            </select>
                        </div>
                        <div class="mb-3 solved-only">
                            <label class="form-label">Фото решения</label>
                            <input type="file" class="form-control" name="image_after">
                        </div>
                        <div class="mb-3 rejected-only" style="display:none;">
                            <label class="form-label">Причина отказа</label>
                            <textarea class="form-control" name="rejection_reason"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Загрузка заявок для администратора
            function loadAdminRequests() {
                $.get('get_admin_requests.php', function (data) {
                    $('#requestsAdminTable').html(data);
                });
            }

            // Загрузка категорий
            function loadCategories() {
                $.get('get_categories.php', function (data) {
                    $('#categoriesTable').html(data);
                });
            }

            // Добавление категории
            $('#addCategoryForm').on('submit', function (e) {
                e.preventDefault();
                $.post('add_category.php', $(this).serialize(), function (response) {
                    if (response.success) {
                        loadCategories();
                        $('#addCategoryForm')[0].reset();
                    } else {
                        alert(response.message);
                    }
                });
            });

            // Удаление категории
            $(document).on('click', '.delete-category', function () {
                if (confirm('Вы действительно хотите удалить категорию? Все связанные заявки будут удалены.')) {
                    let categoryId = $(this).data('id');
                    $.post('delete_category.php', { id: categoryId }, function (response) {
                        if (response.success) {
                            loadCategories();
                        } else {
                            alert(response.message);
                        }
                    });
                }
            });

            // Изменение статуса заявки
            $(document).on('click', '.change-status', function () {
                let requestId = $(this).data('id');
                $('input[name="request_id"]').val(requestId);
                $('#changeStatusModal').modal('show');
            });

            // Показ/скрытие полей в зависимости от выбранного статуса
            $('select[name="status"]').on('change', function () {
                if ($(this).val() === 'Решена') {
                    $('.solved-only').show();
                    $('.rejected-only').hide();
                } else {
                    $('.solved-only').hide();
                    $('.rejected-only').show();
                }
            });

            // Отправка формы изменения статуса
            $('#changeStatusForm').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: 'change_status.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $('#changeStatusModal').modal('hide');
                            loadAdminRequests();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            // Начальная загрузка
            loadAdminRequests();
            loadCategories();
        });
    </script>
</body>

</html>