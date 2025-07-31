<?php
// Archivo de prueba para diagnosticar problemas de API
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar solicitudes preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Información de diagnóstico
$diagnostic = [
    'success' => true,
    'message' => 'API funcionando correctamente',
    'timestamp' => date('Y-m-d H:i:s'),
    'php_version' => PHP_VERSION,
    'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
    'request_method' => $_SERVER['REQUEST_METHOD'],
    'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'Not set',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Not set'
];

// Verificar si db.php existe
$db_file_exists = file_exists('db.php');
$diagnostic['db_file_exists'] = $db_file_exists;

if ($db_file_exists) {
    try {
        require 'db.php';
        $diagnostic['db_connection'] = 'success';
        $diagnostic['pdo_available'] = isset($pdo);
        
        if (isset($pdo)) {
            // Verificar si las tablas existen
            $tables = ['dashboards', 'projects'];
            foreach ($tables as $table) {
                $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
                $diagnostic["table_$table"] = $stmt->rowCount() > 0;
            }
        }
    } catch (Exception $e) {
        $diagnostic['db_connection'] = 'error';
        $diagnostic['db_error'] = $e->getMessage();
    }
} else {
    $diagnostic['db_connection'] = 'file_not_found';
}

echo json_encode($diagnostic, JSON_PRETTY_PRINT);
?> 