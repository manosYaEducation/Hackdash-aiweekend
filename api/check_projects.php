<?php
require_once 'db.php';

try {
    $pdo = getConnection();
    
    // Verificar la estructura de la tabla projects
    $stmt = $pdo->query("DESCRIBE projects");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Estructura de la tabla projects:\n";
    foreach ($columns as $column) {
        echo "Campo: {$column['Field']}, Tipo: {$column['Type']}\n";
    }
    
    echo "\n";
    
    // Obtener todos los proyectos
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY id");
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Proyectos disponibles:\n";
    foreach ($projects as $project) {
        echo "ID: {$project['id']}, Datos: " . json_encode($project) . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 