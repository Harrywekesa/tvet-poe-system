<?php

namespace App\Models;

use App\Core\Model;

class SubmissionModel extends Model
{

    public function getStudentClasses($studentId)
    {
        return $this->db->query("
            SELECT c.*, co.title as course_title, co.code as course_code 
            FROM enrollments e 
            JOIN classes c ON e.class_id = c.id 
            JOIN courses co ON c.course_id = co.id 
            WHERE e.user_id = ?
        ", [$studentId])->fetchAll();
    }

    public function getStudentUnits($studentId, $classId)
    {
        // Get units for the course associated with the class
        // And ideally check if student is enrolled in that class (redundant if using classId from valid source, but safer)
        return $this->db->query("
            SELECT u.* 
            FROM units u 
            JOIN classes c ON u.course_id = c.course_id 
            WHERE c.id = ? 
            ORDER BY u.unit_code ASC
        ", [$classId])->fetchAll();
    }

    public function getSubmissionsForUnit($studentId, $unitId)
    {
        return $this->db->query("
            SELECT s.*, slot.title as slot_title, slot.type as slot_type,
                   (SELECT comments FROM poe_reviews r WHERE r.submission_id = s.id ORDER BY r.id DESC LIMIT 1) as latest_comment,
                   (SELECT decision FROM poe_reviews r WHERE r.submission_id = s.id ORDER BY r.id DESC LIMIT 1) as latest_decision
            FROM poe_submissions s 
            JOIN assessment_slots slot ON s.assessment_slot_id = slot.id 
            WHERE s.student_user_id = ? AND slot.unit_id = ?
        ", [$studentId, $unitId])->fetchAll();
    }

    public function getSubmissionForSlot($studentId, $slotId)
    {
        return $this->db->query("
            SELECT * FROM poe_submissions 
            WHERE student_user_id = ? AND assessment_slot_id = ? 
            ORDER BY version DESC LIMIT 1
        ", [$studentId, $slotId])->fetch(); // Get latest version
    }

    public function submitEvidence($studentId, $slotId, $filePath, $fileType)
    {
        // Versioning: Check if previous exists
        $prev = $this->getSubmissionForSlot($studentId, $slotId);
        $version = $prev ? $prev['version'] + 1 : 1;

        // Auto-archive previous if needed or just insert new row as current
        // For simplicity in this SQL, we will just insert. 
        // In a complex system, we might mark old ones as 'Archived'.
        // My schema has 'version'.

        // If re-submitting, typically we want to update the status to 'Submitted' if it was Rejected.
        return $this->db->query("
            INSERT INTO poe_submissions (student_user_id, assessment_slot_id, file_path, file_type, status, version, submitted_at) 
            VALUES (?, ?, ?, ?, 'Submitted', ?, NOW())
        ", [$studentId, $slotId, $filePath, $fileType, $version]);
    }

    public function getClassSubmissions($classId, $unitId)
    {
        return $this->db->query("
            SELECT s.*, e.class_id, 
                   slot.title as slot_title, slot.type as slot_type, 
                   t.title as topic_title,
                   (SELECT comments FROM poe_reviews r WHERE r.submission_id = s.id ORDER BY r.id DESC LIMIT 1) as latest_comment,
                   (SELECT decision FROM poe_reviews r WHERE r.submission_id = s.id ORDER BY r.id DESC LIMIT 1) as latest_decision
            FROM poe_submissions s 
            JOIN assessment_slots slot ON s.assessment_slot_id = slot.id 
            LEFT JOIN unit_topics t ON slot.topic_id = t.id
            JOIN enrollments e ON s.student_user_id = e.user_id 
            WHERE e.class_id = ? AND slot.unit_id = ? 
            AND s.id IN (
                SELECT MAX(id) FROM poe_submissions GROUP BY student_user_id, assessment_slot_id
            )
        ", [$classId, $unitId])->fetchAll();
    }

    public function updateSubmissionStatus($subId, $status, $reviewerId, $role, $comments)
    {
        // Update submission status
        $this->db->query("UPDATE poe_submissions SET status = ? WHERE id = ?", [$status, $subId]);

        // Log review
        return $this->db->query("
            INSERT INTO poe_reviews (submission_id, reviewer_user_id, role_at_time, decision, comments) 
            VALUES (?, ?, ?, ?, ?)
        ", [$subId, $reviewerId, $role, $status, $comments]);
    }

    public function updateVerificationStatus($submissionId, $status, $verifierId, $role, $comment = null)
    {
        // Update status
        $this->db->query("
            UPDATE poe_submissions 
            SET verification_status = ? 
            WHERE id = ?
        ", [$status, $submissionId]);

        // Log comment if exists or always log the decision?
        // Let's always log the decision in reviews for history.
        if ($comment || $status) {
            $this->db->query("
                INSERT INTO poe_reviews (submission_id, reviewer_user_id, role_at_time, decision, comments) 
                VALUES (?, ?, ?, ?, ?)
            ", [$submissionId, $verifierId, $role, $status, $comment]);
        }
    }

    public function getSubmissionById($id)
    {
        return $this->db->query("SELECT * FROM poe_submissions WHERE id = ?", [$id])->fetch();
    }

    // Dashboard Counters
    public function getRejectedCount($studentId)
    {
        // Count latest versions only? Or any? Usually current status.
        // Assuming latest only matter. We need to filter by MAX(version) or just simple query if we don't keep old rows as active.
        // My submitEvidence inserts new row. So we need to query the latest one for each slot.
        // Complex query:
        return $this->db->query("
            SELECT COUNT(*) as count FROM poe_submissions s
            WHERE s.student_user_id = ? AND s.status = 'Rejected'
            AND s.id IN (
                SELECT MAX(id) FROM poe_submissions GROUP BY student_user_id, assessment_slot_id
            )
        ", [$studentId])->fetch()['count'];
    }

    public function getPendingAssessmentCount($studentId)
    {
        // Total slots available to student - Total slots submitted (latest status != Missing)
        // 1. Get Enrolled Classes
        $classes = $this->getStudentClasses($studentId);
        $totalSlots = 0;
        foreach ($classes as $c) {
            // get units -> get slots
            $slots = $this->db->query("
                SELECT COUNT(*) as c FROM assessment_slots s
                JOIN units u ON s.unit_id = u.id
                WHERE u.course_id = ?
             ", [$c['course_id']])->fetch()['c'];
            $totalSlots += $slots;
        }

        // 2. Get Submitted Count (distinct slots)
        $submitted = $this->db->query("
            SELECT COUNT(DISTINCT assessment_slot_id) as c FROM poe_submissions 
            WHERE student_user_id = ?
        ", [$studentId])->fetch()['c'];

        return max(0, $totalSlots - $submitted);
    }
    public function getSubmissionDetails($submissionId)
    {
        return $this->db->query("
            SELECT s.*, u.full_name as student_name, slot.title as slot_title, unit.unit_title, unit.unit_code
            FROM poe_submissions s
            JOIN users u ON s.student_user_id = u.id
            JOIN assessment_slots slot ON s.assessment_slot_id = slot.id
            JOIN units unit ON slot.unit_id = unit.id
            WHERE s.id = ?
        ", [$submissionId])->fetch();
    }

    public function getReviewsForSubmission($submissionId)
    {
        return $this->db->query("
            SELECT r.*, u.full_name as reviewer_name
            FROM poe_reviews r
            LEFT JOIN users u ON r.reviewer_user_id = u.id
            WHERE r.submission_id = ?
            ORDER BY r.reviewed_at ASC
        ", [$submissionId])->fetchAll();
    }
}
