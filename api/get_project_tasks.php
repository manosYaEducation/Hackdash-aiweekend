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
        SELECT * FROM tasks 
        WHERE project_id = ? 
        ORDER BY created_at DESC
    ");
    $stmt->execute([$projectId]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'tasks' => $tasks
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 