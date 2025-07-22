<?php
require 'db.php';

$slug = $_POST['slug'] ?? '';
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';

if (!$slug || !$title || !$description) {
  echo json_encode(['message' => 'Faltan datos']);
  exit;
}

$stmt = $pdo->prepare("UPDATE dashboards SET title = ?, description = ? WHERE slug = ?");
$stmt->execute([$title, $description, $slug]);

echo json_encode(['message' => 'Dashboard actualizado correctamente']);
