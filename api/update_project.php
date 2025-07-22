<?php
require 'db.php';

$id = $_POST['id'] ?? '';
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';

if (!$id || !$title || !$description) {
  echo json_encode(['message' => 'Faltan datos']);
  exit;
}

$stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ? WHERE id = ?");
$stmt->execute([$title, $description, $id]);

echo json_encode(['message' => 'Proyecto actualizado correctamente']);
