<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProfessionalDocModel;
use App\Models\AcademicModel;
use App\Models\InstitutionModel;

class ProfessionalDocController extends Controller
{
    private $model;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $this->model = new ProfessionalDocModel();
    }

    // Trainer View: Upload
    // Usually accessed from Class View
    public function uploadView()
    {
        $classId = $_GET['class_id'] ?? null;
        $unitId = $_GET['unit_id'] ?? null;

        if (!$classId || !$unitId) {
            $_SESSION['flash_error'] = 'Invalid context for document upload.';
            $this->redirect('/dashboard');
        }

        // Get details for display
        $acadModel = new AcademicModel();
        $class = $acadModel->getClassById($classId);
        $instModel = new InstitutionModel();
        $unit = $instModel->getUnitById($unitId);

        // Previous docs
        $docs = $this->model->getDocsByUnitClass($unitId, $classId);

        $this->view('documents/upload', [
            'class' => $class,
            'unit' => $unit,
            'docs' => $docs,
            'title' => 'Professional Documents'
        ]);
    }

    public function upload()
    {
        $classId = $_POST['class_id'];
        $unitId = $_POST['unit_id'];
        $type = $_POST['type'];

        if (isset($_FILES['doc_file']) && $_FILES['doc_file']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['doc_file']['name'], PATHINFO_EXTENSION));
            $newFileName = 'DOC_' . $classId . '_' . $unitId . '_' . time() . '.' . $ext;
            $uploadDir = UPLOAD_DIR . 'docs/';

            if (!file_exists($uploadDir))
                mkdir($uploadDir, 0777, true);

            if (move_uploaded_file($_FILES['doc_file']['tmp_name'], $uploadDir . $newFileName)) {
                $this->model->submitDoc($_SESSION['user_id'], $unitId, $classId, $type, $newFileName);
                \App\Core\Audit::log('Prof Doc Upload', "Trainer uploaded $type for Unit $unitId, Class $classId");
                $_SESSION['flash_success'] = "Document ($type) uploaded successfully.";
            } else {
                $_SESSION['flash_error'] = "Failed to save file.";
            }
        }
        $this->redirect("/documents/upload?class_id=$classId&unit_id=$unitId");
    }

    // HOD View: Review
    public function review()
    {
        if ($_SESSION['role'] !== 'HOD' && $_SESSION['role'] !== 'Admin') {
            $this->redirect('/dashboard');
        }

        $userModel = new \App\Models\UserModel();
        $deptId = $userModel->getUserDepartment($_SESSION['user_id']);

        if (!$deptId) {
            $_SESSION['flash_error'] = "You are not assigned to a department.";
            $this->redirect('/dashboard');
        }

        $pending = $this->model->getPendingDocsForDept($deptId);

        $this->view('documents/review', [
            'pending' => $pending,
            'title' => 'Review Professional Documents'
        ]);
    }

    public function updateStatus()
    {
        $id = $_POST['doc_id'];
        $status = $_POST['status']; // Approved / Rejected
        $comments = $_POST['comments'];

        $this->model->updateStatus($id, $status, $comments);
        \App\Core\Audit::log('Prof Doc Reviewed', "HOD marked Doc $id as $status");
        $_SESSION['flash_success'] = "Document marked as $status.";
        $this->redirect('/documents/review');
    }
}
