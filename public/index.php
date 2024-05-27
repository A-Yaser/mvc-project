<?php
session_start();
require_once '../vendor/autoload.php';

use app\controllers\UserController;
use app\controllers\DashboardController;
use app\core\Router;
use app\core\Request;
use app\core\Application;

$app = new Application(dirname(__DIR__));
$request = new Request();
$router = new Router($request);


$app->router->get('/login', UserController::class, 'showLogin');
$app->router->get('/', DashboardController::class, 'showDashboard');
$app->router->post('/login', UserController::class, 'login');
$app->router->get('/register', UserController::class, 'showRegister');
$app->router->post('/register', UserController::class, 'register');
$app->router->get('/logout', UserController::class, 'logout');
$app->router->get('/dashboard', DashboardController::class, 'showDashboard');


$app->run();
