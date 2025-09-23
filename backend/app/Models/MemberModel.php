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

    public function addMemberToProject(int $projectId, string $userName, string $email, string $role = 'member'): bool
    {
        // Validar el rol
        $validRoles = ['owner', 'admin', 'member'];
        if (!in_array($role, $validRoles)) {
            $role = 'member';
        }

        // Generar iniciales para el avatar
        $avatarInitials = $this->generateAvatarInitials($userName);

        // Preparar la consulta para insertar el nuevo miembro
        $stmt = $this->conn->prepare("INSERT INTO project_members (project_id, user_name, email, role, avatar_initials) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$projectId, $userName, $email, $role, $avatarInitials]);
    }

    private function generateAvatarInitials(string $userName): string
    {
        $words = explode(' ', trim($userName));
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
                if (strlen($initials) >= 2) {
                    break;
                }
            }
        }
        return $initials ?: 'UN';
    }

    public function getMembersByProjectId(int $projectId): array
    {
        $stmt = $this->conn->prepare("SELECT id, user_name, email, role, avatar_initials FROM project_members WHERE project_id = ?");
        $stmt->execute([$projectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Alias removed; use getMembersByProjectId directly

    public function removeMemberFromProject(int $projectId, string $email): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM project_members WHERE project_id = ? AND email = ?");
        return $stmt->execute([$projectId, $email]);
    }
}