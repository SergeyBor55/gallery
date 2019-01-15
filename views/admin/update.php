<?php include_once 'views/layouts_admin/admin_header.php'; ?>
    <main>
        <?php
        if (isset($errors) && is_array($errors)):?>
        <span class="error"><?= $errors[0];?></span><br>
        <?php endif;?>
        <form class="contact" action="" method="post" enctype="multipart/form-data">
            <h4>Редактировать данные</h4><br>
            <label>Имя<br>
                <input type="text" name="name" placeholder="" value="<?= $images['name'] ?>"></label><br>
            <label>Фамилия<br>
                <input type="text" name="surname" placeholder="" value="<?= $images['surname'] ?>"></label><br>
            <label>Название<br>
                <input type="text" name="name_photo" placeholder="" value="<?= $images['name_photo'] ?>"></label><br>
            <label>Опубликовать на сайте<br>
                <select name="status">
                    <option value="1" <? if($images['status'] == 1) { ?> selected="selected" <? } ?>>Да</option>
                    <option value="0" <? if($images['status'] == 0) { ?> selected="selected" <? } ?>>Нет</option>
                </select></label><br>
            <img src="/views/min_image/<?= $images['id'].$images['type'] ?>" alt="#"><br>
            <input type="file" name="user_file" accept="image/jpeg,image/png,image/gif"><br>
            <input type="submit" name="submit" value="Отправить"><br>
        </form>
    </main>
<?php include_once 'views/layouts_admin/admin_footer.php'; ?>