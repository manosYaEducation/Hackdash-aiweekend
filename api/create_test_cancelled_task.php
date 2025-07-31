<?php
require_once 'db.php';

try {
    $pdo = getConnection();
    
    // Crear una tarea de prueba con estado cancelled
    $stmt = $pdo->prepare("INSERT INTO tasks (project_id, title, description, priority, assigned_to, due_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    $projectId = 18; // Usando el proyecto ID 18 que existe
    $title = "Tarea Cancelada de Prueba";
    $description = "Esta es una tarea de prueba para verificar el icono rojo del estado cancelled";
    $priority = "medium";
    $assignedTo = "Usuario Test";
    $dueDate = "2024-12-31";
    $status = "cancelled";
    
    $stmt->execute([$projectId, $title, $description, $priority, $assignedTo, $dueDate, $status]);
    
    echo "Tarea cancelada creada exitosamente con ID: " . $pdo->lastInsertId() . "\n";
    echo "Ahora puedes ver el icono rojo en la interfaz.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 