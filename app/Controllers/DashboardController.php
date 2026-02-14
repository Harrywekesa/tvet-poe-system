<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AssessmentModel;
use App\Models\SubmissionModel;
use App\Models\VerificationModel;

class DashboardController extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \App\Core\Database::getInstance();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $role = $_SESSION['role'];

        // Simple routing to role-specific views
        // For now, we use a shared dashboard view with conditional logic
        // Or strictly we could do: $this->view(strtolower($role) . '/dashboard');

        $data = [
            'role' => $role,
            'name' => $_SESSION['name'],
            'title' => 'Dashboard'
        ];

        if ($role === 'Admin') {
            $acadModel = new \App\Models\AcademicModel();
            $data['counts'] = $acadModel->getCounts();

            // Cohort Logic
            $allCohorts = $acadModel->getAllCohorts();
            $activeCohorts = [];
            $closedCohorts = [];
            $today = date('Y-m-d');

            foreach ($allCohorts as $c) {
                if ($c['end_date'] && $c['end_date'] < $today) {
                    $closedCohorts[] = $c;
                } else {
                    $activeCohorts[] = $c;
                }
            }
            $data['active_cohorts'] = $activeCohorts;
            $data['closed_cohorts'] = $closedCohorts;

        } elseif ($role === 'Trainer') {
            $assModel = new AssessmentModel();
            $data['allocations'] = $assModel->getAllocatedUnitsForTrainer($_SESSION['user_id']);
            $acadModel = new \App\Models\AcademicModel();
            $data['all_classes'] = $acadModel->getAllClasses();

            // Pending Reviews Calculation (Mock or Real)
            // Real would require querying all allocations -> all submissions in them -> status 'Submitted'
            // For now, let's just pass the data and handle view or add a quick helper if needed.
            // Keeping it light for this step.

        } elseif ($role === 'HOD') {
            $userModel = new \App\Models\UserModel();
            $deptId = $userModel->getUserDepartment($_SESSION['user_id']);

            if ($deptId) {
                // Fetch Dept Stats
                $instModel = new \App\Models\InstitutionModel();
                $courses = $instModel->getCoursesByDept($deptId);

                $acadModel = new \App\Models\AcademicModel();
                $deptClasses = $acadModel->getClassesByDept($deptId);

                // Fetch Pending Docs
                $docModel = new \App\Models\ProfessionalDocModel();
                $pendingDocs = $docModel->getPendingDocsForDept($deptId);

                // Fetch Dept Name
                $dept = $this->db->query("SELECT name FROM departments WHERE id = ?", [$deptId])->fetch();
                $data['dept_name'] = $dept['name'] ?? 'Unknown Dept';

                $data['dept_id'] = $deptId; // Pass for view (keep for logic if needed)
                $data['my_courses'] = $courses;
                $data['dept_classes'] = $deptClasses;
                $data['pending_docs'] = $pendingDocs;

                // Get Trainers in Dept
                $data['trainers'] = $this->db->query("SELECT * FROM users WHERE department_id = ? AND role_id = (SELECT id FROM roles WHERE name='Trainer')", [$deptId])->fetchAll();
            } else {
                $data['error'] = "You are not assigned to any department.";
            }

            // HODs might also be Trainers. Fetch allocations for them too.
            $assModel = new AssessmentModel();
            $data['allocations'] = $assModel->getAllocatedUnitsForTrainer($_SESSION['user_id']);


        } elseif ($role === 'InternalVerifier') {
            $verModel = new VerificationModel();
            // Fetch Dept to show unassigned units in dept
            $userModel = new \App\Models\UserModel();
            $deptId = $userModel->getUserDepartment($_SESSION['user_id']);

            $data['iv_allocations'] = $verModel->getUnitsAllocatedToVerifier($_SESSION['user_id'], $deptId);

        } elseif ($role === 'Student') {
            $subModel = new SubmissionModel();
            $data['rejected_count'] = $subModel->getRejectedCount($_SESSION['user_id']);
            $data['pending_count'] = $subModel->getPendingAssessmentCount($_SESSION['user_id']);
            $data['classes'] = $subModel->getStudentClasses($_SESSION['user_id']);

            // Fetch Enrolled Units for Marks View
            // We need a method to get units a student is enrolled in (via class)
            $acadModel = new \App\Models\AcademicModel();
            $data['my_units'] = $acadModel->getStudentUnits($_SESSION['user_id']);
        }

        $this->view('dashboard/index', $data);
    }
}
