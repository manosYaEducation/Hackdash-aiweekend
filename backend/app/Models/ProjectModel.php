<?php

namespace App\Backend\Models;

use PDO;
use App\Backend\Models\Database;
use App\Backend\Models\DashboardModel;
use App\Backend\Models\TaskModel;

class ProjectModel
{
    private $conn;
    private $dashboardModel;
    private $taskModel;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
        $this->dashboardModel = new DashboardModel();
        $this->taskModel = new TaskModel();
    }

    public function createProject(string $dashboardSlug, string $title, string $description, string $status): ?int
    {
        $dashboard = $this->dashboardModel->findBySlug($dashboardSlug);
        if (!$dashboard) {
            return null; // Dashboard no existe
        }

        $stmt = $this->conn->prepare("INSERT INTO projects (dashboard_id, title, description, status) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$dashboard['id'], $title, $description, $status])) {
            return (int) $this->conn->lastInsertId();
        }
        return null;
    }

    public function getProjectById(int $projectId): ?array
    {
        $stmt = $this->conn->prepare("SELECT p.*, d.slug as dashboard_slug FROM projects p JOIN dashboards d ON p.dashboard_id = d.id WHERE p.id = ?");
        $stmt->execute([$projectId]);
        $project = $stmt->fetch(PDO::FETCH_ASSOC);
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProjectsPaginated(int $limit, int $offset): array
    {
        $stmt = $this->conn->prepare("SELECT p.*, d.title as dashboard_name, d.slug as dashboard_slug FROM projects p JOIN dashboards d ON p.dashboard_id = d.id ORDER BY p.created_at DESC LIMIT ? OFFSET ?");
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->bindParam(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalProjectsCount(): int
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM projects");
        return (int) $stmt->fetchColumn();
    }

    public function updateProject(int $projectId, string $title, string $description, string $status): bool
    {
        $stmt = $this->conn->prepare("UPDATE projects SET title = ?, description = ?, status = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $status, $projectId]);
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

        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        return [
            'progress' => $progress,
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'total_members' => 0, // Placeholder, requiere un MemberModel
            'total_files' => 0 // Placeholder, requiere un FileModel
        ];
    }
}
