<?php
//ini_set('display_errors','Off');

session_start();

//автозагрузка классов
spl_autoload_register(function ($class) {
    $arrayPath = ['components/', 'models/'];

    foreach ($arrayPath as $item) {
        $path = $item . $class . '.php';
        if (is_file($path)) {
            include_once $path;
        }
    }
});

define('PATH', __DIR__);

$controller = new Router();
$controller->run();