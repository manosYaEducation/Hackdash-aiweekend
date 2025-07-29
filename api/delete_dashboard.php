<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar solicitudes preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    require 'db.php';

    // Verificar si se proporcionó el slug
    if (!isset($_POST['slug']) || empty($_POST['slug'])) {
        throw new Exception('El slug del dashboard es requerido');
    }

    $slug = $_POST['slug'];

    // Verificar si el dashboard existe
    $stmt = $pdo->prepare("SELECT id, title FROM dashboards WHERE slug = ?");
    $stmt->execute([$slug]);
    $dashboard = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dashboard) {
        echo json_encode([
            'success' => false,
            'message' => 'Dashboard no encontrado'
        ]);
        exit;
    }

    // Iniciar transacción
    $pdo->beginTransaction();

    try {
        // Eliminar proyectos asociados primero (debido a la foreign key)
        $stmt = $pdo->prepare("DELETE FROM projects WHERE dashboard_id = ?");
        $stmt->execute([$dashboard['id']]);

        // Eliminar el dashboard
        $stmt = $pdo->prepare("DELETE FROM dashboards WHERE id = ?");
        $stmt->execute([$dashboard['id']]);

        // Confirmar transacción
        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => "Dashboard '{$dashboard['title']}' eliminado correctamente"
        ]);

    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $pdo->rollBack();
        throw $e;
    }

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
?>
