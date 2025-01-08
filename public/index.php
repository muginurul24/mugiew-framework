<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Mugiew\Galeano\App\Router;
use Mugiew\Galeano\Controller\HomeController;

Router::add('GET', '/', HomeController::class, 'index');

Router::run();
