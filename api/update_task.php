<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once 'db.php';

try {
    $pdo = getConnection();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $taskId = $_POST['task_id'] ?? null;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $priority = $_POST['priority'] ?? 'medium';
        $assignedTo = $_POST['assigned_to'] ?? null;
        $dueDate = $_POST['due_date'] ?? null;
        $status = $_POST['status'] ?? 'pending';
        
        // Validar campos requeridos
        if (!$taskId || !$title || !$description || !$dueDate) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
            exit;
        }
        
        // Validar prioridad
        if (!in_array($priority, ['low', 'medium', 'high'])) {
            $priority = 'medium';
        }
        
        // Validar estado
        if (!in_array($status, ['pending', 'in_progress', 'completed'])) {
            $status = 'pending';
        }
        
        // Actualizar la tarea
        $stmt = $pdo->prepare("
            UPDATE tasks 
            SET title = ?, description = ?, priority = ?, assigned_to = ?, due_date = ?, status = ?, updated_at = NOW()
            WHERE id = ?
        ");
        
        $result = $stmt->execute([
            $title,
            $description,
            $priority,
            $assignedTo,
            $dueDate,
            $status,
            $taskId
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Tarea actualizada correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la tarea']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?> 