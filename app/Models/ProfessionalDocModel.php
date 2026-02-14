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
            SELECT pd.*, u.full_name as trainer_name, un.unit_code, c.class_code 
            FROM professional_documents pd
            JOIN users u ON pd.trainer_user_id = u.id
            JOIN units un ON pd.unit_id = un.id
            JOIN classes c ON pd.class_id = c.id
            WHERE u.department_id = ? AND pd.status = 'Pending'
            ORDER BY pd.created_at DESC
        ", [$deptId])->fetchAll();
    }

    public function getDocHistoryForDept($deptId)
    {
        return $this->db->query("
            SELECT pd.*, u.full_name as trainer_name, un.unit_code, c.class_code 
            FROM professional_documents pd
            JOIN users u ON pd.trainer_user_id = u.id
            JOIN units un ON pd.unit_id = un.id
            JOIN classes c ON pd.class_id = c.id
            WHERE u.department_id = ? AND pd.status IN ('Approved', 'Rejected')
            ORDER BY pd.created_at DESC
        ", [$deptId])->fetchAll();
    }

    public function updateStatus($id, $status, $comments, $reviewerId = null)
    {
        return $this->db->query("
            UPDATE professional_documents 
            SET status=?, comments=?, approved_by=?, updated_at=NOW() 
            WHERE id=?
        ", [$status, $comments, $reviewerId, $id]);
    }

    public function getDocDetailsWithApprover($id)
    {
        return $this->db->query("
            SELECT pd.*, 
                   u_trainer.full_name as trainer_name, 
                   u_approver.full_name as approver_name,
                   un.unit_code, un.unit_title, c.class_code
            FROM professional_documents pd
            LEFT JOIN users u_trainer ON pd.trainer_user_id = u_trainer.id
            LEFT JOIN users u_approver ON pd.approved_by = u_approver.id
            LEFT JOIN units un ON pd.unit_id = un.id
            LEFT JOIN classes c ON pd.class_id = c.id
            WHERE pd.id = ?
        ", [$id])->fetch();
    }
}
