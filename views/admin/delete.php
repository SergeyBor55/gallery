<?php include_once 'views/layouts_admin/admin_header.php'; ?>
<main>
    <h4 class="delete">Удалить фотографию №<?= $id ?></h4>
    <p>Вы действительно хотите удалить данные о фото?</p>
    <form method="POST">
        <input type="submit" name="submit" value="Удалить">
    </form>
</main>
<?php include_once 'views/layouts_admin/admin_footer.php'; ?>