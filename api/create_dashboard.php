<?php
require 'db.php';

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';

if (!$title || !$description) {
  echo json_encode(['message' => 'Faltan datos']);
  exit;
}

$slug = strtolower(str_replace(' ', '-', $title));

$stmt = $pdo->prepare("INSERT INTO dashboards (slug, title, description) VALUES (?, ?, ?)");
$stmt->execute([$slug, $title, $description]);

echo json_encode(['message' => 'Dashboard creado correctamente']);
