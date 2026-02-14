<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\SubmissionModel;
use App\Models\AssessmentModel;
use App\Models\InstitutionModel;

class SubmissionController extends Controller
{
    private $model;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $this->model = new SubmissionModel();
    }

    public function studentDashboard()
    {
        $studentId = $_SESSION['user_id'];
        $classes = $this->model->getStudentClasses($studentId);

        $this->view('poe/student_dashboard', [
            'classes' => $classes,
            'title' => 'My POE'
        ]);
    }

    public function viewUnitHelper($classId)
    {
        // Show units for the class
        $studentId = $_SESSION['user_id'];
        $units = $this->model->getStudentUnits($studentId, $classId);

        // We need class details too
        $academicModel = new \App\Models\AcademicModel();
        $class = $academicModel->getClassById($classId);

        $this->view('poe/unit_list', [
            'class' => $class,
            'units' => $units,
            'title' => 'My Units - ' . $class['class_code']
        ]);
    }

    public function viewUnitPOE($unitId)
    {
        $studentId = $_SESSION['user_id'];

        // Get slots
        $assModel = new AssessmentModel();
        $slots = $assModel->getAssessmentSlots($unitId);

        // Get submissions mappings
        $submissions = $this->model->getSubmissionsForUnit($studentId, $unitId);
        // Map submissions by slot_id for easy lookup in view
        $subMap = [];
        foreach ($submissions as $sub) {
            // If multiple versions, we want the latest? Method getSubmissionsForUnit returns all.
            // We should filter for latest version per slot here or in SQL. 
            // Simple logic: overwrite key, assuming ordered by version? SQL didn't order.
            // Let's rely on logic: last one seen is kept, or filter specifically.
            // Better: array of subs per slot.
            $subMap[$sub['assessment_slot_id']][] = $sub;
        }

        $instModel = new InstitutionModel();
        $unit = $instModel->getUnitById($unitId);

        $this->view('poe/unit_view', [
            'unit' => $unit,
            'slots' => $slots,
            'submissions' => $subMap,
            'title' => $unit['unit_code'] . ' - Evidence'
        ]);
    }

    public function upload()
    {
        $studentId = $_SESSION['user_id'];
        $slotId = $_POST['slot_id'];
        $unitId = $_POST['unit_id']; // For redirect

        if (isset($_FILES['evidence_file']) && $_FILES['evidence_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['evidence_file']['tmp_name'];
            $fileName = $_FILES['evidence_file']['name'];
            $fileSize = $_FILES['evidence_file']['size'];
            $fileType = $_FILES['evidence_file']['type'];

            // Limit Types (PDF, DOCX, Images)
            $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                // Generate Safe Name: user_slot_timestamp.ext
                $newFileName = $studentId . '_' . $slotId . '_' . time() . '.' . $ext;
                $uploadDir = UPLOAD_DIR; // Defined in config

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $destPath = $uploadDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $this->model->submitEvidence($studentId, $slotId, $newFileName, $ext);
                    \App\Core\Audit::log('Evidence Upload', "Student $studentId uploaded evidence for Slot $slotId");
                    $_SESSION['flash_success'] = 'Evidence uploaded successfully.';
                } else {
                    $_SESSION['flash_error'] = 'Failed to move uploaded file.';
                }
            } else {
                $_SESSION['flash_error'] = 'Invalid file type. Allowed: PDF, DOC, Images.';
            }
        } else {
            $_SESSION['flash_error'] = 'Error uploading file.';
        }

        $this->redirect('/poe/unit/' . $unitId);
    }

    public function viewEvidence($submissionId)
    {
        // 1. Fetch Submission & Verification Details
        // We need: Student Name, Unit, Slot, Date, File Path, Status, Verifier Name (if any)
        $sub = $this->model->getSubmissionDetails($submissionId);

        if (!$sub) {
            die("Evidence not found.");
        }

        // 2. Check if Approved/Verified
        // If Approved/Verified, show Cover Sheet Wrapper
        // Otherwise, redirect to file directly (or show partial wrapper without stamp)

        $isApproved = in_array($sub['status'], ['Approved', 'Verified']);

        if ($isApproved) {
            // Fetch Reviewer Details (Trainer or IV)
            $reviews = $this->model->getReviewsForSubmission($submissionId);
            $instModel = new InstitutionModel();
            $inst = $instModel->getInstitutionDetails();

            $this->view('poe/cover_sheet', [
                'submission' => $sub,
                'reviews' => $reviews,
                'inst' => $inst,
                'title' => 'Verified Evidence - ' . $sub['student_name']
            ]);
        } else {
            // Direct Serve (or via PreviewController)
            // For now, redirect to public link if accessible, or read file
            // Assuming files are in public/uploads or serve route
            $this->redirect('/uploads/' . $sub['file_path']);
        }
    }
}
