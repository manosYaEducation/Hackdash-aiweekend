<?php
// Configurar headers antes de cualquier salida
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Deshabilitar la salida de errores de PHP
error_reporting(0);
ini_set('display_errors', 0);

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

    // Obtener el slug del dashboard
    $slug = $_GET['slug'] ?? null;
    
    if (!$slug) {
        echo json_encode([
            'success' => false,
            'message' => 'Slug del dashboard no proporcionado'
        ]);
        exit;
    }

    // Consultar el dashboard específico
    $stmt = $pdo->prepare("
        SELECT 
            id,
            slug,
            title,
            description,
            color,
            created_at,
            created_by
        FROM dashboards 
        WHERE slug = ?
    ");
    
    $stmt->execute([$slug]);
    $dashboard = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$dashboard) {
        echo json_encode([
            'success' => false,
            'message' => 'Dashboard no encontrado'
        ]);
        exit;
    }

    // Verificar si se solicita solo para edición (sin proyectos)
    $editMode = isset($_GET['edit']) && $_GET['edit'] === 'true';
    
    if (!$editMode) {
        // Obtener los proyectos relacionados
        $stmt = $pdo->prepare("
            SELECT 
                id, 
                title, 
                description, 
                status, 
                created_at 
            FROM projects 
            WHERE dashboard_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$dashboard['id']]);
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $dashboard['projects'] = $projects;
    }
    
    echo json_encode([
        'success' => true,
        'dashboard' => $dashboard
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
} catch (Error $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Error fatal: ' . $e->getMessage(),
        'error_type' => 'Error'
    ]);
}
?>
