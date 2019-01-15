<?php

class AdminController
{

    //главная страница админ панели
    public function actionIndex()
    {

        Admin::checkAdmin();

        $imagesList = Images::getImagesForAdmin();

        require_once 'views/admin/index.php';
    }


    //добавить записи в админ панели
    public function actionCreate()
    {

        Admin::checkAdmin();

        if (isset($_POST['submit']) && is_uploaded_file($_FILES['user_file']['tmp_name'])) {
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $name_photo = $_POST['name_photo'];
            $status = $_POST['status'];
            $size = $_FILES['user_file']['size'];
            $errors = false;

            if (!User::checkSizeFile($size)) {
                $errors[] = 'Размер файла не должен привышать 300 кб';
            }

            if ($errors == false) {
                $type = '.' . basename($_FILES['user_file']['type']);
                $id = Images::loadImages($name, $surname, $name_photo, $type, $status);
                Images::loadMaxAndMinImages($id, $type);
                header('Location: /admin/index');
            }
        }
        require_once 'views/admin/create.php';
    }


    //изменение записи в админ панели
    public function actionUpdate($id)
    {
        Admin::checkAdmin();

        $images = Images::getImageForAdminById($id);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $name_photo = $_POST['name_photo'];
            $status = $_POST['status'];

            if (is_uploaded_file($_FILES['user_file']['tmp_name'])){
                $size = $_FILES['user_file']['size'];
                $errors = false;

                if (!User::checkSizeFile($size)) {
                    $errors[] = 'Размер файла не должен привышать 300 кб';
                }
                if ($errors == false){
                    $type = '.' . basename($_FILES['user_file']['type']);
                    Images::updateImage($id, $name, $surname, $name_photo, $status, $type);
                    Images::loadMaxAndMinImages($id, $type);
                    header('Location: /admin/index');
                }
            } else {
                Images::updateImage($id, $name, $surname, $name_photo, $status);
                header('Location: /admin/index');
            }
        }

        require_once 'views/admin/update.php';
    }


    //страница входа в админ панель
    public function actionLogin()
    {

        $login = '';
        $password = '';

        if (isset($_POST['submit'])) {
            $login = User::checkUserInput($_POST['login']);
            $password = $_POST['password'];
            $errors = false;

            if (strlen($login) < 6) {
                $errors[] = 'Логин не должен быть короче шести символов!';
            }
            if (strlen($password) < 6) {
                $errors[] = 'Пароль не должен быть короче шести символов!';
            }

            if ($errors == false) {
                $admin = Admin::getRegisteredAdmin($login);
                if (!$admin || !password_verify($password, $admin['password'])) {
                    $errors[] = 'Имя пользователя или пароль введены не верно или не существует';
                } else {
                    Admin::authAdmin($admin['login']);
                    header('Location: /admin/index');
                }
            }
        }
        require_once './views/admin/enter.php';
    }


    //страница редактирования логина и пароля админа
    public function actionEdit()
    {
        Admin::checkAdmin();

        $admin = Admin::getRegisteredAdmin($_SESSION['admin']);
        $login = $admin['login'];

        if (isset($_POST['submit'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $errors = false;

            if (strlen($login) < 6) {
                $errors[] = 'Логин не должен быть короче шести символов!';
            }
            if (strlen($password) < 6) {
                $errors[] = 'Пароль не должен быть короче шести символов!';
            }

            if ($errors == false) {
                Admin::editAdmin($login, $password, $admin['id']);
                Admin::authAdmin($login);
                header('Location: /admin/index');
            }
        }
        require_once './views/admin/edit.php';
    }


    //выход из админ панели
    public function actionLogout()
    {
        unset($_SESSION['admin']);
        header('Location: /admin');
    }


    //удаление записи в админ панели
    public static function actionDelete($id)
    {

        Admin::checkAdmin();

        if (isset($_POST['submit'])) {
            $type = Images::getExtensionImage($id);
            Images::deleteImage($id);
            unlink(PATH . '/views/original_image/'.$id.$type['type']);
            unlink(PATH . '/views/min_image/'.$id.$type['type']);
            header('Location: /admin/index');
        }
        require_once 'views/admin/delete.php';
    }
}
