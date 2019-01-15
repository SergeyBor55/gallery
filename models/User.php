<?php


class User
{
    public static function checkSizeFile($size){
        if ($size > 307200) {
            return false;
        } else {
            return true;
        }
    }

    //функция проверят пользовательский ввод
    public static function checkUserInput($value)
    {
        $value = strip_tags($value);
        $value = htmlentities($value, ENT_QUOTES);

        return $value;
    }
}