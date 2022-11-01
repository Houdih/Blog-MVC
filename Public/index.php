<?php

use App\Autoloader;
use App\Core\Router;

require_once '../Vendor/Autoloader.php';
Autoloader::register();

$router = new Router($_SERVER['REQUEST_URI']);
$router->run();