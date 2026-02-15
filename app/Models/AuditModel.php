<?php

namespace App\Models;

use App\Core\Model;

class AuditModel extends Model
{
    public function createSession($unitId, $classId, $verifierId, $sampleSize)
    {
        $this->db->query("
            INSERT INTO audit_sessions (unit_id, class_id, verifier_user_id, sample_size, status) 
            VALUES (?, ?, ?, ?, 'Pending')
        ", [$unitId, $classId, $verifierId, $sampleSize]);
        return $this->db->lastInsertId();
    }

    public function getSession($id)
    {
        return $this->db->query("SELECT * FROM audit_sessions WHERE id = ?", [$id])->fetch();
    }

    public function getSessionByUnitClass($unitId, $classId)
    {
        return $this->db->query("
            SELECT * FROM audit_sessions 
            WHERE unit_id = ? AND class_id = ? 
            ORDER BY created_at DESC LIMIT 1
        ", [$unitId, $classId])->fetch();
    }

    public function createSamples($sessionId, $studentIds)
    {
        foreach ($studentIds as $sId) {
            $this->db->query("
                INSERT INTO audit_samples (audit_session_id, student_user_id) 
                VALUES (?, ?)
            ", [$sessionId, $sId]);
        }
    }

    public function getSamples($sessionId)
    {
        return $this->db->query("
            SELECT DISTINCT s.*, u.full_name, u.identifier 
            FROM audit_samples s
            JOIN users u ON s.student_user_id = u.id
            WHERE s.audit_session_id = ?
        ", [$sessionId])->fetchAll();
    }

    public function updateSampleStatus($id, $status, $comments)
    {
        return $this->db->query("
            UPDATE audit_samples SET status = ?, comments = ? WHERE id = ?
        ", [$status, $comments, $id]);
    }

    public function completeSession($id)
    {
        return $this->db->query("
            UPDATE audit_sessions SET status = 'Completed', completed_at = NOW() WHERE id = ?
        ", [$id]);
    }

    // Dashboard: Get assigned units for IV
    public function getAssignedAudits($verifierId)
    {
        return $this->db->query("
            SELECT ua.*, u.unit_code, u.unit_title, c.class_code, co.title as course_title,
                   (SELECT COUNT(*) FROM enrollments e WHERE e.class_id = c.id) as population,
                   (SELECT id FROM audit_sessions WHERE unit_id = u.id AND class_id = c.id ORDER BY created_at DESC LIMIT 1) as session_id,
                   (SELECT status FROM audit_sessions WHERE unit_id = u.id AND class_id = c.id ORDER BY created_at DESC LIMIT 1) as session_status
            FROM unit_allocations ua
            JOIN units u ON ua.unit_id = u.id
            JOIN classes c ON ua.class_id = c.id
            JOIN courses co ON c.course_id = co.id
            WHERE ua.verifier_user_id = ?
        ", [$verifierId])->fetchAll();
    }
}
