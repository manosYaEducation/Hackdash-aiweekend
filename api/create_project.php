<?php
require 'db.php';

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$slug = $_POST['slug'] ?? '';

if (!$title || !$description || !$slug) {
  echo json_encode(['message' => 'Faltan datos']);
  exit;
}

$stmt = $pdo->prepare("SELECT id FROM dashboards WHERE slug = ?");
$stmt->execute([$slug]);
$dashboard = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dashboard) {
  echo json_encode(['message' => 'Dashboard no existe']);
  exit;
}

$stmt = $pdo->prepare("INSERT INTO projects (dashboard_id, title, description) VALUES (?, ?, ?)");
$stmt->execute([$dashboard['id'], $title, $description]);

echo json_encode(['message' => 'Proyecto creado']);
