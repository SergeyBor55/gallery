<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = include PATH . '/config/routes.php';
    }

    //Получаем строку запрса пользователя
    private function getUri() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return $uri = substr($_SERVER['REQUEST_URI'], strlen('/'));
        }
    }
    public function run()
    {

        $uri = $this->getUri();

        //проверить наличие запроса пользователя в массиве с роутами
        foreach ($this->routes as $uriPattern => $path) {


        //ТОЧНОЕ сравниваем $uri с $uriPattern
            if(preg_match("*^$uriPattern$*", $uri)) {


                //Получаем внутренний путь из внешнего

                $internalRoute = preg_replace("~$uriPattern~",$path, $uri);

                //если совпадение найдено, определим контроллер и метод и параметры для обработки запроса
                $segments = explode('/', $internalRoute);


                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);


                $actionName = 'action'.ucfirst(array_shift($segments));


                $parameters = $segments;


                //Подключаем класса контроллер
                $controllerFile = PATH . "/controllers/$controllerName.php";

                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }

                //Создаём объект класса и вызываем метод
                $controllerObject = new $controllerName;
                $result = call_user_func_array(array($controllerObject, $actionName),$parameters);

                if($result != null) {
                    break;
                }
            }
        }
    }


    }