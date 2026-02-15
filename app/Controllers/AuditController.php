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
}
