<?php
// соединение с БД
class Db
{
    public static function getConnection()
    {
        $dsn = 'mysql:dbname=galery; host=localhost';
        $link = new PDO($dsn, 'mysql', '12345');
        $link->exec("set names utf8");


        return $link;
    }
}

?>