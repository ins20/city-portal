<!DOCTYPE html>
<html lang="en">
<?php require_once './components/head.php'; ?>

<body>
    <div class="h-screen flex flex-col md:flex-row">
        <div class="relative md:w-1/2 flex justify-center items-center">
            <div class=" space-y-10">
                <h1 class="text-white text-4xl font-sans text-center w-full tracking-widest">Городской портал</h1>
                <h2 class="text-white text-2xl  text-center w-full tracking-widest">Сделаем лучше вместе!</h2>
                <h3 class="text-white text-xl text-center w-full tracking-widest">Решенных заявок : 23</h3>
                <div class="flex flex-wrap gap-3 py-3">

                    <div>
                        <img src="https://source.unsplash.com/random/200x200?sig=1" alt="" class="w-full">
                        <ul class="text-black bg-white p-3">
                            <li>Дата</li>
                            <li>Название</li>
                            <li>Категория</li>
                        </ul>
                    </div>
                    <div>
                        <img src="https://source.unsplash.com/random/200x200?sig=2" alt="" class="w-full">
                        <ul class="text-black bg-white p-3">
                            <li>Дата</li>
                            <li>Название</li>
                            <li>Категория</li>
                        </ul>
                    </div>
                    <div>
                        <img src="https://source.unsplash.com/random/200x200?sig=3" alt="" class="w-full">
                        <ul class="text-black bg-white p-3">
                            <li>Дата</li>
                            <li>Название</li>
                            <li>Категория</li>
                        </ul>
                    </div>
                    <div>
                        <img src="https://source.unsplash.com/random/200x200?sig=4" alt="" class="w-full">
                        <ul class="text-black bg-white p-3">
                            <li>Дата</li>
                            <li>Название</li>
                            <li>Категория</li>
                        </ul>
                    </div>
                </div>

            </div>

            <img src="https://mykaleidoscope.ru/x/uploads/posts/2022-09/1663226013_52-mykaleidoscope-ru-p-izhevsk-stolitsa-udmurtii-pinterest-53.jpg"
                alt="" class="absolute h-full w-full object-cover -z-50 brightness-50 top-0 left-0">
        </div>
        <div class="flex md:w-1/2 justify-center py-10 items-center bg-white" id="form">
            <?php require_once './components/login-form.php'; ?>
        </div>
    </div>
</body>

</html>