<?php

namespace App\Models;

use App\Core\Model;

class ProfessionalDocModel extends Model
{
    public function submitDoc($trainerId, $unitId, $classId, $type, $filePath)
    {
        return $this->db->query("
            INSERT INTO professional_documents (trainer_user_id, unit_id, class_id, type, file_path) 
            VALUES (?, ?, ?, ?, ?)
        ", [$trainerId, $unitId, $classId, $type, $filePath]);
    }

    public function getDocsByUnitClass($unitId, $classId)
    {
        return $this->db->query("
            SELECT d.*, u.full_name as trainer_name 
            FROM professional_documents d 
            JOIN users u ON d.trainer_user_id = u.id 
            WHERE d.unit_id = ? AND d.class_id = ? 
            ORDER BY d.created_at DESC
        ", [$unitId, $classId])->fetchAll();
    }

    public function getPendingDocsForDept($deptId)
    {
        return $this->db->query("
            SELECT d.*, u.full_name as trainer_name, unit.unit_code, c.class_code 
            FROM professional_documents d 
            JOIN users u ON d.trainer_user_id = u.id 
            JOIN units unit ON d.unit_id = unit.id 
            JOIN classes c ON d.class_id = c.id 
            JOIN courses co ON unit.course_id = co.id 
            WHERE co.department_id = ? AND d.status = 'Pending'
        ", [$deptId])->fetchAll();
    }

    public function updateStatus($id, $status, $comments)
    {
        return $this->db->query("UPDATE professional_documents SET status=?, comments=? WHERE id=?", [$status, $comments, $id]);
    }
}
