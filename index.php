<?php

require_once __DIR__ . '/frontend/autoload.php';

use App\Frontend\Router;

// Define the base path for the frontend
$basePath = '/Hackdash-aiweekend';
// $basePath = '';

// Cargar las definiciones de rutas
$routes = require_once __DIR__ . '/frontend/routes.php';

$router = new Router($routes, $basePath);
$router->dispatch();
