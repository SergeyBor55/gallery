<?php include_once 'views/layouts_admin/admin_header.php'; ?>
<main>
    <?php
    if (isset($errors) && is_array($errors)):?>
        <span class="error"><?= $errors[0];?></span><br>
    <?php endif;?>
    <form class="contact" action="" method="post" enctype="multipart/form-data">
        <label>Имя<br>
            <input type="text" name="name" placeholder="" value="<?= $name?>" required="required"></label><br>
        <label>Фамилия<br>
            <input type="text" name="surname" placeholder="" value="<?= $surname?>" required="required"></label><br>
        <label>Название<br>
            <input type="text" name="name_photo" placeholder="" value="<?= $name_photo?>" required="required"></label><br>
        <label>Опубликовать на сайте<br>
            <select name="status">
                <option value="1" selected="selected">Да</option>
                <option value="0">Нет</option>
            </select></label><br>
        <input type="file" name="user_file" required="required" accept="image/jpeg,image/png,image/gif"><br>
        <input type="submit" name="submit" value="Отправить"><br>
    </form>
</main>
<?php include_once 'views/layouts_admin/admin_footer.php'; ?>