<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Mugiew\Galeano\App\Router;
use Mugiew\Galeano\Config\Database;
use Mugiew\Galeano\Controller\HomeController;
use Mugiew\Galeano\Controller\UserController;
use Mugiew\Galeano\Middleware\AuthMiddleware;
use Mugiew\Galeano\Middleware\GuestMiddleware;

Database::connect('production');

Router::add('GET', '/', HomeController::class, 'index');
Router::add('GET', '/register', UserController::class, 'register', [GuestMiddleware::class]);
Router::add('POST', '/login', UserController::class, 'postLogin', [GuestMiddleware::class]);
Router::add('POST', '/register', UserController::class, 'postRegister', [GuestMiddleware::class]);
Router::add('GET', '/logout', UserController::class, 'logout', [AuthMiddleware::class]);

Router::run();
