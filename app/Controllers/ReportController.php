<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ReportModel;

class ReportController extends Controller
{
    private $model;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $this->model = new ReportModel();
    }

    public function index()
    {
        $role = $_SESSION['role'];
        if ($role === 'Admin') {
            $this->adminIndex();
        } elseif ($role === 'Student') {
            $this->studentProgress();
        } elseif ($role === 'HOD') {
            // HOD Dash
            $this->redirect('/reports/dept_overview');
        } elseif ($role === 'InternalVerifier') {
            // QA / IV Dashboard
            $this->redirect('/reports/iv_analytics');
        } elseif ($role === 'Trainer') {
            // Fetch departments for the IV selector
            $instModel = new \App\Models\InstitutionModel();
            $departments = $instModel->getAllDepartments();

            $this->view('reports/landing', [
                'role' => $role,
                'departments' => $departments,
                'title' => 'Reports & Analytics'
            ]);
        }
    }

    public function adminIndex()
    {
        $userId = $_GET['user_id'] ?? null;
        $action = $_GET['action'] ?? null;
        $date = $_GET['date'] ?? null;

        $logs = $this->model->getLogsByFilter($userId, $action, $date);
        $users = (new \App\Models\UserModel())->getAllUsers();

        // Fetch Cohorts for dropdown
        $cohorts = (new \App\Models\AcademicModel())->getAllCohorts();

        $this->view('reports/index', [
            'logs' => $logs,
            'users' => $users,
            'cohorts' => $cohorts,
            'filters' => ['user_id' => $userId, 'action' => $action, 'date' => $date],
            'title' => 'System Reports'
        ]);
    }

    public function studentProgress()
    {
        $userId = $_SESSION['role'] === 'Student' ? $_SESSION['user_id'] : ($_GET['student_id'] ?? 0);
        if (!$userId)
            $this->redirect('/dashboard');

        $data = $this->model->getStudentProgress($userId);

        // For view, get Student Details
        // ... (Skipping full user fetch for brevity, assume name in session or fetched via ID)
        $studentNames = $_SESSION['name']; // Fallback

        $this->view('reports/student_progress', [
            'report' => $data,
            'studentName' => $studentNames,
            'title' => 'Student Progress Report'
        ]);
    }

    public function trainerMatrix()
    {
        $classId = $_GET['class_id'];
        $unitId = $_GET['unit_id'];

        $data = $this->model->getClassMatrix($classId, $unitId);
        $this->view('reports/trainer_matrix', ['data' => $data, 'title' => 'Competence Matrix']);
    }

    public function ivReport()
    {
        $classId = $_GET['class_id'];
        $unitId = $_GET['unit_id'];

        $data = $this->model->getIVReport($classId, $unitId);
        $this->view('reports/iv_report', ['data' => $data, 'title' => 'IV Sampling Report']);
    }

    public function ivAnalytics()
    {
        $type = $_GET['type'] ?? 'progress';
        $data = [];
        $title = '';

        if ($type == 'progress') {
            $data = $this->model->getIVProgress();
            $title = 'Verification Progress (Coverage)';
            $view = 'reports/iv_progress';
        } elseif ($type == 'consistency') {
            $data = $this->model->getTrainerConsistency();
            $title = 'Trainer Quality & Consistency';
            $view = 'reports/iv_consistency';
        } elseif ($type == 'dept') {
            $data = $this->model->getDepartmentQuality();
            $title = 'Departmental Quality Summary';
            $view = 'reports/iv_dept';
        }

        $this->view($view, ['data' => $data, 'title' => $title]);
    }

    public function adminCohortReport()
    {
        $cohortId = $_GET['cohort_id'];
        $data = $this->model->getCohortEnrollment($cohortId);
        $this->view('reports/admin_cohort', ['data' => $data, 'title' => 'Cohort Report']);
    }

    public function deptOverview()
    {
        if ($_SESSION['role'] !== 'HOD' && $_SESSION['role'] !== 'Admin') {
            $this->redirect('/dashboard');
        }

        $userModel = new \App\Models\UserModel();
        $deptId = $userModel->getUserDepartment($_SESSION['user_id']); // Admin might need selector but let's assume Admin implies own dept or all? 
        // Admin: show all? or select one?
        // Logic: if Admin, allow `?dept_id=X`. If HOD, force own.

        if ($_SESSION['role'] === 'Admin' && isset($_GET['dept_id'])) {
            $deptId = $_GET['dept_id'];
        }

        if (!$deptId) {
            $_SESSION['flash_error'] = 'You are not assigned to any department. Please contact an Administrator.';
            $this->redirect('/dashboard');
        }

        $data = $this->model->getDeptOverview($deptId);
        $this->view('reports/dept_overview', ['data' => $data, 'title' => 'Department Overview Report']);
    }

    public function ivDetailedReport()
    {
        if ($_SESSION['role'] !== 'InternalVerifier' && $_SESSION['role'] !== 'Admin') {
            $this->redirect('/dashboard');
        }

        $deptId = $_GET['dept_id'] ?? null;
        if (!$deptId) {
            // If not selected, redirect to select page? Or show error.
            // Re-using audit select dept page logic might be best or a mini selector here.
            // For now, redirect to audit dept selection but with a flag? or just error.
            $this->redirect('/reports/iv_analytics'); // Back to main hub
        }

        $summary = $this->model->getIVDeptSummary($deptId);
        $rows = $this->model->getIVDeptRows($deptId);

        // Fetch Dept Name for Title
        $deptName = 'Department ' . $deptId; // Simple fallback or fetch

        $this->view('reports/iv_detailed_dept', [
            'summary' => $summary,
            'rows' => $rows,
            'title' => 'IV Detailed Findings'
        ]);
    }
}
