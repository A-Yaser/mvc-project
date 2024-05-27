<?php

namespace app\core;

use app\core\Application;

class Controller
{
    protected function render($view, $data = [])
    {
        extract($data);

        // ob_start();
        include Application::$ROOT_DIR . "/views/$view.php";
        // return ob_get_clean();
    }
}
