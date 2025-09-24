<?php
require_once __DIR__ . "/autoload.php";

use App\Frontend\Router;

// Leer config.ini
$config = parse_ini_file(__DIR__ . "/../config.ini", true);

// Tomar la ruta del frontend
$basePath = $config['paths']['frontend'];

// Cargar rutas definidas
$routes = require_once __DIR__ . "/routes.php";

// Inicializar router con basePath del .ini
$router = new Router($routes, $basePath);
$router->dispatch();
