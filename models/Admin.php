<?php

class Admin
{

    //получить логин и пароль админа для проверки введённых данных в форму администратора
    public static function getRegisteredAdmin($login)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user WHERE login = ?';
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute(array($login));

        $admin = $result->fetch();

        if ($admin) {
            return $admin;
        }
        return false;
    }


    //сохранить админа в сессию
    public static function authAdmin($login)
    {
        $_SESSION['admin'] = $login;
    }

    //Проверка аторизован ли админ
    public static function checkAdmin()
    {
        if (isset($_SESSION['admin'])) {
            return true;
        } else {
            die('У вас нет прав доступа к этой части сайта');
        }
    }

    //Изменить логин или пароль админа в БД
    public static function editAdmin($login, $password, $id)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $db = Db::getConnection();
        $sql = 'UPDATE user SET login = ?, password = ? WHERE id = ?';
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute(array($login, $password, $id));
    }
}