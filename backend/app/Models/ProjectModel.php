<?php

namespace App\Backend\Models;

use PDO;
use App\Backend\Models\Database;
use App\Backend\Models\DashboardModel;
use App\Backend\Models\TaskModel;
use App\Backend\Models\MemberModel;

class ProjectModel
{
    private $conn;
    private $dashboardModel;
    private $taskModel;
    private $memberModel;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
        $this->dashboardModel = new DashboardModel();
        $this->taskModel = new TaskModel();
        $this->memberModel = new MemberModel();
    }

public function createProject(string $pitch, string $dashboardSlug, string $title, string $description, string $status, ?string $imageData = null): ?int {
    $dashboard = $this->dashboardModel->findBySlug($dashboardSlug);
    if (!$dashboard) {
        return null;
    }

    $stmt = $this->conn->prepare("INSERT INTO projects (dashboard_id, title, description, status, image ,pitch) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$dashboard['id'], $title, $description, $status, $imageData, $pitch])) {
        return (int) $this->conn->lastInsertId();
    }
    return null;
}

public function getProjectById(int $projectId): ?array
{
    $stmt = $this->conn->prepare("SELECT p.*, d.slug as dashboard_slug FROM projects p JOIN dashboards d ON p.dashboard_id = d.id WHERE p.id = ?");
    $stmt->execute([$projectId]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($project && !empty($project['image'])) {
        $project['image'] = base64_encode($project['image']);
    }

    return $project ?: null;
}
    public function getProjectsByDashboardSlug(string $dashboardSlug): array
    {
        $dashboard = $this->dashboardModel->findBySlug($dashboardSlug);
        if (!$dashboard) {

            return [];
        }
        

    $stmt = $this->conn->prepare("SELECT * FROM projects WHERE dashboard_id = ? ORDER BY created_at DESC");
    $stmt->execute([$dashboard['id']]);
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($projects as &$project) {
        if (!empty($project['image'])) {
            $project['image'] = base64_encode($project['image']);
        }
    }

    return $projects;
}

public function updateProject(int $projectId, string $title, string $description, string $status, ?string $imageData = null, $pitch): bool
{
    if ($imageData !== null) {
        $stmt = $this->conn->prepare("UPDATE projects SET title = ?, description = ?, pitch = ?, status = ?, image = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $pitch, $status, $imageData === '' ? null : $imageData, $projectId]);
    } else {
        $stmt = $this->conn->prepare("UPDATE projects SET title = ?, description = ?, pitch = ? , status = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $pitch, $status, $projectId]);
    }
}
    public function deleteProject(int $projectId): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM projects WHERE id = ?");
        return $stmt->execute([$projectId]);
    }

    public function getProjectStats(int $projectId): array
    {
        $tasks = $this->taskModel->getTasksByProjectId($projectId);
        $totalTasks = count($tasks);
        $completedTasks = count(array_filter($tasks, fn($task) => $task['status'] === 'completed'));


        $members = $this->memberModel->getMembersByProjectId($projectId);
        $totalMembers = count($members);
        

        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        return [
            'progress' => $progress,
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'total_members' => $totalMembers, 
            'total_files' => 0 // Placeholder, requiere un FileModel
        ];
    }
}
