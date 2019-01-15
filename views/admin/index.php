<?php include_once 'views/layouts_admin/admin_header.php'; ?>
    <main class="images">
        <a class="edit" href="/admin/edit">Изменить логин или пароль</a>
        <p class="admin_header"><a href="/admin/create"> Добавить фотографию</a></p>
        <table>
            <tr>
                <th class="header" colspan="9">Список всех фотографий</th>
            </tr>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Название</th>
                <th>Дата</th>
                <th>Просмотров</th>
                <th>Опубликовано</th>
                <th>Редактировать</th>
                <th>Удалить</th>
            </tr>
            <?php foreach ($imagesList as $imagesItem): ?>
                <tr>
                    <td><?= $imagesItem['id'] ?></td>
                    <td><?= $imagesItem['name'] ?></td>
                    <td><?= $imagesItem['surname'] ?></td>
                    <td><?= $imagesItem['name_photo'] ?></td>
                    <td><?= $imagesItem['date'] ?></td>
                    <td><?= $imagesItem['count_opened'] ?></td>
                    <td><?= ($imagesItem['status'] == 1)? 'да':'нет'?></td>
                    <td><a href="/admin/update/<?= $imagesItem['id'] ?>">Редактировать</a></td>
                    <td><a href="/admin/delete/<?= $imagesItem['id'] ?>">Удалить</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
<?php include_once 'views/layouts_admin/admin_footer.php'; ?>