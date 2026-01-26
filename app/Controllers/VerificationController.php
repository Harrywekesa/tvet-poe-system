<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\VerificationModel;
use App\Models\InstitutionModel;

class VerificationController extends Controller
{
    private $model;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'InternalVerifier' && $_SESSION['role'] !== 'Admin')) {
            $this->redirect('/login');
        }
        $this->model = new VerificationModel();
    }

    public function listItems($unitId, $classId)
    {
        $instModel = new InstitutionModel();
        $unit = $instModel->getUnitById($unitId);

        $samples = $this->model->getSampleSubmissions($classId, $unitId);

        $this->view('verification/list', [
            'unit' => $unit,
            'samples' => $samples,
            'title' => 'Internal Verification'
        ]);
    }

    public function submitResult()
    {
        $subId = $_POST['submission_id'];
        $decision = $_POST['decision']; // Accept / Reject
        $comments = $_POST['comments'];
        $redirect = $_POST['redirect_url'];

        $this->model->verifySubmission($subId, $_SESSION['user_id'], $decision, $comments);

        header("Location: " . $redirect);
        exit;
    }
}
