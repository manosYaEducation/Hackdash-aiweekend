<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar solicitudes preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require 'db.php';

$slug = $_GET['slug'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM dashboards WHERE slug = ?");
$stmt->execute([$slug]);
$dashboard = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dashboard) {
  http_response_code(404);
  echo json_encode(['message' => 'Dashboard no encontrado']);
  exit;
}

$stmt = $pdo->prepare("SELECT id, title, description FROM projects WHERE dashboard_id = ?");
$stmt->execute([$dashboard['id']]);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

$dashboard['projects'] = $projects;

header('Content-Type: application/json');
echo json_encode($dashboard);
