<?php
require_once 'db.php';

try {
    $pdo = getConnection();
    
    // Verificar si la tabla tasks existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'tasks'");
    $tableExists = $stmt->rowCount() > 0;
    
    if ($tableExists) {
        echo "✅ La tabla 'tasks' existe\n";
        
        // Mostrar estructura de la tabla
        $stmt = $pdo->query("DESCRIBE tasks");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "\n📋 Estructura de la tabla 'tasks':\n";
        foreach ($columns as $column) {
            echo "- {$column['Field']}: {$column['Type']} ({$column['Null']})\n";
        }
        
        // Contar registros
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM tasks");
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "\n📊 Total de tareas: {$count['total']}\n";
        
        // Mostrar algunas tareas de ejemplo
        $stmt = $pdo->query("SELECT * FROM tasks LIMIT 3");
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($tasks)) {
            echo "\n📝 Ejemplos de tareas:\n";
            foreach ($tasks as $task) {
                echo "- ID: {$task['id']}, Título: {$task['title']}\n";
            }
        }
        
    } else {
        echo "❌ La tabla 'tasks' NO existe\n";
        echo "\n🔧 Creando tabla 'tasks'...\n";
        
        $sql = "
        CREATE TABLE tasks (
            id INT AUTO_INCREMENT PRIMARY KEY,
            project_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
            assigned_to VARCHAR(255),
            due_date DATE,
            status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_project_id (project_id),
            INDEX idx_status (status),
            INDEX idx_priority (priority)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ";
        
        $pdo->exec($sql);
        echo "✅ Tabla 'tasks' creada exitosamente\n";
        
        // Insertar algunas tareas de ejemplo
        $sampleTasks = [
            [
                'project_id' => 1,
                'title' => 'Diseñar wireframes',
                'description' => 'Crear wireframes para todas las páginas principales',
                'priority' => 'high',
                'assigned_to' => 'Carlos López',
                'due_date' => '2024-01-19',
                'status' => 'pending'
            ],
            [
                'project_id' => 1,
                'title' => 'Desarrollar frontend',
                'description' => 'Implementar la interfaz de usuario con React',
                'priority' => 'medium',
                'assigned_to' => 'Ana García',
                'due_date' => '2024-01-25',
                'status' => 'in_progress'
            ],
            [
                'project_id' => 1,
                'title' => 'Configurar base de datos',
                'description' => 'Crear y configurar la estructura de la base de datos',
                'priority' => 'low',
                'assigned_to' => 'Miguel Torres',
                'due_date' => '2024-01-15',
                'status' => 'completed'
            ]
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO tasks (project_id, title, description, priority, assigned_to, due_date, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($sampleTasks as $task) {
            $stmt->execute([
                $task['project_id'],
                $task['title'],
                $task['description'],
                $task['priority'],
                $task['assigned_to'],
                $task['due_date'],
                $task['status']
            ]);
        }
        
        echo "✅ Tareas de ejemplo insertadas\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?> 