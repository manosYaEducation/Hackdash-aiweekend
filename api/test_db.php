<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Probar conexión básica
    $host = 'localhost';
    $db = 'hackdash';
    $user = 'root';
    $pass = '';

    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== PRUEBA DE CONEXIÓN ===\n";
    echo "✅ Conexión exitosa a la base de datos\n\n";
    
    // Verificar tablas
    echo "=== VERIFICANDO TABLAS ===\n";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tablas encontradas: " . implode(', ', $tables) . "\n\n";
    
    // Verificar tabla dashboards
    if (in_array('dashboards', $tables)) {
        echo "=== TABLA DASHBOARDS ===\n";
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM dashboards");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        echo "Total de dashboards: $count\n";
        
        if ($count > 0) {
            $stmt = $pdo->query("SELECT * FROM dashboards LIMIT 3");
            $dashboards = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "Primeros 3 dashboards:\n";
            foreach ($dashboards as $dashboard) {
                echo "- ID: {$dashboard['id']}, Título: {$dashboard['title']}, Slug: {$dashboard['slug']}\n";
            }
        }
        echo "\n";
    } else {
        echo "❌ La tabla 'dashboards' NO existe\n\n";
    }
    
    // Verificar tabla projects
    if (in_array('projects', $tables)) {
        echo "=== TABLA PROJECTS ===\n";
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM projects");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        echo "Total de proyectos: $count\n\n";
    } else {
        echo "❌ La tabla 'projects' NO existe\n\n";
    }
    
    // Probar consulta completa
    echo "=== PRUEBA DE CONSULTA COMPLETA ===\n";
    $stmt = $pdo->query("
        SELECT 
            d.id,
            d.slug,
            d.title,
            d.description,
            d.created_at,
            COUNT(p.id) AS total_projects
        FROM dashboards d
        LEFT JOIN projects p ON p.dashboard_id = d.id
        GROUP BY d.id
        ORDER BY d.created_at DESC
    ");
    
    $dashboards = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Dashboards encontrados: " . count($dashboards) . "\n";
    
    foreach ($dashboards as $dashboard) {
        echo "- {$dashboard['title']} ({$dashboard['total_projects']} proyectos)\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Error en la base de datos: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error del servidor: " . $e->getMessage() . "\n";
}
?> 