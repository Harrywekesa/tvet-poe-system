<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\InstitutionModel;

class InstitutionController extends Controller
{
    private $model;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Trainer' && $_SESSION['role'] !== 'HOD')) {
            $this->redirect('/login');
        }
        $this->model = new InstitutionModel();
    }

    public function index()
    {
        $inst = $this->model->getInstitutionDetails();
        $depts = $this->model->getAllDepartments();

        $this->view('institution/index', [
            'institution' => $inst,
            'departments' => $depts,
            'title' => 'Institution Management'
        ]);
    }

    public function updateDetails()
    {
        $name = $_POST['name'];
        $code = $_POST['tvet_code'];
        $address = $_POST['address'];
        $systemName = $_POST['system_name'] ?? 'CBET POE System';
        $email = $_POST['contact_email'] ?? '';
        $phone = $_POST['contact_phone'] ?? '';
        $about = $_POST['about_text'] ?? '';

        $logoPath = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $result = \App\Services\UploadService::handleUpload('logo', 'settings', ['jpg', 'jpeg', 'png']);
            if ($result['success']) {
                $logoPath = $result['path'];
            } else {
                $_SESSION['flash_error'] = 'Logo Upload Failed: ' . $result['error'];
            }
        }

        $heroPath = null;
        if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] === UPLOAD_ERR_OK) {
            $result = \App\Services\UploadService::handleUpload('hero_image', 'settings', ['jpg', 'jpeg', 'png']);
            if ($result['success']) {
                $heroPath = $result['path'];
            } else {
                $_SESSION['flash_error'] = 'Hero Upload Failed: ' . $result['error'];
            }
        }

        $this->model->updateInstitution($name, $code, $address, $systemName, $email, $phone, $about, $logoPath, $heroPath);
        $_SESSION['flash_success'] = 'Institution details updated.';
        $this->redirect('/institution');
    }

    public function storeDepartment()
    {
        $name = $_POST['name'];
        if ($name) {
            try {
                $this->model->addDepartment($name);
                \App\Core\Audit::log('Department Created', "Created department: $name");
                $_SESSION['flash_success'] = 'Department added successfully.';
            } catch (\Exception $e) {
                // handle duplicate
                $_SESSION['flash_error'] = 'Error adding department.';
            }
        }
        $this->redirect('/institution');
    }

    public function deleteDepartment()
    {
        $id = $_POST['id'];
        try {
            $this->model->deleteDepartment($id);
            \App\Core\Audit::log('Department Deleted', "Deleted department ID $id");
            $_SESSION['flash_success'] = 'Department deleted.';
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = 'Cannot delete department. It may have associated courses or users.';
        }
        $this->redirect('/institution');
    }

    public function viewDepartment($id)
    {
        // Here we show courses for this dept
        $courses = $this->model->getCoursesByDept($id);

        $this->view('institution/department_view', [
            'dept_id' => $id,
            'courses' => $courses,
            'title' => 'Department Details' // In real app, fetch Dept Name
        ]);
    }

    public function downloadTemplate($type)
    {
        // Clear any previous output to prevent HTML corruption
        if (ob_get_level())
            ob_end_clean();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $type . '_template.csv"');

        $out = fopen('php://output', 'w');

        if ($type === 'department') {
            fputcsv($out, ['Department Name']);
            fputcsv($out, ['ICT Department']);
        } elseif ($type === 'course') {
            fputcsv($out, ['Title', 'Code', 'Level', 'Department Name']);
            fputcsv($out, ['Diploma in ICT', 'DICT/2024', '6', 'ICT Department']);
        } elseif ($type === 'unit') {
            fputcsv($out, ['Unit Code', 'Unit Title', 'Course Code', 'Category', 'Description']);
            fputcsv($out, ['ICT/CU/001', 'Operating Systems', 'DICT/2024', 'Core', 'Intro to OS']);
        }

        fclose($out);
        exit;
    }

    public function storeCourse()
    {
        $deptId = $_POST['department_id'];
        $title = $_POST['title'];
        $code = $_POST['code'];
        $level = $_POST['level'];

        if ($title && $deptId) {
            $this->model->addCourse($title, $code, $deptId, $level);
            \App\Core\Audit::log('Course Created', "Created course $code - $title");
            $_SESSION['flash_success'] = 'Course created successfully.';
        }
        $this->redirect('/institution/department/' . $deptId);
    }

    public function viewCourse($id)
    {
        $course = $this->model->getCourseById($id);
        $units = $this->model->getUnitsByCourseSafe($id);

        $this->view('institution/course_view', [
            'course' => $course,
            'units' => $units,
            'title' => $course['code'] . ' - Units'
        ]);
    }

    public function editCourse($id)
    {
        $course = $this->model->getCourseById($id);
        $depts = $this->model->getAllDepartments();

        $this->view('institution/course_edit', [
            'course' => $course,
            'departments' => $depts,
            'title' => 'Edit Course'
        ]);
    }

    public function updateCourse()
    {
        if ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'HOD') {
            $this->redirect('/dashboard');
        }

        $id = $_POST['id'];
        $title = $_POST['title'];
        $code = $_POST['code'];
        $level = $_POST['level'];
        $deptId = $_POST['department_id'];

        if ($id) {
            $this->model->updateCourse($id, $title, $code, $level, $deptId);
            $_SESSION['flash_success'] = 'Course updated successfully.';
        }
        $this->redirect('/institution/department/' . $deptId);
    }

    public function storeUnit()
    {
        $courseId = $_POST['course_id'];
        $code = $_POST['unit_code'];
        $title = $_POST['unit_title'];
        $category = $_POST['category'];
        $desc = $_POST['description'];

        // Optional: Context Class ID passed if creating from inside a class view
        $classId = $_POST['context_class_id'] ?? null;

        $unitId = $this->model->addUnit($courseId, $code, $title, $category, $desc);
        \App\Core\Audit::log('Unit Created', "Created unit $code - $title");
        $_SESSION['flash_success'] = 'Unit created successfully.';

        // If Trainer created it and context Class ID exists, auto-allocate
        if ($_SESSION['role'] === 'Trainer' && $classId) {
            $acadModel = new \App\Models\AcademicModel();
            $acadModel->upsertAllocation($classId, $unitId, $_SESSION['user_id'], null);
            $this->redirect('/academic/class/' . $classId); // Go back to class
            return;
        }

        $this->redirect('/institution/course/' . $courseId);
    }

    public function editUnit($id)
    {
        $unit = $this->model->getUnitById($id);
        $this->view('institution/unit_edit', [
            'unit' => $unit,
            'title' => 'Edit Unit'
        ]);
    }

    public function updateUnit()
    {
        $id = $_POST['id'];
        $courseId = $_POST['course_id'];
        $code = $_POST['unit_code'];
        $title = $_POST['unit_title'];
        $category = $_POST['category'];
        $desc = $_POST['description'];

        $this->model->updateUnit($id, $code, $title, $category, $desc);
        \App\Core\Audit::log('Unit Updated', "Updated unit $code - $title");
        $_SESSION['flash_success'] = 'Unit updated successfully.';
        $this->redirect('/institution/course/' . $courseId);
    }
    public function previewImport()
    {
        $type = $_POST['type']; // department, course, unit

        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
            $fileIdx = $_FILES['csv_file']['tmp_name'];
            $handle = fopen($fileIdx, "r");

            // Skip Header
            fgetcsv($handle);

            $validRows = [];

            while (($row = fgetcsv($handle)) !== FALSE) {
                // Basic Validation per Type
                // Just check count for now
                if ($type === 'department' && isset($row[0])) {
                    $validRows[] = ['name' => $row[0]];
                } elseif ($type === 'course' && count($row) >= 4) {
                    $validRows[] = ['title' => $row[0], 'code' => $row[1], 'level' => $row[2], 'dept_name' => $row[3]];
                } elseif ($type === 'unit' && count($row) >= 3) {
                    $validRows[] = ['unit_code' => $row[0], 'unit_title' => $row[1], 'course_code' => $row[2], 'category' => $row[3] ?? 'Core', 'description' => $row[4] ?? ''];
                }
            }
            fclose($handle);

            // Store in Session
            $_SESSION['import_type'] = $type;
            $_SESSION['import_data'] = $validRows;

            $this->view('institution/import_preview', [
                'type' => $type,
                'valid_rows' => $validRows
            ]);

        } else {
            $_SESSION['flash_error'] = "File upload failed.";
            $this->redirect('/institution');
        }
    }

    public function commitImport()
    {
        if (!isset($_SESSION['import_data']) || empty($_SESSION['import_data'])) {
            $_SESSION['flash_error'] = "No data to import.";
            $this->redirect('/institution');
        }

        $type = $_SESSION['import_type'];
        $rows = $_SESSION['import_data'];
        $count = 0;
        $errors = 0;

        foreach ($rows as $row) {
            try {
                if ($type === 'department') {
                    $this->model->addDepartment($row['name']);
                    $count++;
                } elseif ($type === 'course') {
                    $deptId = $this->model->getDepartmentByName($row['dept_name']);
                    if ($deptId) {
                        $this->model->addCourse($row['title'], $row['code'], $deptId, $row['level']);
                        $count++;
                    } else {
                        $errors++;
                    }
                } elseif ($type === 'unit') {
                    $courseId = $this->model->getCourseByCode($row['course_code']);
                    if ($courseId) {
                        $this->model->addUnit($courseId, $row['unit_code'], $row['unit_title'], $row['category'], $row['description']);
                        $count++;
                    } else {
                        $errors++;
                    }
                }
            } catch (\Exception $e) {
                $errors++;
            }
        }

        // Clear Session
        unset($_SESSION['import_data']);
        unset($_SESSION['import_type']);

        if ($count > 0) {
            \App\Core\Audit::log('Bulk Import', "Imported $count $type(s)");
            $_SESSION['flash_success'] = "Imported $count items successfully." . ($errors > 0 ? " ($errors skipped)" : "");
        } else {
            $_SESSION['flash_error'] = "No items imported.";
        }

        $this->redirect('/institution');
    }
}
