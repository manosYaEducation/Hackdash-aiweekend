<?php

return [
    //Vistas de admin
    'login' => __DIR__ . '/views/login.php',
    'dashboard' => __DIR__ . '/views/dashboard.php',
    'project' => __DIR__ . '/views/project.php',
    'blank' => __DIR__ . '/views/blank.php',
    'index' => __DIR__ . '/views/index.php',
    '' => __DIR__ . '/views/index.php', // Default route

    //Vistas de usuario y visitante
    'login' => __DIR__ . '/views/user/login.php',
    'register' => __DIR__ . '/views/user/register.php',
    'recover-password' => __DIR__ . '/views/user/recover-password.php',
    'home' => __DIR__ . '/views/user/home.php',
    'profile' => __DIR__ . '/views/user/profile.php',
    'project-list' => __DIR__ . '/views/user/project-list.php',
    'project-detail' => __DIR__ . '/views/user/project-detail.php',
    'project-create' => __DIR__ . '/views/user/project-create.php',
];
