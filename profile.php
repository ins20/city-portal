<!DOCTYPE html>
<html lang="en">

<?php require_once './components/head.php'; ?>

<body class="p-6">
    <header class="flex justify-between mb-6">
        <a href="/">Выйти</a>
        <a href="admin.php">Админка</a>
    </header>
    <main>
        <form class="flex flex-col gap-3 w-1/3" action="./actions/application/create.php" enctype="multipart/form-data"
            method="POST">
            <input name="title" placeholder="Название"
                class="p-3 border border-black text-xs font-bold transition-all hover:bg-black hover:text-white" />
            <textarea name="description" placeholder="Описание"
                class="p-3 border border-black text-xs font-bold hover:bg-black hover:text-white"></textarea>
            <select id="category" name="category_id"
                class="p-3 border border-black text-xs font-bold transition-all hover:bg-black hover:text-white">
                <?php
                require_once './utils/connect.php';

                $sql = "SELECT * FROM `category`";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $name = $row['name'];

                    echo "<option value='{$id}'> {$name} </option>";
                }
                ?>
            </select>
            <input type="file" id="imageBefore" name="imageBefore" class="hidden" />
            <label for="imageBefore"
                class="cursor-pointer p-3 border border-black text-xs font-bold uppercase transition-all hover:bg-black hover:text-white">Фото</label>
            <button
                class="select-none bg-white border border-black p-3  text-xs font-bold uppercase transition-all hover:bg-black hover:text-white ">
                Отправить
            </button>
        </form>
        <select name="status" id=""
            class="mt-3 p-3 border border-black text-xs font-bold uppercase transition-all hover:bg-black hover:text-white">
            <option value="ALL">все</option>
            <option value="NEW">новая</option>
            <option value="APPROVED">решена</option>
            <option value="REJECTED">отклонена</option>
        </select>

        <table class="min-w-full text-left text-sm font-light text-surface">
            <thead class="border-b border-neutral-200 font-medium">
                <tr>
                    <th scope="col" class="p-3">Дата</th>
                    <th scope="col" class="p-3">Название</th>
                    <th scope="col" class="p-3">Описание</th>
                    <th scope="col" class="p-3">Категория</th>
                    <th scope="col" class="p-3">Статус</th>
                </tr>
            </thead>
            <tbody>

                <?php
                require_once './utils/connect.php';

                $sql = "SELECT application.*, category.name 
                FROM application 
                INNER JOIN category ON application.category_id = category.id";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $created_at = $row['created_at'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $category_name = $row['name'];
                    $status = $row['status'];
                    echo "<tr class='border-b border-neutral-200'> ";
                    echo "<td class='p-3'>$created_at</td>";
                    echo "<td class='p-3'>$title</td>";
                    echo "<td class='p-3'>$description</td>";
                    echo "<td class='p-3'>$category_name</td>";
                    echo "<td class='p-3'>$status</td>";
                    echo "<td>
                    <a
                    onclick='return confirm(`Вы действительно хотите удалить?`)'
                        href='./actions/application/delete.php?id={$id}'
                        class='select-none bg-white p-3  text-xs font-bold uppercase transition-all hover:bg-black hover:text-white '>Удалить</a>
                </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </main>
</body>


</html>