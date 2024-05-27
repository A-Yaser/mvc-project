<?php

namespace app\core;

class Request
{

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    public function getUrl()
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }
}
