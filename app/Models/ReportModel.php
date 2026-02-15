<?php

namespace App\Models;

use App\Core\Model;

class ReportModel extends Model
{
    public function getLatestLogs($limit = 100)
    {
        return $this->db->query("
            SELECT l.*, u.full_name, u.email 
            FROM activity_logs l 
            LEFT JOIN users u ON l.user_id = u.id 
            ORDER BY l.created_at DESC 
            LIMIT $limit
        ")->fetchAll();
    }

    public function getLogsByFilter($userId = null, $action = null, $date = null, $search = null)
    {
        $sql = "SELECT l.*, u.full_name, u.email 
                FROM activity_logs l 
                LEFT JOIN users u ON l.user_id = u.id 
                WHERE 1=1";
        $params = [];

        if ($userId) {
            $sql .= " AND l.user_id = ?";
            $params[] = $userId;
        }
        if ($action) {
            $sql .= " AND l.action = ?";
            $params[] = $action;
        }
        if ($date) {
            $sql .= " AND DATE(l.created_at) = ?";
            $params[] = $date;
        }
        if ($search) {
            $sql .= " AND (l.details LIKE ? OR l.action LIKE ? OR u.full_name LIKE ?)";
            $term = "%$search%";
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
        }

        $sql .= " ORDER BY l.created_at DESC LIMIT 200";

        return $this->db->query($sql, $params)->fetchAll();
    }

    // -- Student Progress Report --
    public function getStudentProgress($userId, $classId = null)
    {
        // 1. Get Class Info
        $sqlClass = "SELECT c.*, co.title as course_title, co.code as course_code, co.id as course_id 
                     FROM enrollments e 
                     JOIN classes c ON e.class_id = c.id 
                     JOIN courses co ON c.course_id = co.id 
                     WHERE e.user_id = ?";
        $params = [$userId];
        if ($classId) {
            $sqlClass .= " AND c.id = ?";
            $params[] = $classId;
        }

        $classes = $this->db->query($sqlClass, $params)->fetchAll();
        $reportData = [];

        foreach ($classes as $c) {
            // Get Units
            $units = $this->db->query("
                SELECT * FROM units WHERE course_id = ? ORDER BY unit_code ASC
            ", [$c['course_id']])->fetchAll();

            $unitData = [];
            foreach ($units as $u) {
                // Get Slots & Submissions with Review Comments
                $slots = $this->db->query("
                    SELECT s.id, s.title, s.type, s.topic_id,
                           sub.status, sub.id as submission_id,
                           (SELECT comments FROM poe_reviews r WHERE r.submission_id = sub.id ORDER BY r.id DESC LIMIT 1) as latest_comment
                    FROM assessment_slots s 
                    LEFT JOIN poe_submissions sub ON s.id = sub.assessment_slot_id AND sub.student_user_id = ? 
                           AND sub.id = (SELECT MAX(id) FROM poe_submissions WHERE assessment_slot_id = s.id AND student_user_id = ?)
                    WHERE s.unit_id = ?
                ", [$userId, $userId, $u['id']])->fetchAll();

                $u['assessments'] = $slots;
                $unitData[] = $u;
            }
            $c['units'] = $unitData;
            $reportData[] = $c;
        }
        return $reportData;
    }

    // -- Trainer Matrix --
    public function getClassMatrix($classId, $unitId)
    {
        // Students
        $students = $this->db->query("SELECT u.id, u.full_name, u.identifier FROM users u JOIN enrollments e ON u.id = e.user_id WHERE e.class_id = ? ORDER BY u.full_name ASC", [$classId])->fetchAll();
        // Slots
        $slots = $this->db->query("SELECT * FROM assessment_slots WHERE unit_id = ?", [$unitId])->fetchAll();
        // Submissions
        $submissions = $this->db->query("
            SELECT s.student_user_id, s.assessment_slot_id, s.status 
            FROM poe_submissions s
            WHERE s.id IN (SELECT MAX(id) FROM poe_submissions GROUP BY student_user_id, assessment_slot_id)
        ")->fetchAll();

        // Map submissions
        $map = [];
        foreach ($submissions as $s) {
            $map[$s['student_user_id'] . '_' . $s['assessment_slot_id']] = $s['status'];
        }

        return ['students' => $students, 'slots' => $slots, 'map' => $map];
    }

    // -- IV Report --
    public function getIVReport($classId, $unitId)
    {
        // Get all submissions that have been 'Verified' or 'Sampled'
        return $this->db->query("
            SELECT s.*, u.full_name as student_name, slot.title as assessment_title,
                   r.comments as trainer_comments
            FROM poe_submissions s 
            JOIN users u ON s.student_user_id = u.id 
            JOIN assessment_slots slot ON s.assessment_slot_id = slot.id 
            LEFT JOIN poe_reviews r ON s.id = r.submission_id
            WHERE slot.unit_id = ? AND s.verification_status IS NOT NULL
            AND s.id IN (SELECT MAX(id) FROM poe_submissions GROUP BY student_user_id, assessment_slot_id)
        ", [$unitId])->fetchAll();
    }

    // -- Admin Cohort Report --
    public function getCohortEnrollment($cohortId)
    {
        return $this->db->query("
            SELECT c.class_code, co.title as course_title, u.full_name, u.email, u.identifier, u.created_at
            FROM classes c 
            JOIN enrollments e ON c.id = e.class_id 
            JOIN users u ON e.user_id = u.id 
            JOIN courses co ON c.course_id = co.id 
            WHERE c.cohort_id = ?
            ORDER BY c.class_code, u.full_name
         ", [$cohortId])->fetchAll();
    }

    // -- IV: Verification Progress (Coverage) --
    public function getIVProgress()
    {
        // Group by Unit/Class to show coverage
        // Coverage = Verified Count / Submitted Count
        return $this->db->query("
            SELECT u.id as unit_id, c.id as class_id, 
                   u.unit_code, u.unit_title, c.class_code, 
                   COUNT(CASE WHEN s.status = 'Submitted' OR s.status='Approved' OR s.status='Rejected' THEN 1 END) as total_submitted,
                   COUNT(CASE WHEN s.verification_status IS NOT NULL THEN 1 END) as total_verified
            FROM units u
            JOIN courses co ON u.course_id = co.id
            JOIN classes c ON c.course_id = co.id
            LEFT JOIN assessment_slots slot ON slot.unit_id = u.id
            LEFT JOIN poe_submissions s ON s.assessment_slot_id = slot.id AND s.id IN (SELECT MAX(id) FROM poe_submissions GROUP BY student_user_id, assessment_slot_id)
                AND s.student_user_id IN (SELECT user_id FROM enrollments WHERE class_id = c.id)
            GROUP BY u.id, c.id
            HAVING total_submitted > 0
            ORDER BY u.unit_code
        ")->fetchAll();
    }

    // -- IV: Trainer Consistency --
    public function getTrainerConsistency()
    {
        // Agreement = Where IV decision matches Trainer decision (implied by 'Approved' -> 'Verified Accepted' logic, but simpler: did IV overwrite?)
        // In our system, IV status is separate. 
        // Let's count how many Verified items have 'Rejected' by IV vs 'Approved' by Trainer?
        // Actually simpler: Just show breakdown of IV decisions per Trainer.
        // We link Unit -> Allocation -> Trainer.

        return $this->db->query("
             SELECT t.full_name as trainer_name,
                    COUNT(s.id) as total_checked,
                    SUM(CASE WHEN s.verification_status = 'Accepted' THEN 1 ELSE 0 END) as agreed,
                    SUM(CASE WHEN s.verification_status = 'Rejected' THEN 1 ELSE 0 END) as disagreed
             FROM poe_submissions s
             JOIN assessment_slots slot ON s.assessment_slot_id = slot.id
             JOIN unit_allocations ua ON ua.unit_id = slot.unit_id 
             JOIN users t ON ua.trainer_user_id = t.id
             WHERE s.verification_status IS NOT NULL
             -- AND ua.class_id ... (Need to join enrollment to get class to match allocation? Complex, simplifying to Unit Trainer)
             GROUP BY t.id
        ")->fetchAll();
    }

    // -- IV: Departmental Quality --
    public function getDepartmentQuality()
    {
        // Dept -> Course -> Unit -> Submissions
        // Avg Pass Rate = Approved / Total Submitted
        return $this->db->query("
            SELECT d.name as dept_name,
                   COUNT(DISTINCT c.id) as active_courses,
                   COUNT(s.id) as total_evidence,
                   SUM(CASE WHEN s.status = 'Approved' THEN 1 ELSE 0 END) as passed_evidence,
                   SUM(CASE WHEN s.verification_status IS NOT NULL THEN 1 ELSE 0 END) as verified_evidence
            FROM departments d
            JOIN courses co ON d.id = co.department_id
            JOIN units u ON co.id = u.course_id
            JOIN assessment_slots slot ON u.id = slot.unit_id
            LEFT JOIN poe_submissions s ON s.assessment_slot_id = slot.id 
                AND s.id IN (SELECT MAX(id) FROM poe_submissions GROUP BY student_user_id, assessment_slot_id)
            GROUP BY d.id
        ")->fetchAll();
    }

    // -- HOD: Department Overview Report --
    public function getDeptOverview($deptId)
    {
        /*
        List of Classes | Unit | Trainer | Approved Count | Rejected Count
        */
        return $this->db->query("
            SELECT c.class_code, u.unit_code, u.unit_title, 
                   COALESCE(t.full_name, 'Unassigned') as trainer_name,
                   COUNT(CASE WHEN s.status = 'Approved' THEN 1 END) as approved_count,
                   COUNT(CASE WHEN s.status = 'Rejected' THEN 1 END) as rejected_count,
                   COUNT(CASE WHEN s.status = 'Submitted' THEN 1 END) as pending_count
            FROM classes c
            JOIN courses co ON c.course_id = co.id
            JOIN units u ON co.id = u.course_id
            -- Link to Allocations to get Trainer
            LEFT JOIN unit_allocations ua ON ua.unit_id = u.id AND ua.class_id = c.id
            LEFT JOIN users t ON ua.trainer_user_id = t.id
            -- Link to Submissions
            LEFT JOIN assessment_slots slot ON slot.unit_id = u.id
            LEFT JOIN poe_submissions s ON s.assessment_slot_id = slot.id 
                 AND s.student_user_id IN (SELECT user_id FROM enrollments WHERE class_id = c.id)
            WHERE co.department_id = ?
            GROUP BY c.id, u.id
            ORDER BY c.class_code, u.unit_code
        ", [$deptId])->fetchAll();
    }

    // -- Detailed IV Report: Summary --
    public function getIVDeptSummary($deptId)
    {
        // Total active units in dept
        $totalUnits = $this->db->query("
            SELECT COUNT(u.id) as cnt FROM units u 
            JOIN courses c ON u.course_id = c.id 
            WHERE c.department_id = ?
        ", [$deptId])->fetch()['cnt'];

        // Sampled units (those with at least one verified submission)
        $sampledUnits = $this->db->query("
            SELECT COUNT(DISTINCT u.id) as cnt
            FROM units u
            JOIN courses c ON u.course_id = c.id
            JOIN assessment_slots slot ON slot.unit_id = u.id
            JOIN poe_submissions s ON s.assessment_slot_id = slot.id
            WHERE c.department_id = ? AND s.verification_status IS NOT NULL
        ", [$deptId])->fetch()['cnt'];

        return ['total_units' => $totalUnits, 'sampled_units' => $sampledUnits];
    }

    // -- Detailed IV Report: Rows --
    public function getIVDeptRows($deptId)
    {
        return $this->db->query("
            SELECT co.title as course_title, co.level, 
                   u.unit_code, u.unit_title, 
                   CONCAT(COALESCE(t.full_name, 'Unassigned'), ' (', COALESCE(t.identifier, '-'), ')') as trainer_name,
                   COUNT(s.id) as verification_count,
                   SUM(CASE WHEN s.verification_status = 'Accepted' THEN 1 ELSE 0 END) as accepted_count,
                   SUM(CASE WHEN s.verification_status = 'Rejected' THEN 1 ELSE 0 END) as rejected_count,
                   -- Concat reasons (might be long, but useful)
                   GROUP_CONCAT(DISTINCT 
                        CASE WHEN s.verification_status = 'Rejected' AND s.comments IS NOT NULL 
                        THEN s.comments ELSE NULL END 
                   SEPARATOR ' | ') as rejection_reasons
            FROM courses co
            JOIN units u ON co.id = u.course_id
            -- Trainer
            LEFT JOIN unit_allocations ua ON ua.unit_id = u.id -- AND class filter? Assuming generally assigned or picking random recent
            LEFT JOIN users t ON ua.trainer_user_id = t.id
            -- Submissions
            LEFT JOIN assessment_slots slot ON slot.unit_id = u.id
            LEFT JOIN poe_submissions s ON s.assessment_slot_id = slot.id AND s.verification_status IS NOT NULL
            WHERE co.department_id = ?
            GROUP BY u.id
            ORDER BY co.title, co.level DESC, u.unit_code
        ", [$deptId])->fetchAll();
    }
}
