<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once 'db.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Método no permitido');
    }

    $projectId = $_GET['id'] ?? null;
    
    if (!$projectId) {
        throw new Exception('ID de proyecto requerido');
    }

    $stmt = $pdo->prepare("
        SELECT p.*, d.title as dashboard_title, d.slug as dashboard_slug 
        FROM projects p 
        JOIN dashboards d ON p.dashboard_id = d.id 
        WHERE p.id = ?
    ");
    $stmt->execute([$projectId]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$project) {
        throw new Exception('Proyecto no encontrado');
    }

    echo json_encode([
        'success' => true,
        'project' => $project
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 