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

    public function addMember()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $projectId = $_POST['project_id'] ?? null;
        $userName = $_POST['user_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? 'member';

        if (empty($projectId) || empty($userName) || empty($email)) {
            $this->sendJsonResponse(['success' => false, 'message' => 'ID del proyecto, nombre de usuario y correo electrónico son requeridos'], 400);
        }

        // Verificar si el proyecto existe
        $project = $this->projectModel->getProjectById((int)$projectId);
        if (!$project) {
            $this->sendJsonResponse(['success' => false, 'message' => 'Proyecto no encontrado'], 404);
        }

        // Verificar si el correo ya está registrado en el proyecto
        $existingMembers = $this->memberModel->getMembersByProjectId((int)$projectId);
        foreach ($existingMembers as $member) {
            if ($member['email'] === $email) {
                $this->sendJsonResponse(['success' => false, 'message' => 'El correo ya está registrado en este proyecto'], 400);
            }
        }

        if ($this->memberModel->addMemberToProject((int)$projectId, $userName, $email, $role)) {
            $this->sendJsonResponse(['success' => true, 'message' => 'Miembro agregado exitosamente'], 201);
        } else {
            $this->sendJsonResponse(['success' => false, 'message' => 'Error al agregar el miembro'], 500);
        }
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

    public function getAllProjectsPaginated()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $page = (int)($_GET['page'] ?? 1);
        $limit = (int)($_GET['limit'] ?? 10);

        $offset = ($page - 1) * $limit;

        $projects = $this->projectModel->getAllProjectsPaginated($limit, $offset);
        $totalProjects = $this->projectModel->getTotalProjectsCount();

        $this->sendJsonResponse([
            'success' => true,
            'data' => $projects,
            'pagination' => [
                'total' => $totalProjects,
                'page' => $page,
                'limit' => $limit,
                'totalPages' => ceil($totalProjects / $limit)
            ]
        ], 200);
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

        $members = $this->memberModel->getMembersByProjectId((int)$projectId);

        $this->sendJsonResponse(['success' => true, 'members' => $members], 200);
    }

    public function getActivity()
    {
        $this->sendJsonResponse(['success' => true, 'activity' => []], 200);
    }

    public function removeMember()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $projectId = $_POST['project_id'] ?? null;
        $email = $_POST['email'] ?? '';

        if (empty($projectId) || empty($email)) {
            $this->sendJsonResponse(['success' => false, 'message' => 'ID del proyecto y correo electrónico son requeridos'], 400);
        }

        // Verificar si el proyecto existe
        $project = $this->projectModel->getProjectById((int)$projectId);
        if (!$project) {
            $this->sendJsonResponse(['success' => false, 'message' => 'Proyecto no encontrado'], 404);
        }

        // Verificar si el miembro existe
        $existingMembers = $this->memberModel->getMembersByProjectId((int)$projectId);
        $exists = false;
        foreach ($existingMembers as $member) {
            if ($member['email'] === $email) {
                $exists = true;
                break;
            }
        }
        if (!$exists) {
            $this->sendJsonResponse(['success' => false, 'message' => 'El usuario no es miembro del proyecto'], 400);
        }

        if ($this->memberModel->removeMemberFromProject((int)$projectId, $email)) {
            $this->sendJsonResponse(['success' => true, 'message' => 'Has abandonado el proyecto'], 200);
        } else {
            $this->sendJsonResponse(['success' => false, 'message' => 'Error al abandonar el proyecto'], 500);
        }
    }

    private function sendJsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}