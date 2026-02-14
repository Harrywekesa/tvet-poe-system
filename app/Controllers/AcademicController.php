<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AcademicModel;

class AcademicController extends Controller
{
    private $model;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $role = $_SESSION['role'];
        if ($role !== 'Admin' && $role !== 'HOD' && $role !== 'Trainer') { // Allow Trainer
            // Assuming Students use SubmissionController/View, not this Admin view
            $this->redirect('/dashboard');
        }
        $this->model = new AcademicModel();
    }

    public function index()
    {
        if ($_SESSION['role'] === 'Trainer') { // Trainers should use Dashboard, no list access
            $this->redirect('/dashboard');
        }
        $cohorts = $this->model->getAllCohorts();
        $this->view('academic/index', [
            'cohorts' => $cohorts,
            'title' => 'Cohort Management'
        ]);
    }

    public function downloadEnrollmentTemplate()
    {
        // Clear buffer
        if (ob_get_level())
            ob_end_clean();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="enrollment_template.csv"');
        $out = fopen('php://output', 'w');

        // Add CSV headers
        fputcsv($out, ['Student Name', 'Student Email', 'Student Identifier']);

        fclose($out);
        exit(); // Terminate script after sending file
    }

    public function storeCohort()
    {
        if ($_SESSION['role'] !== 'Admin') // Only Admin can create cohorts
            $this->redirect('/academic');

        $name = $_POST['name'];
        $start = $_POST['start_date'];
        $end = $_POST['end_date'];

        if ($name) {
            $this->model->addCohort($name, $start, $end);
            \App\Core\Audit::log('Cohort Created', "Created cohort: $name");
            $_SESSION['flash_success'] = 'Cohort created successfully.';
        }
        $this->redirect('/academic');
    }

    public function importStudents($classId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
            $file = $_FILES['csv_file']['tmp_name'];
            if (($handle = fopen($file, "r")) !== FALSE) {
                // Skip header row
                fgetcsv($handle);

                $studentRoleId = $this->model->getStudentRoleId();

                while (($data = fgetcsv($handle)) !== FALSE) {
                    $name = $data[0] ?? '';
                    $email = $data[1] ?? '';
                    $ident = $data[2] ?? '';

                    if ($email) {
                        $userId = $this->model->getUserIdByEmail($email);

                        if (!$userId && $name && $studentRoleId) {
                            try {
                                $userModel = new \App\Models\UserModel();
                                $userModel->createUser($name, $email, $studentRoleId, 'student123', $ident);
                                $userId = $this->model->getUserIdByEmail($email);
                            } catch (\Exception $e) {
                            }
                        }

                        if ($userId) {
                            try {
                                $this->model->enrollStudent($classId, $userId);
                                \App\Core\Audit::log('Student Enrolled', "Enrolled User $userId into Class $classId");
                            } catch (\Exception $e) {
                            }
                        }
                    }
                }
                fclose($handle);
                $_SESSION['flash_success'] = 'Students enrolled successfully.';
            }
        }
        $this->redirect('/academic/class/' . $classId);
    }

    public function viewCohort($id)
    {
        $cohort = $this->model->getCohortById($id);
        $classes = $this->model->getClassesByCohort($id);

        if ($_SESSION['role'] === 'HOD') {
            // Get HOD's department (robust check)
            $userModel = new \App\Models\UserModel();
            $deptId = $userModel->getUserDepartment($_SESSION['user_id']);
            $courses = $this->model->getCoursesByDept($deptId);
        } else {
            $courses = $this->model->getAllCourses();
        }

        $this->view('academic/cohort_view', [
            'cohort' => $cohort,
            'classes' => $classes,
            'courses' => $courses,
            'title' => $cohort['name'] . ' - Classes'
        ]);
    }

    public function storeClass()
    {
        if ($_SESSION['role'] === 'Trainer')
            $this->redirect('/dashboard');

        $cohortId = $_POST['cohort_id'];
        $courseId = $_POST['course_id'];
        $code = $_POST['class_code'];

        if ($code && $courseId) {
            $this->model->addClass($code, $courseId, $cohortId);
            \App\Core\Audit::log('Class Created', "Created class $code in cohort $cohortId");
            $_SESSION['flash_success'] = 'Class created successfully.';
        }
        $this->redirect('/academic/cohort/' . $cohortId);
    }

    public function viewClass($id)
    {
        $class = $this->model->getClassById($id);
        if (!$class)
            die("Class not found");

        $instModel = new \App\Models\InstitutionModel(); // Reuse or inject
        $course = $instModel->getCourseById($class['course_id']);

        $enrolled = $this->model->getEnrolledStudents($id);
        $available = $this->model->getAvailableStudents($id);

        $unitsAllocated = $this->model->getUnitsWithAllocations($id, $class['course_id']);

        $trainers = $this->model->getUsersByRole('Trainer');
        $verifiers = $this->model->getUsersByRole('InternalVerifier'); // Check role name from schema: 'InternalVerifier'
        // Schema says: ('Admin'), ('Trainer'), ('HOD'), ('InternalVerifier'), ('Student')

        $this->view('academic/class_view', [
            'class' => $class,
            'course' => $course,
            'enrolled_students' => $enrolled,
            'available_students' => $available,
            'units' => $unitsAllocated,
            'trainers' => $trainers,
            'verifiers' => $verifiers,
            'title' => 'Manage Class - ' . $class['class_code']
        ]);
    }

    public function enrollStudent()
    {
        $classId = $_POST['class_id'];
        $userId = $_POST['user_id'];
        if ($classId && $userId) {
            $this->model->enrollStudent($classId, $userId);
            \App\Core\Audit::log('Enrollment', "Enrolled user $userId into class $classId");
            $_SESSION['flash_success'] = 'Student enrolled successfully.';
        }
        $this->redirect('/academic/class/' . $classId);
    }

    public function allocateUnit()
    {
        $classId = $_POST['class_id'];
        $unitId = $_POST['unit_id'];
        $trainerId = $_POST['trainer_id'];
        $verifierId = $_POST['verifier_id'];
        if ($classId && $unitId) {
            $this->model->upsertAllocation($classId, $unitId, $trainerId, $verifierId);
            \App\Core\Audit::log('Unit Allocation', "Allocated Unit $unitId in Class $classId to Trainer $trainerId");
            $_SESSION['flash_success'] = 'Allocation updated.';
        }
        $this->redirect('/academic/class/' . $classId);
    }
}
