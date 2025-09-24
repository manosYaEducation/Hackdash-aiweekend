<?php
// index.php

// Leer configuración desde config.ini
$config = parse_ini_file(__DIR__ . "/config.ini", true);

// Detecta el esquema (http o https)
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";

// Detecta el host (ej: localhost, 127.0.0.1, midominio.com)
$host = $_SERVER['HTTP_HOST'];

// Obtener la ruta base desde config.ini
$frontPath = $config['paths']['frontend'] . '/';

// Construye la URL absoluta usando configuración
$url = $scheme . '://' . $host . $frontPath;

// Redirección con cabeceras seguras
header("Location: $url", true, 302);
exit;