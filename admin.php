<!DOCTYPE html>
<html lang="en">

<?php require_once './components/head.php'; ?>

<body class="p-6">
    <header class="flex justify-between mb-6">
        <a href="/">Выйти</a>
        <a href="profile.php">Профиль</a>
    </header>
    <main>
        <div class="flex">
            <form class="flex flex-col gap-3 w-1/3 mr-3" action="./actions/category/create.php"
                enctype="multipart/form-data" method="POST">
                <div class="relative h-11 w-full min-w-[200px]">
                    <input name="name" placeholder="Категория"
                        class="peer h-full w-full border-b border-blue-gray-200 bg-transparent pt-4 pb-1.5 font-sans text-sm font-normal text-blue-gray-700 outline outline-0 transition-all placeholder-shown:border-blue-gray-200 focus:border-gray-500 focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50 placeholder:opacity-0 focus:placeholder:opacity-100" />
                    <label
                        class="after:content[''] pointer-events-none absolute left-0  -top-1.5 flex h-full w-full select-none !overflow-visible truncate text-[11px] font-normal leading-tight text-gray-500 transition-all after:absolute after:-bottom-1.5 after:block after:w-full after:scale-x-0 after:border-b-2 after:border-gray-500 after:transition-transform after:duration-300 peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[4.25] peer-placeholder-shown:text-blue-gray-500 peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-gray-900 peer-focus:after:scale-x-100 peer-focus:after:border-gray-900 peer-disabled:text-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
                        Категория
                    </label>
                </div>
                <button
                    class="select-none bg-white border border-black p-3  text-xs font-bold uppercase transition-all hover:bg-black hover:text-white ">
                    Добавить
                </button>
            </form>
            <div class="flex space-x-4">
                <?php
                require_once './utils/connect.php';

                $sql = "SELECT * FROM `category`";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $name = $row['name'];

                    echo "<a onclick='return confirm(`Вы действительно хотите удалить?`)'  href='./actions/category/delete.php?id={$id}' class='select-none bg-white border border-black p-3  text-xs font-bold uppercase transition-all hover:bg-black hover:text-white' > {$name} </a>";
                }
                ?>
            </div>
        </div>
        <table class="min-w-full text-left text-sm font-light text-surface">
            <thead class="border-b border-neutral-200 font-medium">
                <tr>
                    <th scope="col" class="p-3">Дата</th>
                    <th scope="col" class="p-3">Название</th>
                    <th scope="col" class="p-3">Описание</th>
                    <th scope="col" class="p-3">Категория</th>
                    <th scope="col" class="p-3">Фото до</th>
                    <th scope="col" class="p-3">Фото после</th>
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