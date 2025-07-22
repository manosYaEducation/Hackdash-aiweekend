<?php
require 'db.php';

$stmt = $pdo->query("
  SELECT d.id, d.slug, d.title, d.description, COUNT(p.id) AS total_projects
  FROM dashboards d
  LEFT JOIN projects p ON p.dashboard_id = d.id
  GROUP BY d.id
  ORDER BY d.id DESC
");

$dashboards = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($dashboards);
