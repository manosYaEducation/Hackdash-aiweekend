<?php 

require_once __DIR__ . '/autoload.php'; 

use App\Frontend\Router; 

$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$basePath = $scriptDir === '/' ? '' : $scriptDir;

// Cargar las definiciones de rutas 
$routes = require_once __DIR__ . '/routes.php'; 

$router = new Router($routes, $basePath); 
$router->dispatch();
