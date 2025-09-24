<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use App\Backend\Router;

// Leer config.ini
$config = parse_ini_file(__DIR__ . "/../../config.ini", true);

// Tomar la ruta del backend
$basePath = $config['paths']['backend'];

// Cargar rutas del backend
$routes = require_once __DIR__ . "/../Routes/api.php";

// Inicializar router con basePath del .ini
$router = new Router($routes, $basePath);
$router->dispatch();
