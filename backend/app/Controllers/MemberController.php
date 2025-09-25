<?php

namespace App\Backend\Controllers;

use App\Backend\Models\DashboardModel;
use App\Backend\Models\ProjectModel;
use App\Backend\Models\MemberModel;

class MemberController
{
    private $dashboardModel;
    private $projectModel;
    private $memberModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
        $this->projectModel = new ProjectModel();
        $this->memberModel = new MemberModel();
    }

    public function createMember()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $role = $_POST['role'] ?? '';
       // $projectId = $_POST['project_id'] ?? 0;
        $email = $_POST['email'] ?? '';
        $name = $_POST['name'] ?? '';


        $projectId = $_POST['project_id'] ?? null;

        // Normalizamos: '' => null
        if ($projectId === '' || $projectId === 'null') {
            $projectId = null;
        } else {
            $projectId = (int)$projectId;
        }


         if (empty($email) || empty($name)) {
            $this->sendJsonResponse(['success' => false, 'message' => 'Faltan datos requeridos'], 400);
        }

          $memberId = $this->memberModel->addProjectMember($projectId, $name, $email, $role);

        if ($memberId) {
            $this->sendJsonResponse(['success' => true, 'message' => 'Miembro de Proyecto creado exitosamente', 'member_Id' => $memberId], 201);
        } else {
            $this->sendJsonResponse(['success' => false, 'message' => 'Error al crear el miembro de proyecto o dashboard no encontrado.'], 500);
        }

    }
//este se usa en cuando se buscan todos
    public function getMembers()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $members = $this->memberModel->getAllMembers();
        
        if ($members !== null) {
            $this->sendJsonResponse(['success' => true, 'data' => $members], 200);
        } else {
            $this->sendJsonResponse(['success' => false, 'message' => 'No se pudieron obtener los Miembros.'], 500);
        }
    }
    //este se usa en el dashboard en si mismo
    public function getDashboard()
    {
        // if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        //     $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        // }

        // $slug = $_GET['slug'] ?? null;
        // if (!$slug) {
        //     $this->sendJsonResponse(['success' => false, 'message' => 'Slug de dashboard requerido.'], 400);
        // }

        // $dashboard = $this->dashboardModel->findBySlug($slug);
        
        // if ($dashboard) {
        //     // Obtener proyectos asociados al dashboard
        //     $dashboard['projects'] = $this->projectModel->getProjectsByDashboardSlug($slug);
            
        //     $this->sendJsonResponse(['success' => true, 'dashboard' => $dashboard], 200);
        // } else {
        //     $this->sendJsonResponse(['success' => false, 'message' => 'Dashboard no encontrado.'], 404);
        // }
    }

    public function update()
    {
        // if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        //     $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        // }

        // $slug = $_POST['slug'] ?? null;
        // $title = $_POST['title'] ?? '';
        // $description = $_POST['description'] ?? '';
        // $color = $_POST['color'] ?? 'blue';

        // if (empty($slug) || empty($title) || empty($description)) {
        //     $this->sendJsonResponse(['success' => false, 'message' => 'Slug, título y descripción son requeridos'], 400);
        // }

        // $validColors = ['blue', 'green', 'purple', 'red', 'orange', 'yellow', 'pink', 'indigo'];
        // if (!in_array($color, $validColors)) {
        //     $color = 'blue';
        // }

        // if ($this->dashboardModel->updateDashboard($slug, $title, $description, $color)) {
        //     $this->sendJsonResponse(['success' => true, 'message' => 'Dashboard actualizado exitosamente'], 200);
        // } else {
        //     $this->sendJsonResponse(['success' => false, 'message' => 'Error al actualizar el dashboard o no se encontró.'], 500);
        // }
    }

    public function delete()
    {
            // Eliminar un miembro
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $memberEmail = $_POST['email'] ?? null;
        $projectId = $_POST['project_id'] ?? null;

        if (empty($memberEmail)) {
            $this->sendJsonResponse(['success' => false, 'message' => 'email requerido para eliminar.'], 400);
        }

        if (empty($projectId)) {
            $this->sendJsonResponse(['success' => false, 'message' => 'project_id requerido para eliminar.'], 400);
        }


        if ($this->memberModel->deleteMember($memberEmail,$projectId)) {
            $this->sendJsonResponse(['success' => true, 'message' => 'Miembro eliminado exitosamente'], 200);
        } else {
            $this->sendJsonResponse(['success' => false, 'message' => 'Error al eliminar el miembro o no se encontró.'], 500);
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