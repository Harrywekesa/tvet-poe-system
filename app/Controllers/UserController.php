<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\UserModel;

class UserController extends Controller
{
    private $model;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'HOD')) {
            $this->redirect('/login');
        }
        $this->model = new UserModel();
    }

    public function index()
    {
        if ($_SESSION['role'] === 'HOD') {
            $deptId = $this->model->getUserDepartment($_SESSION['user_id']);
            if ($deptId) {
                // Fetch Detailed Lists for HOD View
                $team_trainers = $this->model->getTrainersWithAllocations($deptId);
                $team_students = $this->model->getStudentsInDeptClasses($deptId);

                // Keep generic list as fallback or for "All" tab if needed, 
                // but usually HOD wants the detailed view.
                $users = $this->model->getUsersByDepartment($deptId);
            } else {
                $users = [];
                $team_trainers = [];
                $team_students = [];
            }
        } else {
            $users = $this->model->getAllUsers();
            $team_trainers = []; // Admin doesn't get this view by default yet
            $team_students = [];
        }

        $roles = $this->model->getAllRoles();

        $classes = (new \App\Models\AcademicModel())->getAllClasses();

        $this->view('users/index', [
            'users' => $users,
            'roles' => $roles,
            'classes' => $classes,
            'team_trainers' => $team_trainers ?? [],
            'team_students' => $team_students ?? [],
            'title' => 'User Management'
        ]);
    }

    public function store()
    {
        $name = $_POST['full_name'];
        $email = $_POST['email'];
        $identifier = $_POST['identifier'];
        $roleId = $_POST['role_id'];
        $password = $_POST['password'];
        $deptId = !empty($_POST['department_id']) ? $_POST['department_id'] : null;
        $classId = !empty($_POST['class_id']) ? $_POST['class_id'] : null;

        // Basic Validation
        if ($email && $roleId && $password) {
            try {
                $this->model->createUser($name, $email, $roleId, $password, $identifier, $deptId);

                // Enroll if class selected (and role is Student? Assuming logic holds)
                if ($classId) {
                    $academicModel = new \App\Models\AcademicModel();
                    $userId = $academicModel->getUserIdByEmail($email);
                    if ($userId) {
                        $academicModel->enrollStudent($classId, $userId);
                        \App\Core\Audit::log('User Enrolled', "Enrolled user $email in Class ID $classId");
                    }
                }

                \App\Core\Audit::log('User Created', "Created user $email ($name)");
                $_SESSION['flash_success'] = 'User created successfully.';
            } catch (\Exception $e) {
                // Handle duplicate email etc.
                $_SESSION['flash_error'] = 'Error creating user. Email likely already exists.';
            }
        }
        $this->redirect('/users');
    }

    public function importView()
    {
        $this->view('users/import', ['title' => 'Import Users']);
    }

    public function downloadTemplate()
    {
        if (ob_get_level())
            ob_end_clean();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="users_template.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Full Name', 'Email', 'Role', 'Identifier', 'Phone', 'Department', 'Class Code']);
        fputcsv($output, ['John Doe', 'john@example.com', 'Student', 'ST/001/24', '0712345678', 'ICT Department', 'ICT-JAN-24']);
        fputcsv($output, ['Jane Staff', 'jane@example.com', 'Trainer', 'PF-12345', '0722000000', 'Electrical Department', '']);
        fclose($output);
        exit;
    }

    public function import()
    {
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['csv_file']['tmp_name'];
            $handle = fopen($tmpName, 'r');

            // Skip header
            fgetcsv($handle);

            // Fetch Roles
            $roles = $this->model->getAllRoles();
            $roleMap = [];
            foreach ($roles as $r) {
                $roleMap[strtolower($r['name'])] = $r['id'];
            }

            // Fetch Departments
            $departments = (new \App\Models\InstitutionModel())->getAllDepartments();
            $deptMap = []; // Name -> ID
            foreach ($departments as $d) {
                $deptMap[strtolower($d['name'])] = $d['id'];
            }

            // Fetch Classes
            $academicModel = new \App\Models\AcademicModel();
            $classes = $academicModel->getAllClasses();
            $classMap = []; // Code -> ID
            foreach ($classes as $c) {
                $classMap[strtoupper($c['class_code'])] = $c['id'];
            }

            while (($data = fgetcsv($handle)) !== FALSE) {
                // Map: Name, Email, Role, Identifier, Phone, Department, Class Code
                $name = $data[0] ?? '';
                $email = $data[1] ?? '';
                $roleName = strtolower(trim($data[2] ?? ''));
                $identifier = $data[3] ?? null;
                $phone = $data[4] ?? null;
                $deptName = strtolower(trim($data[5] ?? ''));
                $classCode = strtoupper(trim($data[6] ?? ''));

                if ($name && $email && isset($roleMap[$roleName])) {
                    try {
                        $roleId = $roleMap[$roleName];

                        // Resolve Department ID
                        $deptId = $deptMap[$deptName] ?? null;

                        // Create User
                        $this->model->createUser($name, $email, $roleId, 'cbet1234', $identifier, $deptId);

                        // Resolve Class ID and Enroll (if Student or relevant)
                        $classId = $classMap[$classCode] ?? null;
                        if ($classId) {
                            $userId = $academicModel->getUserIdByEmail($email);
                            if ($userId) {
                                $academicModel->enrollStudent($classId, $userId);
                            }
                        }

                    } catch (\Exception $e) {
                        // Log error or continue
                    }
                }
            }
            fclose($handle);
        }
        $this->redirect('/users');
    }

    public function edit($id)
    {
        $user = $this->model->getUserById($id);
        $roles = $this->model->getAllRoles();

        $departments = (new \App\Models\InstitutionModel())->getAllDepartments();

        $classes = (new \App\Models\AcademicModel())->getAllClasses();

        $this->view('users/edit', [
            'user' => $user,
            'roles' => $roles,
            'departments' => $departments,
            'classes' => $classes,
            'title' => 'Edit User'
        ]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST['full_name'];
        $email = $_POST['email'];
        $identifier = $_POST['identifier'];
        $roleId = $_POST['role_id'];
        $deptId = !empty($_POST['department_id']) ? $_POST['department_id'] : null;
        $classId = !empty($_POST['class_id']) ? $_POST['class_id'] : null;

        $password = !empty($_POST['password']) ? $_POST['password'] : null;
        $forceChange = isset($_POST['force_change']) ? 1 : 0;

        if ($id && $name && $email) {
            $this->model->updateUser($id, $name, $email, $roleId, $identifier, $password, $forceChange, $deptId);

            if ($classId) {
                (new \App\Models\AcademicModel())->enrollStudent($classId, $id);
                \App\Core\Audit::log('User Enrolled', "Enrolled user $id in Class ID $classId via Edit");
            }

            \App\Core\Audit::log('User Update', "Updated user details for ID $id ($email)");
            $_SESSION['flash_success'] = 'User details updated successfully.';
        }
        $this->redirect('/users');
    }

    public function suspend()
    {
        $id = $_POST['user_id'];
        $reason = $_POST['reason'];
        if ($id && $reason) {
            $this->model->suspendUser($id, $reason);
            \App\Core\Audit::log('User Suspended', "Suspended User ID $id. Reason: $reason");
            $_SESSION['flash_success'] = 'User suspended successfully.';
        }
        $this->redirect('/users');
    }

    public function activate($id)
    {
        $this->model->activateUser($id);
        \App\Core\Audit::log('User Activated', "Activated User ID $id");
        $_SESSION['flash_success'] = 'User activated successfully.';
        $this->redirect('/users');
    }

    public function delete($id)
    {
        // Check if user has critical data? For now, we use soft delete.
        $this->model->deleteUser($id);
        \App\Core\Audit::log('User Deleted', "Deleted User ID $id");
        $_SESSION['flash_success'] = 'User deleted successfully.';
        $this->redirect('/users');
    }
}
