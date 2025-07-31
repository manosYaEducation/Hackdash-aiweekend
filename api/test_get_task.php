<?php
// Simular una petición GET a get_task.php
$_GET['id'] = '1';
$_SERVER['REQUEST_METHOD'] = 'GET';

// Capturar la salida
ob_start();
include 'get_task.php';
$output = ob_get_clean();

echo "🔍 Probando get_task.php con ID=1:\n";
echo "📤 Respuesta:\n";
echo $output . "\n";

// Decodificar JSON para verificar la estructura
$response = json_decode($output, true);
if ($response) {
    echo "✅ JSON válido\n";
    if ($response['success']) {
        echo "✅ Tarea encontrada\n";
        echo "📝 Título: " . $response['task']['title'] . "\n";
        echo "📋 Descripción: " . $response['task']['description'] . "\n";
        echo "🎯 Prioridad: " . $response['task']['priority'] . "\n";
        echo "👤 Asignado a: " . ($response['task']['assigned_to'] ?? 'Sin asignar') . "\n";
        echo "📅 Fecha de vencimiento: " . $response['task']['due_date'] . "\n";
        echo "📊 Estado: " . $response['task']['status'] . "\n";
    } else {
        echo "❌ Error: " . $response['message'] . "\n";
    }
} else {
    echo "❌ JSON inválido\n";
    echo "🔍 Salida completa:\n";
    echo $output . "\n";
}
?> 