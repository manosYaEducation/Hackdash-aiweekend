<?php
// Configurar headers antes de cualquier salida
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Deshabilitar la salida de errores de PHP
error_reporting(0);
ini_set('display_errors', 0);

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
    // Verificar si el archivo db.php existe
    if (!file_exists('db.php')) {
        throw new Exception('El archivo db.php no existe');
    }

    require 'db.php';

    // Verificar si la conexión se estableció correctamente
    if (!isset($pdo)) {
        throw new Exception('La conexión a la base de datos no se estableció');
    }

    // Obtener los datos del formulario
    $projectId = $_POST['project_id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $priority = $_POST['priority'] ?? 'medium';
    $assignedTo = trim($_POST['assigned_to'] ?? '');
    $dueDate = $_POST['due_date'] ?? null;

    // Validar datos requeridos
    if (!$projectId) {
        echo json_encode([
            'success' => false,
            'message' => 'ID del proyecto no proporcionado'
        ]);
        exit;
    }

    if (empty($title)) {
        echo json_encode([
            'success' => false,
            'message' => 'El título es requerido'
        ]);
        exit;
    }

    if (empty($description)) {
        echo json_encode([
            'success' => false,
            'message' => 'La descripción es requerida'
        ]);
        exit;
    }

    if (!$dueDate) {
        echo json_encode([
            'success' => false,
            'message' => 'La fecha de vencimiento es requerida'
        ]);
        exit;
    }

    // Verificar que el proyecto existe
    $stmt = $pdo->prepare("SELECT id FROM projects WHERE id = ?");
    $stmt->execute([$projectId]);
    $existingProject = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingProject) {
        echo json_encode([
            'success' => false,
            'message' => 'Proyecto no encontrado'
        ]);
        exit;
    }

    // Validar prioridad
    $validPriorities = ['low', 'medium', 'high'];
    if (!in_array($priority, $validPriorities)) {
        $priority = 'medium';
    }

    // Insertar la nueva tarea
    $stmt = $pdo->prepare("
        INSERT INTO tasks (project_id, title, description, priority, assigned_to, due_date, status)
        VALUES (?, ?, ?, ?, ?, ?, 'pending')
    ");
    
    $result = $stmt->execute([
        $projectId,
        $title,
        $description,
        $priority,
        $assignedTo ?: null,
        $dueDate
    ]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Tarea creada correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al crear la tarea'
        ]);
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
} catch (Error $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Error fatal: ' . $e->getMessage(),
        'error_type' => 'Error'
    ]);
}
?> 