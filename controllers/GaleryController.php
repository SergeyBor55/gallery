<?php

class GaleryController
{
    // галерея
    public function actionIndex()
    {
        $images = Images::getImages();

        $name = '';
        $surname = '';
        $name_photo = '';

        if (isset($_POST['submit']) && is_uploaded_file($_FILES['user_file']['tmp_name'])) {
            $name = User::checkUserInput($_POST['name']);
            $surname = User::checkUserInput($_POST['surname']);
            $name_photo = User::checkUserInput($_POST['name_photo']);
            $blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm");
            $size = $_FILES['user_file']['size'];
            $errors = false;

            foreach ($blacklist as $item)
                if (preg_match("/$item\$/i", $_FILES['user_file']['name'])) {
                    $errors[] = 'Файл который вы пытались загрузить не является файлом допустимым к загрузке';
                }
            if (!User::checkSizeFile($size)) {
                $errors[] = 'Размер файла не должен привышать 300 кб';
            }

            if ($errors == false) {
                $type = '.' . basename($_FILES['user_file']['type']);
                $id = Images::loadImages($name, $surname, $name_photo, $type);
                Images::loadMaxAndMinImages($id, $type);
                header('Location: /');
            }
        }

        // если был послан Ajax запрос
        if (isset($_POST['id'])) {
            $id = User::checkUserInput($_POST['id']);

            Images::countOfViewsImage($id);
        }

        require_once 'views/view.php';
    }
}
