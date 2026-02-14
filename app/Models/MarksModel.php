<?php

namespace App\Models;

use App\Core\Model;

class MarksModel extends Model
{
    // -- Student Marks --

    public function getMarksForStudent($studentId, $unitId)
    {
        // Get all marks for this student in this unit
        // Join assessment_slots to filter by unit
        return $this->db->query("
            SELECT sm.*, s.id as slot_id, s.title as slot_title, s.type, s.topic_id
            FROM student_marks sm
            JOIN assessment_slots s ON sm.assessment_slot_id = s.id
            WHERE sm.student_id = ? AND s.unit_id = ?
        ", [$studentId, $unitId])->fetchAll();
    }

    public function saveMark($studentId, $slotId, $mark, $graderId)
    {
        // Upsert mark
        $exists = $this->db->query("SELECT id FROM student_marks WHERE student_id=? AND assessment_slot_id=?", [$studentId, $slotId])->fetch();

        if ($exists) {
            return $this->db->query("
                UPDATE student_marks 
                SET marks_obtained = ?, graded_by_user_id = ?, graded_at = CURRENT_TIMESTAMP 
                WHERE id = ?
            ", [$mark, $graderId, $exists['id']]);
        } else {
            return $this->db->query("
                INSERT INTO student_marks (student_id, assessment_slot_id, marks_obtained, graded_by_user_id) 
                VALUES (?, ?, ?, ?)
            ", [$studentId, $slotId, $mark, $graderId]);
        }
    }

    // -- Marksheet Status (Approval Workflow) --

    public function getMarksheetStatus($classId, $unitId)
    {
        return $this->db->query("
            SELECT ms.*, 
                   u_hod.full_name as hod_name, d_hod.name as hod_dept,
                   u_iqs.full_name as iqs_name, 
                   u_sub.full_name as submitted_by_name, d_sub.name as submitted_dept
            FROM marksheet_status ms
            LEFT JOIN users u_hod ON ms.hod_user_id = u_hod.id
            LEFT JOIN departments d_hod ON u_hod.department_id = d_hod.id
            LEFT JOIN users u_iqs ON ms.iqs_user_id = u_iqs.id
            LEFT JOIN users u_sub ON ms.submitted_by = u_sub.id
            LEFT JOIN departments d_sub ON u_sub.department_id = d_sub.id
            WHERE ms.class_id = ? AND ms.unit_id = ?
        ", [$classId, $unitId])->fetch();
    }

    public function initMarksheet($classId, $unitId, $trainerId)
    {
        // Check if exists
        $curr = $this->getMarksheetStatus($classId, $unitId);
        if (!$curr) {
            return $this->db->query("
                INSERT INTO marksheet_status (class_id, unit_id, status, submitted_at, submitted_by) 
                VALUES (?, ?, 'Submitted_to_HOD', CURRENT_TIMESTAMP, ?)
            ", [$classId, $unitId, $trainerId]);
        } else {
            // Re-submit
            return $this->db->query("
                UPDATE marksheet_status 
                SET status = 'Submitted_to_HOD', submitted_at = CURRENT_TIMESTAMP, submitted_by = ? 
                WHERE id = ?
            ", [$trainerId, $curr['id']]);
        }
    }

    public function updateMarksheetStatus($id, $status, $comments = null, $userId = null, $role = 'HOD')
    {
        if ($role === 'HOD') {
            return $this->db->query("
                UPDATE marksheet_status 
                SET status = ?, hod_action_at = CURRENT_TIMESTAMP, hod_user_id = ?, hod_comments = ? 
                WHERE id = ?
            ", [$status, $userId, $comments, $id]);
        } elseif ($role === 'IQS') {
            return $this->db->query("
                UPDATE marksheet_status 
                SET status = ?, iqs_action_at = CURRENT_TIMESTAMP, iqs_user_id = ?, iqs_comments = ? 
                WHERE id = ?
            ", [$status, $userId, $comments, $id]);
        }
    }

    public function getAllApprovals($role)
    {
        $sql = "
            SELECT ms.id, ms.unit_id, ms.class_id, ms.status, ms.submitted_at, 
                   ms.hod_action_at, ms.iqs_action_at, ms.hod_comments, ms.iqs_comments,
                   u.unit_code, u.unit_title, c.class_code, tr.full_name as trainer_name,
                   hod.full_name as hod_name
            FROM marksheet_status ms
            JOIN units u ON ms.unit_id = u.id
            JOIN classes c ON ms.class_id = c.id
            LEFT JOIN users tr ON ms.submitted_by = tr.id
            LEFT JOIN users hod ON ms.hod_user_id = hod.id
            WHERE 1=1 
        ";

        if ($role === 'HOD') {
            // HOD sees what Trainer submitted (Pending) AND what they already acted on
            $sql .= " AND (ms.status = 'Submitted_to_HOD' OR ms.status IN ('HOD_Approved', 'HOD_Rejected', 'IQS_Approved', 'IQS_Rejected'))";
        } elseif ($role === 'InternalVerifier') {
            // IV sees what HOD approved (Pending) AND what they already acted on
            $sql .= " AND (ms.status = 'HOD_Approved' OR ms.status IN ('IQS_Approved', 'IQS_Rejected'))";
        }

        $sql .= " ORDER BY ms.submitted_at DESC";

        return $this->db->query($sql)->fetchAll();
    }
}
