<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar solicitudes preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    // Verificar si el archivo db.php existe
    if (!file_exists('db.php')) {
        throw new Exception('El archivo db.php no existe');
    }

    require 'db.php';

    // Verificar si la conexión se estableció correctamente
    if (!isset($pdo)) {
        throw new Exception('La conexión a la base de datos no se estableció');
    }

    // Verificar si la tabla dashboards existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'dashboards'");
    if ($stmt->rowCount() == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'La tabla dashboards no existe. Ejecuta el archivo database_schema.sql primero.'
        ]);
        exit;
    }

    // Verificar si la tabla projects existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'projects'");
    if ($stmt->rowCount() == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'La tabla projects no existe. Ejecuta el archivo database_schema.sql primero.'
        ]);
        exit;
    }

    // Ejecutar la consulta principal
    $stmt = $pdo->query("
        SELECT 
            d.id,
            d.slug,
            d.title,
            d.description,
            d.color,
            d.created_at,
            d.created_by,
            COUNT(p.id) AS total_projects
        FROM dashboards d
        LEFT JOIN projects p ON p.dashboard_id = d.id
        GROUP BY d.id
        ORDER BY d.created_at DESC
    ");
    
    $dashboards = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $dashboards,
        'count' => count($dashboards)
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Error en la base de datos: ' . $e->getMessage(),
        'error_type' => 'PDOException'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Error del servidor: ' . $e->getMessage(),
        'error_type' => 'Exception'
    ]);
}
