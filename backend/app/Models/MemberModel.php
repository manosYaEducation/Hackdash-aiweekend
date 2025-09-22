<?php

namespace App\Backend\Models;

use PDO;
use App\Backend\Models\Database;

class MemberModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }


 
    public function addProjectMember(
    ?int $projectId,
    string $name,
    string $email,
    string $role = 'member'
): ?int {
    $names = preg_split('/\s+/', trim($name));
    $initials = strtoupper(substr($names[0], 0, 1) . (isset($names[1]) ? substr($names[1], 0, 1) : ''));

    $stmt = $this->conn->prepare("
        INSERT INTO project_members (project_id, user_name, email, role, avatar_initials) 
        VALUES (?, ?, ?, ?, ?)
    ");

    if ($stmt->execute([$projectId, $name, $email, $role, $initials])) {
        return (int) $this->conn->lastInsertId();
    }

    return null;
}


  

    
    
    public function getAllMembers(): array
    {
        $stmt = $this->conn->query("SELECT `project_id`, `user_name`, `email`, `role`, `avatar_initials`, `joined_at` FROM `project_members` WHERE 1  ORDER BY joined_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // los que se muestran en proyectos
     public function getMembersByProjectId(int $projectId): array
    {
       

        $stmt = $this->conn->prepare("SELECT `project_id`, `user_name`, `email`, `role`, `avatar_initials`, `joined_at` FROM `project_members` WHERE  project_id = ?  ORDER BY joined_at DESC ");
        $stmt->execute([$projectId]);
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $members ?: null;


        $stmt = $this->conn->query("SELECT `project_id`, `user_name`, `email`, `role`, `avatar_initials`, `joined_at` FROM `project_members` WHERE 1  ORDER BY joined_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     public function getProjectById(int $projectId): ?array
    {
        $stmt = $this->conn->prepare("SELECT p.*, d.slug as dashboard_slug FROM projects p JOIN dashboards d ON p.dashboard_id = d.id WHERE p.id = ?");
        $stmt->execute([$projectId]);
        $project = $stmt->fetch(PDO::FETCH_ASSOC);
        return $project ?: null;
    }
}
