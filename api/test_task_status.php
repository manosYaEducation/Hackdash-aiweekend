<?php
require_once 'db.php';

try {
    $pdo = getConnection();
    
    // Obtener todos los estados únicos de las tareas
    $stmt = $pdo->query("SELECT DISTINCT status FROM tasks ORDER BY status");
    $statuses = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Estados únicos encontrados en la tabla tasks:\n";
    foreach ($statuses as $status) {
        echo "- '$status'\n";
    }
    
    // Obtener algunas tareas de ejemplo con sus estados
    $stmt = $pdo->query("SELECT id, title, status FROM tasks LIMIT 10");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\nEjemplos de tareas:\n";
    foreach ($tasks as $task) {
        echo "ID: {$task['id']}, Título: {$task['title']}, Estado: '{$task['status']}'\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 