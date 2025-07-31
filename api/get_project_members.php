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
        SELECT * FROM project_members 
        WHERE project_id = ? 
        ORDER BY joined_at ASC
    ");
    $stmt->execute([$projectId]);
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'members' => $members
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 