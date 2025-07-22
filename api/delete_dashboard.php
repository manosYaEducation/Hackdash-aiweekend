<?php
require 'db.php';

$slug = $_POST['slug'] ?? '';

if (!$slug) {
  echo json_encode(['message' => 'Slug no proporcionado']);
  exit;
}

$stmt = $pdo->prepare("DELETE FROM dashboards WHERE slug = ?");
$stmt->execute([$slug]);

echo json_encode(['message' => 'Dashboard eliminado correctamente']);
