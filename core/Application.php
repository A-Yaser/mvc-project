<?php

namespace app\core;

use app\controllers\AuthController;


class Application
{

    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public ?Controller $controller = null;
    public static Application $app;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    //هذه الدالة الرئيسية التي يتم استدعاؤها في الصفحة الرئيسية
    public function run()
    {
        echo $this->router->dispatch();
    }
}
