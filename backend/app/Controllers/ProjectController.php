<?php

namespace App\Backend\Controllers;

use App\Backend\Models\ProjectModel;
use App\Backend\Models\DashboardModel;
use App\Backend\Models\TaskModel;
use App\Backend\Models\MemberModel;

class ProjectController
{
    private $projectModel;
    private $dashboardModel;
    private $taskModel;
    private $memberModel;

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
        $this->dashboardModel = new DashboardModel();
        $this->taskModel = new TaskModel();
        $this->memberModel = new MemberModel();
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? 'in_progress';
        $dashboardSlug = $_POST['slug'] ?? '';

        if (empty($title) || empty($description) || empty($dashboardSlug)) {
            $this->sendJsonResponse(['success' => false, 'message' => 'Faltan datos requeridos'], 400);
        }

        $validStatuses = ['in_progress', 'completed'];
        if (!in_array($status, $validStatuses)) {
            $status = 'in_progress';
        }

        $projectId = $this->projectModel->createProject($dashboardSlug, $title, $description, $status);

        if ($projectId) {
            $this->sendJsonResponse(['success' => true, 'message' => 'Proyecto creado exitosamente', 'project_id' => $projectId], 201);
        } else {
            $this->sendJsonResponse(['success' => false, 'message' => 'Error al crear el proyecto o dashboard no encontrado.'], 500);
        }
    }

    public function getProjects()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $dashboardSlug = $_GET['slug'] ?? null;
        if (!$dashboardSlug) {
            $this->sendJsonResponse(['success' => false, 'message' => 'Slug de dashboard requerido.'], 400);
        }

        $projects = $this->projectModel->getProjectsByDashboardSlug($dashboardSlug);

        $this->sendJsonResponse(['success' => true, 'data' => $projects], 200);
    }

    public function getTasks()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $projectId = $_GET['id'] ?? null;
        if (!$projectId) {
            $this->sendJsonResponse(['success' => false, 'message' => 'ID de proyecto requerido.'], 400);
        }

        $tasks = $this->taskModel->getTasksByProjectId((int)$projectId);

        $this->sendJsonResponse(['success' => true, 'tasks' => $tasks], 200);
    }

    public function getProject()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $projectId = $_GET['id'] ?? null;
        if (!$projectId) {
            $this->sendJsonResponse(['success' => false, 'message' => 'ID de proyecto requerido.'], 400);
        }

        $project = $this->projectModel->getProjectById((int)$projectId);

        if ($project) {
            $this->sendJsonResponse(['success' => true, 'project' => $project], 200);
        } else {
            $this->sendJsonResponse(['success' => false, 'message' => 'Proyecto no encontrado.'], 404);
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $projectId = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? 'in_progress';

        if (empty($projectId) || empty($title) || empty($description)) {
            $this->sendJsonResponse(['success' => false, 'message' => 'ID, título y descripción del proyecto son requeridos'], 400);
        }

        $validStatuses = ['in_progress', 'completed'];
        if (!in_array($status, $validStatuses)) {
            $status = 'in_progress';
        }

        if ($this->projectModel->updateProject((int)$projectId, $title, $description, $status)) {
            $this->sendJsonResponse(['success' => true, 'message' => 'Proyecto actualizado exitosamente'], 200);
        } else {
            $this->sendJsonResponse(['success' => false, 'message' => 'Error al actualizar el proyecto o no se encontró.'], 500);
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $projectId = $_POST['id'] ?? null;

        if (empty($projectId)) {
            $this->sendJsonResponse(['success' => false, 'message' => 'ID de proyecto requerido para eliminar.'], 400);
        }

        if ($this->projectModel->deleteProject((int)$projectId)) {
            $this->sendJsonResponse(['success' => true, 'message' => 'Proyecto eliminado exitosamente'], 200);
        } else {
            $this->sendJsonResponse(['success' => false, 'message' => 'Error al eliminar el proyecto o no se encontró.'], 500);
        }
    }

    public function getStats()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $projectId = $_GET['id'] ?? null;
        if (!$projectId) {
            $this->sendJsonResponse(['success' => false, 'message' => 'ID de proyecto requerido.'], 400);
        }

        $stats = $this->projectModel->getProjectStats((int)$projectId);

        $this->sendJsonResponse(['success' => true, 'stats' => $stats], 200);
    }

    public function getFiles()
    {
        // This will require a FileModel later
        $this->sendJsonResponse(['success' => true, 'files' => []], 200);
    }

    public function getMembers()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $projectId = $_GET['id'] ?? null;
        if (!$projectId) {
            $this->sendJsonResponse(['success' => false, 'message' => 'ID de proyecto requerido.'], 400);
        }

        $members = $this->memberModel->getMembersByProjectIdAiWeekend((int)$projectId);

        $this->sendJsonResponse(['success' => true, 'members' => $members], 200);
    }

    public function getActivity()
    {
        // This will require an ActivityModel later
        $this->sendJsonResponse(['success' => true, 'activity' => []], 200);
    }

    private function sendJsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
