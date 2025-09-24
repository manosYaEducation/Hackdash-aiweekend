<?php

function getBaseUrl() {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    
    // Leer configuración dinámicamente
    $config = parse_ini_file(__DIR__ . "/../../config.ini", true);
    $basePath = $config['paths']['frontend'];
    $projectPath = dirname($basePath); // Remover /frontend del path
    
    return $scheme . '://' . $host . $projectPath;
}

function getFrontendUrl() {
    return getBaseUrl() . '/frontend';
}

function getBackendUrl() {
    return getBaseUrl() . '/backend';
}

function getAssetUrl($path) {
    return getBaseUrl() . '/assets/' . ltrim($path, '/');
}

function getPublicUrl($path) {
    return getFrontendUrl() . '/public/' . ltrim($path, '/');
}
?>
