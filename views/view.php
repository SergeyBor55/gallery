<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/views/style.css">
    <title>Галерея</title>
</head>
<body>

<div class="container_header"></div>
<div class="container">
    <header>
        <h1>Галерея фотографий</h1>
    </header>
    <main>
        <h4>Заполните форму для загрузки фотографии</h4>
        <p>Фотография будет добавлена в галерею после прохождения модерации.</p>
        <form method="post" action="" enctype="multipart/form-data">
            <label>Имя<br>
                <input type="text" name="name" required="required" placeholder="Иван" value="<?= $name?>"></label><br>
            <label>Фамилия<br>
                <input type="text" name="surname" required="required" placeholder="Иванов" value="<?= $surname?>"></label><br>
            <label>Название<br>
                <input type="text" name="name_photo" required="required" placeholder="Осенний лес" value="<?= $name_photo?>"></label><br>
            <input type="file" name="user_file" accept="image/jpeg, image/png, image/gif" required="required"><br>
            <input type="submit" name="submit" value="Загрузить">
        </form>
        <?php
        if (isset($errors) && is_array($errors)) {
            foreach ($errors as $error) { ?>
                <div class="error">
                    <p><?= $error ?></p><br>
                </div>
                <?php
            }
        }
        ?>
        <section>
            <?php
            foreach ($images as $img):?>
                <a class="image" href="/views/original_image/<?= $img['id']?><?= $img['type']?>" target="_blank" id="<?= $img['id']?>">
                    <img src="/views/min_image/<?= $img['id']?><?= $img['type']?>" alt="#"><br>
                    <p class="title"><?= $img['name_photo'] ?></p>
                    <span>Автор: <?= $img['surname'] ?></span> <span><?= $img['name'] ?></span><br>
                    <span>Просмотров: <?= $img['count_opened'] ?></span>
                </a>
            <?php endforeach; ?>
        </section>
        <div class="pillow"></div>
    </main>
</div>
<div class="container_footer">
    <footer>
        <span>2018&copy Copyright Galery, All Rights Reserved</span>
    </footer>
</div>
<script src="views\jquery.js"></script>
<script>
    $(document).ready(function () {
        $(".image").click(function () {
            var id = $(this).attr("id");
            $.post("/", {id})
        });
    });
</script>
</body>
</html>
