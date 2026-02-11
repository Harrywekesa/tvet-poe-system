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
        return $this->db->query("SELECT * FROM marksheet_status WHERE class_id = ? AND unit_id = ?", [$classId, $unitId])->fetch();
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

    public function getPendingApprovals()
    {
        return $this->db->query("
            SELECT ms.*, u.unit_code, u.unit_title, c.class_code, tr.full_name as trainer_name 
            FROM marksheet_status ms
            JOIN units u ON ms.unit_id = u.id
            JOIN classes c ON ms.class_id = c.id
            LEFT JOIN users tr ON ms.submitted_by = tr.id
            WHERE ms.status IN ('Submitted_to_HOD', 'HOD_Approved') 
            ORDER BY ms.submitted_at DESC
        ")->fetchAll();
    }
}
