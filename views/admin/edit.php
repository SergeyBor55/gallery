<?php include_once 'views/layouts_admin/admin_header.php'; ?>
    <main>
        <form class="contact" action="" method="post">
            <h4>Изменить логин и пароль</h4><br>
            <label>Логин<br>
                <input type="text" name="login" placeholder="login" value="<?= $login ?>"></label><br>
            <label>Пароль<br>
                <input type="password" name="password" placeholder="password" value="<?= $password ?>"></label><br>
            <input type="submit" name="submit" value="Отправить"><br>
        </form>
        <?php
        if (isset($errors) && is_array($errors)):
            foreach ($errors as $error):?>
                <span class="error"><?= $error; ?></span><br>
            <?php
            endforeach;
        endif; ?>
    </main>
<?php include_once 'views/layouts_admin/admin_footer.php'; ?>