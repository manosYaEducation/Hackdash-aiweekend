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


    
    public function getAllMembers(): array
    {
        $stmt = $this->conn->query("SELECT `project_id`, `user_name`, `email`, `role`, `avatar_initials`, `joined_at` FROM `project_members` WHERE 1  ORDER BY joined_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


//este se usa cuando se muestran los dashboard
    public function getMembersByProjectId(int $projectId): array
    {
        // For now, return dummy data. In a real application, you would join with a users table
        // and potentially a project_members pivot table.
        return [
            ['id' => 1, 'user_name' => 'Mauro  Rojas', 'email' => 'ana@example.com', 'role' => 'owner', 'avatar_initials' => 'AG'],
            ['id' => 2, 'user_name' => 'Yeron Paredes', 'email' => 'carlos@example.com', 'role' => 'admin', 'avatar_initials' => 'CL'],
            ['id' => 3, 'user_name' => 'Camila Suarez', 'email' => 'maria@example.com', 'role' => 'member', 'avatar_initials' => 'MR'],
        ];
    }
    // los que se muestran en proyectos
     public function getMembersByProjectIdAiWeekend(int $projectId): array
    {
        // For now, return dummy data. In a real application, you would join with a users table
        // and potentially a project_members pivot table.
        // return [
        //     ['id' => 1, 'user_name' => 'Emi  Panelli', 'email' => 'ana@example.com', 'role' => 'owner', 'avatar_initials' => 'AG'],
        //     ['id' => 2, 'user_name' => 'Flora', 'email' => 'carlos@example.com', 'role' => 'admin', 'avatar_initials' => 'CL'],
        //     ['id' => 3, 'user_name' => 'Ale Bacic', 'email' => 'ale@example.com', 'role' => 'member', 'avatar_initials' => 'MR'],
        //     ['id' => 4, 'user_name' => 'Mauro Rojas', 'email' => 'Mauro@example.com', 'role' => 'member', 'avatar_initials' => 'MR'],
        //     ['id' => 5, 'user_name' => 'Juli', 'email' => 'Juli@example.com', 'role' => 'member', 'avatar_initials' => 'MR'],
    
        // ];

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
