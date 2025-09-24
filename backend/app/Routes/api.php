<?php

use App\Backend\Controllers\AuthController;
use App\Backend\Controllers\DashboardController;
use App\Backend\Controllers\ProjectController;
use App\Backend\Controllers\TaskController;

return [
    'login' => ['controller' => AuthController::class, 'method' => 'login', 'httpMethod' => 'POST'],
    'dashboards' => ['controller' => DashboardController::class, 'method' => 'getDashboards', 'httpMethod' => 'GET'],
    'dashboard/create' => ['controller' => DashboardController::class, 'method' => 'create', 'httpMethod' => 'POST'],
    'dashboard/get' => ['controller' => DashboardController::class, 'method' => 'getDashboard', 'httpMethod' => 'GET'],
    'dashboard/update' => ['controller' => DashboardController::class, 'method' => 'update', 'httpMethod' => 'POST'],
    'dashboard/delete' => ['controller' => DashboardController::class, 'method' => 'delete', 'httpMethod' => 'POST'],
    
    // Rutas para Proyectos
    'project/create' => ['controller' => ProjectController::class, 'method' => 'create', 'httpMethod' => 'POST'],
    'project/getProjects' => ['controller' => ProjectController::class, 'method' => 'getProjects', 'httpMethod' => 'GET'],
    'project/get' => ['controller' => ProjectController::class, 'method' => 'getProject', 'httpMethod' => 'GET'],
    'project/update' => ['controller' => ProjectController::class, 'method' => 'update', 'httpMethod' => 'POST'],
    'project/delete' => ['controller' => ProjectController::class, 'method' => 'delete', 'httpMethod' => 'POST'],
    'project/stats' => ['controller' => ProjectController::class, 'method' => 'getStats', 'httpMethod' => 'GET'],
    'project/files' => ['controller' => ProjectController::class, 'method' => 'getFiles', 'httpMethod' => 'GET'],
    'project/members' => ['controller' => ProjectController::class, 'method' => 'getMembers', 'httpMethod' => 'GET'],
    'project/tasks' => ['controller' => ProjectController::class, 'method' => 'getTasks', 'httpMethod' => 'GET'],
    'project/activity' => ['controller' => ProjectController::class, 'method' => 'getActivity', 'httpMethod' => 'GET'],

    // Rutas para Tareas
    'task/create' => ['controller' => TaskController::class, 'method' => 'create', 'httpMethod' => 'POST'],
    'task/getTasks' => ['controller' => TaskController::class, 'method' => 'getTasks', 'httpMethod' => 'GET'],
    'task/get' => ['controller' => TaskController::class, 'method' => 'getTask', 'httpMethod' => 'GET'],
    'task/update' => ['controller' => TaskController::class, 'method' => 'update', 'httpMethod' => 'POST'],
    'task/delete' => ['controller' => TaskController::class, 'method' => 'delete', 'httpMethod' => 'POST'],
    'task/updateStatus' => ['controller' => TaskController::class, 'method' => 'updateStatus', 'httpMethod' => 'POST'],
    
    // Ruta para configuración
    'config' => ['controller' => 'ConfigController', 'method' => 'getConfig', 'httpMethod' => 'GET'],
];
