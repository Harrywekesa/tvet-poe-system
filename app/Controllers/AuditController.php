<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\InstitutionModel;
use App\Models\AcademicModel;
use App\Models\ProfessionalDocModel;
use App\Models\SubmissionModel;
use App\Models\VerificationModel;

class AuditController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'InternalVerifier' && $_SESSION['role'] !== 'Admin')) {
            $this->redirect('/login');
        }
    }

    public function index()
    {
        // 1. Select Department
        $instModel = new InstitutionModel();
        $depts = $instModel->getAllDepartments();

        $this->view('audit/select_dept', ['depts' => $depts, 'title' => 'Audit: Select Department']);
    }

    public function selectCourse()
    {
        $deptId = $_GET['dept_id'] ?? null;
        if (!$deptId) {
            $_SESSION['flash_error'] = 'Invalid department.';
            $this->redirect('/audit');
        }

        $instModel = new InstitutionModel();
        $courses = $instModel->getCoursesByDept($deptId);

        $this->view('audit/select_course', [
            'courses' => $courses,
            'dept_id' => $deptId,
            'title' => 'Audit: Select Course'
        ]);
    }

    public function selectUnit()
    {
        $courseId = $_GET['course_id'] ?? null;
        if (!$courseId) {
            $_SESSION['flash_error'] = 'Invalid course.';
            $this->redirect('/audit');
        }

        // "Units registered for the active cohort"
        // 1. Find active cohorts
        $acadModel = new AcademicModel();
        $cohorts = $acadModel->getAllCohorts();
        $activeCohortIds = [];
        $today = date('Y-m-d');
        foreach ($cohorts as $c) {
            if (!$c['end_date'] || $c['end_date'] >= $today) {
                $activeCohortIds[] = $c['id'];
            }
        }

        if (empty($activeCohortIds)) {
            $_SESSION['flash_error'] = 'No active cohorts found.';
            $this->redirect('/audit');
        }

        // 2. Find Classes for this Course in Active Cohorts
        // Need a method in AcademicModel or custom query
        $db = \App\Core\Database::getInstance();
        $classes = $db->query("
            SELECT c.*, co.name as cohort_name 
            FROM classes c 
            JOIN cohorts co ON c.cohort_id = co.id 
            WHERE c.course_id = ? AND c.cohort_id IN (" . implode(',', $activeCohortIds) . ")
        ", [$courseId])->fetchAll();

        // Fetch Department ID for Back Button
        $instModel = new InstitutionModel();
        $course = $instModel->getCourseById($courseId);
        $deptId = $course['department_id'];

        // 3. For each class, list units allocated? Or just list units in course and ask to select class?
        // Prompt says: "displayed with all the units registred for the active cohort ... sample and audit any unit"
        // Units are attached to Courses. Students are attached to Classes (which are Course+Cohort instances).
        // Best approach: Show Active Classes. User picks Class -> Shows Units in that class.

        $this->view('audit/select_class_unit', [
            'classes' => $classes,
            'course_id' => $courseId,
            'dept_id' => $deptId,
            'title' => 'Audit: Select Active Class'
        ]);
    }

    public function workspace()
    {
        $classId = $_GET['class_id'] ?? null;
        if (!$classId) {
            $_SESSION['flash_error'] = 'Invalid class.';
            $this->redirect('/audit');
        }

        // Fetch Course ID for Back Button
        $acadModel = new AcademicModel();
        $class = $acadModel->getClassById($classId);
        $courseId = $class['course_id'];

        // Show Units for this Class to audit
        // Can filter by specific unit if passed params, or show list
        $unitId = $_GET['unit_id'] ?? null;

        if (!$unitId) {
            // Pick Unit
            $instModel = new InstitutionModel();
            // Get course ID from class
            $units = $instModel->getUnitsByCourseSafe($class['course_id']);

            $this->view('audit/select_unit_final', [
                'class' => $class,
                'units' => $units,
                'course_id' => $courseId,
                'title' => 'Select Unit to Audit'
            ]);
            return;
        }

        // --- ACTUAL WORKSPACE ---
        $this->auditWorkspace($classId, $unitId);
    }

    private function auditWorkspace($classId, $unitId)
    {
        // 1. Fetch Professional Docs
        $docModel = new ProfessionalDocModel();
        $profDocs = $docModel->getDocsByUnitClass($unitId, $classId);

        // 2. Fetch Students & Submissions (POE)
        $subModel = new SubmissionModel();
        $submissions = $subModel->getClassSubmissions($classId, $unitId);
        // Organize by student
        $studentPoe = [];
        foreach ($submissions as $s) {
            $studentPoe[$s['student_user_id']][] = $s;
        }

        // Get Student details
        $acadModel = new AcademicModel();
        $students = $acadModel->getEnrolledStudents($classId);

        // Get Unit/Class Info
        $instModel = new InstitutionModel();
        $unit = $instModel->getUnitById($unitId);
        $class = $acadModel->getClassById($classId);

        $this->view('audit/workspace', [
            'prof_docs' => $profDocs,
            'students' => $students,
            'poe_data' => $studentPoe,
            'unit' => $unit,
            'class' => $class,
            'title' => 'Audit Workspace'
        ]);
    }
}
