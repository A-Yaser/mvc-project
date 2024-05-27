<?php

namespace app\core;

use app\controllers\AuthController;
use app\core\Request;

class Router
{

    private Request $request;
    private array $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private function addRoute($route, $controller, $action, $method)
    {

        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
    }


    public function get($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "GET");
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "POST");
    }
    public function getroutes($method): array
    {
        return $this->routes[$method] ?? [];
    }

    public function dispatch()
    {
        $url = $this->request->getUrl();
        $method = $this->request->getMethod();
        // $url = strtok($_SERVER['REQUEST_URI'], '?');
        // $method =  $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($url, $this->routes[$method])) {
            $controller = $this->routes[$method][$url]['controller'];
            $action = $this->routes[$method][$url]['action'];
            $controller = new $controller();
            $controller->$action();
        } else {
            http_response_code(404);
            return "ERROR 404";
        }
    }



    private function renderView($view)
    {
        ob_start();
        include "../app/views/$view.php";
        return ob_get_clean();
    }
}
