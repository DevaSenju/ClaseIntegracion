<?php

declare(strict_types=1);

if (!defined('APP_ASSET_PREFIX')) {
    define('APP_ASSET_PREFIX', '');
}

session_start();

require dirname(__DIR__) . '/app/Core/Autoloader.php';
require dirname(__DIR__) . '/app/Core/helpers.php';

use App\Controllers\HomeController;
use App\Controllers\MovementController;
use App\Controllers\ProductController;
use App\Core\Autoloader;
use App\Core\Router;

Autoloader::register();
$config = require dirname(__DIR__) . '/config/config.php';

$router = new Router();
$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/products', [ProductController::class, 'index']);
$router->add('GET', '/products/create', [ProductController::class, 'create']);
$router->add('POST', '/products/store', [ProductController::class, 'store']);
$router->add('GET', '/products/edit', [ProductController::class, 'edit']);
$router->add('POST', '/products/update', [ProductController::class, 'update']);
$router->add('GET', '/movements', [MovementController::class, 'index']);
$router->add('GET', '/movements/create', [MovementController::class, 'create']);
$router->add('POST', '/movements/store', [MovementController::class, 'store']);

$route = (string) ($_GET['route'] ?? '/');
$router->dispatch($route, (string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'), $config);
