<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\SubmissionModel;
use App\Models\InstitutionModel;
use App\Models\AssessmentModel;
use App\Models\AcademicModel;

class ReviewController extends Controller
{
    private $subModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'Trainer' && $_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'InternalVerifier')) {
            $this->redirect('/login');
        }
        $this->subModel = new SubmissionModel();
    }

    public function reviewUnit($unitId, $classId)
    {
        $instModel = new InstitutionModel();
        $unit = $instModel->getUnitById($unitId);

        $acadModel = new AcademicModel();
        $class = $acadModel->getClassById($classId);

        // Get all students in this class
        $students = $acadModel->getEnrolledStudents($classId);

        // Get all slots for unit
        $assModel = new AssessmentModel();
        $slots = $assModel->getAssessmentSlots($unitId);

        // Get all submissions for these slots and students
        // We need a method to get ALL submissions for a class/unit combo
        $submissions = $this->subModel->getClassSubmissions($classId, $unitId);

        // Organize subs by student_id -> slot_id
        $matrix = [];
        foreach ($submissions as $s) {
            $matrix[$s['student_user_id']][$s['assessment_slot_id']] = $s;
        }

        $this->view('review/class_review', [
            'unit' => $unit,
            'class' => $class,
            'students' => $students,
            'slots' => $slots,
            'matrix' => $matrix,
            'title' => 'Review Evidence'
        ]);
    }

    public function updateStatus()
    {
        $subId = $_POST['submission_id'];
        $status = $_POST['status']; // Approved / Rejected
        $comments = $_POST['comments'];
        $redirect = $_POST['redirect_url'];

        if ($subId && $status) {
            $reviewerId = $_SESSION['user_id'];
            $role = $_SESSION['role'];
            $this->subModel->updateSubmissionStatus($subId, $status, $reviewerId, $role, $comments);
            \App\Core\Audit::log('Assessment Graded', "Trainer graded Submission $subId as $status");
            $_SESSION['flash_success'] = 'Submission status updated.';
        }

        header("Location: " . $redirect);
        header("Location: " . $redirect);
        exit;
    }

    public function updateVerification()
    {
        $subId = $_POST['submission_id'];
        $status = $_POST['status']; // Sampled / Verified / IV_Rejected
        $redirect = $_POST['redirect_url'];
        $reason = $_POST['cv_reason'] ?? '';

        if ($subId && $status) {
            $verifierId = $_SESSION['user_id'];
            $role = $_SESSION['role'];
            // Ensure only IV can do this
            if ($role === 'InternalVerifier' || $role === 'Admin') {
                $this->subModel->updateVerificationStatus($subId, $status, $verifierId, $role, $reason);
                \App\Core\Audit::log('IV Verification', "IV marked Submission $subId as $status. Reason: $reason");
            }
        }

        header("Location: " . $redirect);
        exit;
    }

    public function bulkUpdate()
    {
        $ids = $_POST['submission_ids'] ?? [];
        $action = $_POST['bulk_action']; // Approve / Reject
        $redirect = $_POST['redirect_url'];

        if (!empty($ids) && ($action === 'Approve' || $action === 'Reject')) {
            $reviewerId = $_SESSION['user_id'];
            $role = $_SESSION['role'];
            $status = ($action === 'Approve') ? 'Approved' : 'Rejected';
            $comments = ($action === 'Approve') ? 'Bulk Approved' : 'Bulk Rejected';

            foreach ($ids as $id) {
                $this->subModel->updateSubmissionStatus($id, $status, $reviewerId, $role, $comments);
            }
        }

        header("Location: " . $redirect);
        exit;
    }
}
