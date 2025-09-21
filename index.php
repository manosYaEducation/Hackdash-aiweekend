<?php
// index.php

// Detecta el esquema (http o https)
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";

// Detecta el host (ej: localhost, 127.0.0.1, midominio.com)
$host = $_SERVER['HTTP_HOST'];

// Define la ruta base relativa al host , cambiar a .INI o .ENV
$frontPath = '/github/Hackdash-aiweekend/frontend/';

// Construye la URL absoluta
$url = $scheme . '://' . $host . $frontPath;

// Redirección con cabeceras seguras
header("Location: $url", true, 302);
exit;