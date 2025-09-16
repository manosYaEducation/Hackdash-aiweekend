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

    public function getMembersByProjectId(int $projectId): array
    {
        // For now, return dummy data. In a real application, you would join with a users table
        // and potentially a project_members pivot table.
        return [
            ['id' => 1, 'user_name' => 'Ana García', 'email' => 'ana@example.com', 'role' => 'owner', 'avatar_initials' => 'AG'],
            ['id' => 2, 'user_name' => 'Carlos López', 'email' => 'carlos@example.com', 'role' => 'admin', 'avatar_initials' => 'CL'],
            ['id' => 3, 'user_name' => 'María Rodríguez', 'email' => 'maria@example.com', 'role' => 'member', 'avatar_initials' => 'MR'],
        ];
    }
}
