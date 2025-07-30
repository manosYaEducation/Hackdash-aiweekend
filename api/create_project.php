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

require 'db.php';

try {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'in_progress';
    $slug = $_POST['slug'] ?? '';

    if (!$title || !$description || !$slug) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
        exit;
    }

    // Validar que el estado sea válido
    $validStatuses = ['in_progress', 'completed'];
    if (!in_array($status, $validStatuses)) {
        $status = 'in_progress'; // Estado por defecto si no es válido
    }

    $stmt = $pdo->prepare("SELECT id FROM dashboards WHERE slug = ?");
    $stmt->execute([$slug]);
    $dashboard = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dashboard) {
        echo json_encode(['success' => false, 'message' => 'Dashboard no existe']);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO projects (dashboard_id, title, description, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$dashboard['id'], $title, $description, $status]);

    echo json_encode(['success' => true, 'message' => 'Proyecto creado exitosamente']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
}
?>
