<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

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

require 'db.php';

try {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $color = $_POST['color'] ?? 'blue';
    $created_by = $_POST['created_by'] ?? '';

    if (empty($title) || empty($description)) {
        echo json_encode(['success' => false, 'message' => 'Título y descripción son requeridos']);
        exit;
    }

    // Validar que el color sea válido
    $validColors = ['blue', 'green', 'purple', 'red', 'orange', 'yellow', 'pink', 'indigo'];
    if (!in_array($color, $validColors)) {
        $color = 'blue'; // Color por defecto si no es válido
    }

    // Crear slug a partir del título
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    // Verificar si el slug ya existe
    $stmt = $pdo->prepare("SELECT id FROM dashboards WHERE slug = ?");
    $stmt->execute([$slug]);
    
    if ($stmt->rowCount() > 0) {
        // Si existe, agregar un número
        $counter = 1;
        $originalSlug = $slug;
        while ($stmt->rowCount() > 0) {
            $slug = $originalSlug . '-' . $counter;
            $stmt->execute([$slug]);
            $counter++;
        }
    }

    // Insertar el nuevo dashboard
    $stmt = $pdo->prepare("INSERT INTO dashboards (slug, title, description, color, created_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$slug, $title, $description, $color, $created_by]);

    echo json_encode([
        'success' => true,
        'message' => 'Dashboard creado exitosamente',
        'slug' => $slug
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
}
?>
