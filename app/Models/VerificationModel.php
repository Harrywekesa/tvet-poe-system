<?php

namespace App\Models;

use App\Core\Model;

class VerificationModel extends Model
{

    public function getUnitsAllocatedToVerifier($verifierId)
    {
        return $this->db->query("
            SELECT u.*, c.class_code, c.id as class_id, co.title as course_title,
            (SELECT COUNT(*) FROM poe_submissions ps 
             JOIN enrollments e ON ps.student_user_id = e.user_id 
             JOIN assessment_slots s ON ps.assessment_slot_id = s.id
             WHERE e.class_id = c.id AND s.unit_id = u.id AND ps.status = 'Approved') as approved_count
            FROM unit_allocations ua 
            JOIN units u ON ua.unit_id = u.id 
            JOIN classes c ON ua.class_id = c.id 
            JOIN courses co ON u.course_id = co.id 
            WHERE ua.verifier_user_id = ?
        ", [$verifierId])->fetchAll();
    }

    public function getSampleSubmissions($classId, $unitId)
    {
        // IV needs to see Approved submissions to Verify them.
        // We can pick random or show all Approved
        return $this->db->query("
            SELECT DISTINCT s.*, u.full_name as student_name, slot.title as slot_title, s.file_path
            FROM poe_submissions s
            JOIN users u ON s.student_user_id = u.id
            JOIN assessment_slots slot ON s.assessment_slot_id = slot.id
            JOIN enrollments e ON u.id = e.user_id
            WHERE e.class_id = ? AND slot.unit_id = ? 
            AND s.status IN ('Approved', 'Verified', 'Submitted', 'Flagged')
            ORDER BY u.full_name
        ", [$classId, $unitId])->fetchAll();
    }

    public function verifySubmission($subId, $verifierId, $decision, $comments)
    {
        // We might add a new column 'verification_status' or just log it in poe_reviews
        // Let's assume we log it in poe_reviews with role 'InternalVerifier'
        // And maybe update status to 'Verified' or 'Flagged'?

        $newStatus = ($decision === 'Accept') ? 'Verified' : 'Flagged';

        $this->db->query("UPDATE poe_submissions SET status = ? WHERE id = ?", [$newStatus, $subId]);

        return $this->db->query("
            INSERT INTO poe_reviews (submission_id, reviewer_user_id, role_at_time, decision, comments) 
            VALUES (?, ?, 'InternalVerifier', ?, ?)
        ", [$subId, $verifierId, $decision, $comments]);
    }
}
