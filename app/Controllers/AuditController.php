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
        // IV Dashboard: Show assigned audits
        $verifierId = $_SESSION['user_id'];
        $auditModel = new \App\Models\AuditModel();
        $assigned = $auditModel->getAssignedAudits($verifierId);

        // Calculate Stats
        $stats = [
            'total' => count($assigned),
            'completed' => 0,
            'pending' => 0
        ];

        foreach ($assigned as $a) {
            if ($a['session_status'] === 'Completed') {
                $stats['completed']++;
            } else {
                $stats['pending']++;
            }
        }

        $this->view('audit/dashboard', [
            'assigned' => $assigned,
            'stats' => $stats,
            'title' => 'IV Audit Dashboard'
        ]);
    }

    public function setup()
    {
        $unitId = $_GET['unit_id'] ?? null;
        $classId = $_GET['class_id'] ?? null;

        if (!$unitId || !$classId) {
            $_SESSION['flash_error'] = 'Invalid request.';
            $this->redirect('/audit');
        }

        // 1. Get Population
        $acadModel = new AcademicModel();
        $students = $acadModel->getEnrolledStudents($classId);
        $population = count($students);

        // 2. Calculate Sample Size (Kenyan TVET standard or general rule? sqrt(N) or 10%?)
        // Let's use SQRT(N) rounded up, min 2, or all if < 5.
        if ($population < 5) {
            $sampleSize = $population;
        } else {
            $sampleSize = ceil(sqrt($population));
            if ($sampleSize < 2)
                $sampleSize = 2; // Min 2 for comparison
        }

        $instModel = new InstitutionModel();
        $unit = $instModel->getUnitById($unitId);
        $class = $acadModel->getClassById($classId);

        $this->view('audit/setup', [
            'unit' => $unit,
            'class' => $class,
            'population' => $population,
            'recommended_sample' => $sampleSize,
            'students' => $students,
            'title' => 'Audit Setup'
        ]);
    }

    public function startAudit()
    {
        $unitId = $_POST['unit_id'];
        $classId = $_POST['class_id'];
        $sampleSize = $_POST['sample_size'];
        $selectedStudents = $_POST['students'] ?? [];

        if (empty($selectedStudents)) {
            $_SESSION['flash_error'] = 'Please select students to audit.';
            $this->redirect("/audit/setup?unit_id=$unitId&class_id=$classId");
        }

        // Create Session
        $auditModel = new \App\Models\AuditModel();

        // Ensure unique students
        $selectedStudents = array_unique($selectedStudents);

        $sessionId = $auditModel->createSession($unitId, $classId, $_SESSION['user_id'], $sampleSize);

        // Create Samples
        $auditModel->createSamples($sessionId, $selectedStudents);

        $_SESSION['flash_success'] = 'Audit session started.';
        $this->redirect("/audit/perform?id=$sessionId");
    }

    public function perform()
    {
        $sessionId = $_GET['id'] ?? null;
        if (!$sessionId)
            $this->redirect('/audit');

        $auditModel = new \App\Models\AuditModel();
        $session = $auditModel->getSession($sessionId);
        $samples = $auditModel->getSamples($sessionId);

        // Load Evidence for Samples
        // We need: Student POE vs Trainer Prof Docs
        // 1. Get Trainer Docs
        $docModel = new ProfessionalDocModel();
        $profDocs = $docModel->getDocsByUnitClass($session['unit_id'], $session['class_id']);

        // 2. Get Student Submissions for each sample
        $subModel = new SubmissionModel();
        $sampleData = [];
        foreach ($samples as $sample) {
            // Get all submissions for this student in this unit
            $subs = $subModel->getSubmissionsForUnit($sample['student_user_id'], $session['unit_id']);
            $sampleData[$sample['id']] = [
                'student' => $sample,
                'submissions' => $subs
            ];
        }

        $instModel = new InstitutionModel();
        $unit = $instModel->getUnitById($session['unit_id']);

        $this->view('audit/perform', [
            'session' => $session,
            'samples' => $sampleData,
            'prof_docs' => $profDocs,
            'unit' => $unit,
            'title' => 'Perform Audit'
        ]);
    }

    public function updateSample()
    {
        $sampleId = $_POST['sample_id'];
        $status = $_POST['status'];
        $comments = $_POST['comments'];

        $auditModel = new \App\Models\AuditModel();
        $auditModel->updateSampleStatus($sampleId, $status, $comments);

        echo json_encode(['success' => true]);
        exit;
    }

    public function completeAudit()
    {
        $sessionId = $_POST['session_id'];
        $auditModel = new \App\Models\AuditModel();
        $auditModel->completeSession($sessionId);

        $_SESSION['flash_success'] = 'Audit completed.';
        $this->redirect("/audit/report?id=$sessionId");
    }

    public function report()
    {
        $sessionId = $_GET['id'] ?? null;
        $auditModel = new \App\Models\AuditModel();
        $session = $auditModel->getSession($sessionId);
        $samples = $auditModel->getSamples($sessionId);

        $instModel = new InstitutionModel();
        $unit = $instModel->getUnitById($session['unit_id']);
        $acadModel = new AcademicModel();
        $class = $acadModel->getClassById($session['class_id']);

        // Stats
        $total = count($samples);
        $compliant = 0;
        foreach ($samples as $s) {
            if ($s['status'] === 'Compliant')
                $compliant++;
        }
        $percentage = $total > 0 ? round(($compliant / $total) * 100) : 0;

        $this->view('audit/report', [
            'session' => $session,
            'samples' => $samples,
            'unit' => $unit,
            'class' => $class,
            'stats' => ['total' => $total, 'compliant' => $compliant, 'percentage' => $percentage],
            'title' => 'Audit Report'
        ]);
    }

    public function selectCourse()
    {
        $deptId = $_GET['dept_id'] ?? null;
        if (!$deptId) {
            // If dept missing, maybe show dept selector or assume HOD's dept?
            // For now, let's fetch all departments or redirect.
            // If we really need department, we can't proceed.
            // But let's check if we have a view for selecting department? `select_dept.php` exists.
            // Maybe we should redirect to dashboard?
        }

        $instModel = new InstitutionModel();
        if ($deptId) {
            $courses = $instModel->getCoursesByDept($deptId);
            $dept = $instModel->getDepartmentById($deptId); // Assumption
            $this->view('audit/select_course', ['courses' => $courses, 'dept' => $dept]);
        } else {
            // Fallback: Select Dept
            $depts = $instModel->getAllDepartments();
            $this->view('audit/select_dept', ['departments' => $depts]);
        }
    }

    public function selectUnit()
    {
        $courseId = $_GET['course_id'] ?? null;
        if (!$courseId) {
            $this->redirect('/audit/course');
        }

        $instModel = new InstitutionModel();
        $units = $instModel->getUnitsByCourse($courseId);
        $course = $instModel->getCourseById($courseId);

        // However, we need to select CLASS first?
        // `select_class_unit.php` exists.
        // `select_unit_final.php` exists.

        // The flow seems: Dept -> Course -> Class -> Unit -> Workspace
        // OR: Dept -> Course -> Unit -> Class -> Workspace

        // Let's assume standard flow: Select Course -> Select Active Class -> Select Unit in that class.
        // `select_class_unit.php` lists classes.

        $acadModel = new AcademicModel();
        $classes = $acadModel->getClassesByCourse($courseId);

        // If we want to support "Select Unit" view name:
        // `select_class_unit` view uses `$classes`.

        $this->view('audit/select_class_unit', ['classes' => $classes, 'course' => $course, 'dept_id' => $course['department_id']]);
    }

    // Alternative path if needed?
    public function selectUnitFinal()
    {
        $classId = $_GET['class_id'] ?? null;
        if (!$classId)
            $this->redirect('/audit');

        $acadModel = new AcademicModel();
        $class = $acadModel->getClassById($classId);
        $instModel = new InstitutionModel();
        // Get units for this course
        $units = $instModel->getUnitsByCourse($class['course_id']);

        $this->view('audit/select_unit_final', ['units' => $units, 'class' => $class, 'course_id' => $class['course_id']]);
    }

    public function workspace()
    {
        $unitId = $_GET['unit_id'] ?? null;
        $classId = $_GET['class_id'] ?? null;

        if ($classId && !$unitId) {
            // Redirect to unit selection for this class
            // We'll use logic from `selectUnitFinal` here directly
            $acadModel = new AcademicModel();
            $class = $acadModel->getClassById($classId);
            $instModel = new InstitutionModel();
            $units = $instModel->getUnitsByCourse($class['course_id']);

            $this->view('audit/select_unit_final', ['units' => $units, 'class' => $class, 'course_id' => $class['course_id']]);
            return;
        }

        if (!$unitId || !$classId) {
            $this->redirect('/audit');
        }

        // Check if session exists
        $auditModel = new \App\Models\AuditModel();
        $session = $auditModel->getSessionByUnitClass($unitId, $classId);

        if ($session) {
            $this->redirect('/audit/perform?id=' . $session['id']);
        } else {
            // If no session, go to SETUP
            $this->redirect("/audit/setup?unit_id=$unitId&class_id=$classId");
        }
    }
}
