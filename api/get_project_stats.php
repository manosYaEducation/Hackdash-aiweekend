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

    // Obtener estadísticas de tareas
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(*) as total_tasks,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_tasks
        FROM tasks 
        WHERE project_id = ?
    ");
    $stmt->execute([$projectId]);
    $taskStats = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener estadísticas de miembros
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as total_members
        FROM project_members 
        WHERE project_id = ?
    ");
    $stmt->execute([$projectId]);
    $memberStats = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener estadísticas de archivos
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as total_files
        FROM files 
        WHERE project_id = ?
    ");
    $stmt->execute([$projectId]);
    $fileStats = $stmt->fetch(PDO::FETCH_ASSOC);

    // Calcular progreso
    $totalTasks = (int)$taskStats['total_tasks'];
    $completedTasks = (int)$taskStats['completed_tasks'];
    $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

    echo json_encode([
        'success' => true,
        'stats' => [
            'progress' => $progress,
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'total_members' => (int)$memberStats['total_members'],
            'total_files' => (int)$fileStats['total_files']
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 