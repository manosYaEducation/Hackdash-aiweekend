<?php
require 'db.php';

$id = $_POST['id'] ?? null;

if (!$id) {
  echo json_encode(['message' => 'ID no proporcionado']);
  exit;
}

$stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
$stmt->execute([$id]);

echo json_encode(['message' => 'Proyecto eliminado correctamente']);
