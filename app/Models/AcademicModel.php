<?php

namespace App\Models;

use App\Core\Model;

class AcademicModel extends Model
{

    public function getAllCohorts()
    {
        return $this->db->query("SELECT * FROM cohorts ORDER BY start_date DESC")->fetchAll();
    }

    public function getAllClasses()
    {
        return $this->db->query("
            SELECT c.*, co.title as course_title 
            FROM classes c 
            JOIN courses co ON c.course_id = co.id 
            ORDER BY c.class_code ASC
        ")->fetchAll();
    }

    public function addCohort($name, $start, $end)
    {
        return $this->db->query("INSERT INTO cohorts (name, start_date, end_date) VALUES (?, ?, ?)", [$name, $start, $end]);
    }

    public function getCohortById($id)
    {
        return $this->db->query("SELECT * FROM cohorts WHERE id = ?", [$id])->fetch();
    }

    public function getClassesByCohort($cohortId)
    {
        return $this->db->query("
            SELECT c.*, co.title as course_title, co.code as course_code 
            FROM classes c 
            JOIN courses co ON c.course_id = co.id 
            WHERE c.cohort_id = ?
        ", [$cohortId])->fetchAll();
    }

    public function getClassesByCohortAndDept($cohortId, $deptId)
    {
        return $this->db->query("
            SELECT c.*, co.title as course_title, co.code as course_code 
            FROM classes c 
            JOIN courses co ON c.course_id = co.id 
            WHERE c.cohort_id = ? AND co.department_id = ?
        ", [$cohortId, $deptId])->fetchAll();
    }

    public function addClass($code, $courseId, $cohortId)
    {
        return $this->db->query("INSERT INTO classes (class_code, course_id, cohort_id) VALUES (?, ?, ?)", [$code, $courseId, $cohortId]);
    }

    public function getClassById($id)
    {
        return $this->db->query("
            SELECT c.*, co.title as course_title, co.code as course_code,
                   co.department_id, coh.name as cohort_name
            FROM classes c 
            JOIN courses co ON c.course_id = co.id 
            JOIN cohorts coh ON c.cohort_id = coh.id
            WHERE c.id = ?
        ", [$id])->fetch();
    }

    public function getClassesByCourse($courseId)
    {
        return $this->db->query("
            SELECT c.*, coh.name as cohort_name 
            FROM classes c
            JOIN cohorts coh ON c.cohort_id = coh.id
            WHERE c.course_id = ? AND coh.is_active = 1
            ORDER BY c.class_code ASC
        ", [$courseId])->fetchAll();
    }

    // -- Enrollment Logic --

    public function getEnrolledStudents($classId)
    {
        return $this->db->query("
            SELECT u.id, u.full_name, u.email, u.identifier 
            FROM users u 
            JOIN enrollments e ON u.id = e.user_id 
            WHERE e.class_id = ?
        ", [$classId])->fetchAll();
    }

    public function getAvailableStudents($classId)
    {
        // Students NOT enrolled in this class
        return $this->db->query("
            SELECT id, full_name, email FROM users 
            WHERE role_id = (SELECT id FROM roles WHERE name='Student') 
            AND id NOT IN (SELECT user_id FROM enrollments WHERE class_id = ?)
        ", [$classId])->fetchAll();
    }

    public function enrollStudent($classId, $userId)
    {
        return $this->db->query("INSERT INTO enrollments (class_id, user_id) VALUES (?, ?)", [$classId, $userId]);
    }

    // -- Allocations Logic --

    public function getUnitsWithAllocations($classId, $courseId)
    {
        // Left join units with existing allocations for this class
        return $this->db->query("
            SELECT u.*, ua.trainer_user_id, ua.verifier_user_id 
            FROM units u 
            LEFT JOIN unit_allocations ua ON u.id = ua.unit_id AND ua.class_id = ? 
            WHERE u.course_id = ? 
            ORDER BY u.unit_code ASC
        ", [$classId, $courseId])->fetchAll();
    }

    public function upsertAllocation($classId, $unitId, $trainerId, $verifierId)
    {
        // Convert empty strings to null
        $trainerId = !empty($trainerId) ? $trainerId : null;
        $verifierId = !empty($verifierId) ? $verifierId : null;

        // Remove existing allocation for this unit/class combo first (simple approach) or use ON DUPLICATE
        // Let's use ON DUPLICATE KEY UPDATE if (unit_id, class_id) was unique in schema? 
        // Schema check: id is PK. No unique constraint on (unit_id, class_id) in 001_initial_schema.sql!
        // Wait, schema check:
        // CREATE TABLE IF NOT EXISTS unit_allocations ( id INT AUTO_INCREMENT PRIMARY KEY ...
        // We should add a unique constraint to avoid duplicates, or just check before insert.
        // For now, I'll do a check.

        $exists = $this->db->query("SELECT id FROM unit_allocations WHERE unit_id=? AND class_id=?", [$unitId, $classId])->fetch();

        if ($exists) {
            return $this->db->query("UPDATE unit_allocations SET trainer_user_id=?, verifier_user_id=? WHERE id=?", [$trainerId, $verifierId, $exists['id']]);
        } else {
            return $this->db->query("INSERT INTO unit_allocations (unit_id, class_id, trainer_user_id, verifier_user_id) VALUES (?, ?, ?, ?)", [$unitId, $classId, $trainerId, $verifierId]);
        }
    }

    public function getUsersByRole($roleName)
    {
        return $this->db->query("
            SELECT u.id, u.full_name, u.identifier 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            WHERE r.name = ?
        ", [$roleName])->fetchAll();
    }

    // Helper to get all courses for dropdown
    public function getAllCourses()
    {
        return $this->db->query("SELECT id, title, code FROM courses ORDER BY code")->fetchAll();
    }

    public function getCoursesByDept($deptId)
    {
        return $this->db->query("SELECT id, title, code FROM courses WHERE department_id = ? ORDER BY code", [$deptId])->fetchAll();
    }

    public function getClassesByDept($deptId)
    {
        return $this->db->query("
            SELECT c.*, co.title as course_title 
            FROM classes c 
            JOIN courses co ON c.course_id = co.id 
            WHERE co.department_id = ?
            ORDER BY c.class_code ASC
        ", [$deptId])->fetchAll();
    }

    public function getCounts()
    {
        $users = $this->db->query("SELECT COUNT(*) as c FROM users")->fetch()['c'];
        $courses = $this->db->query("SELECT COUNT(*) as c FROM courses")->fetch()['c'];
        $classes = $this->db->query("SELECT COUNT(*) as c FROM classes")->fetch()['c']; // Maybe filter by active? assuming all active for now
        return ['users' => $users, 'courses' => $courses, 'classes' => $classes];
    }
    // -- Helpers for Import --

    public function getStudentUnits($studentId)
    {
        $stmt = $this->db->query("
            SELECT u.*, c.class_code, co.title as course_title, c.id as class_id
            FROM units u
            JOIN courses co ON u.course_id = co.id
            JOIN classes c ON c.course_id = co.id
            JOIN enrollments e ON c.id = e.class_id
            WHERE e.user_id = ?
        ", [$studentId]);
        return $stmt->fetchAll();
    }

    public function getStudentRoleId()
    {
        $stmt = $this->db->prepare("SELECT id FROM roles WHERE name = 'Student'");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getUserIdByEmail($email)
    {
        return $this->db->query("SELECT id FROM users WHERE email = ?", [$email])->fetchColumn();
    }
}
