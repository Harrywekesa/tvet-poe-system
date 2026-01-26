<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AssessmentModel;

class PreviewController extends Controller
{
    public function assessment($id)
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        // Fetch Assessment Slot
        // We need a method to get slot by ID in AssessmentModel.
        // For now, I'll do a quick DB query here or add method.
        // Let's add method to model is better practice, but for speed I will use Model generic query if public?
        // Model doesn't expose query. I must add getSlotById to AssessmentModel.

        $model = new AssessmentModel();
        // Assuming getSlotById exists or I'll add it now.
        // I'll add it in the next tool call properly.
        $slot = $model->getSlotById($id);

        if (!$slot || empty($slot['file_path'])) {
            echo "File not found.";
            return;
        }

        $fileUrl = APP_URL . '/uploads/assessments/' . $slot['file_path'];
        $ext = strtolower(pathinfo($slot['file_path'], PATHINFO_EXTENSION));

        $this->view('common/preview', [
            'title' => 'Preview: ' . $slot['title'],
            'fileUrl' => $fileUrl,
            'fileType' => $ext,
            'downloadUrl' => $fileUrl
        ]);
    }

    public function submission($id)
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $model = new \App\Models\SubmissionModel();
        $sub = $model->getSubmissionById($id);

        if (!$sub || empty($sub['file_path'])) {
            echo "File not found.";
            return;
        }

        $fileUrl = APP_URL . '/preview/serve?type=submission&id=' . $id;
        $ext = strtolower(pathinfo($sub['file_path'], PATHINFO_EXTENSION));

        $this->view('common/preview', [
            'title' => 'Evidence Preview',
            'fileUrl' => $fileUrl,
            'fileType' => $ext,
            'downloadUrl' => $fileUrl // Serve handles download if visited directly
        ]);
    }

    public function download()
    {
        // For docs
        $file = $_GET['file'] ?? '';
        if (!$file)
            die('Invalid file');

        $path = UPLOAD_DIR . $file;
        if (file_exists($path)) {
            $mime = mime_content_type($path);
            header("Content-Type: $mime");
            header("Content-Disposition: inline; filename=\"" . basename($path) . "\"");
            readfile($path);
            exit;
        }
        die('File not found at ' . $path);
    }

    public function serve()
    {
        $type = $_GET['type'];
        $id = $_GET['id'];

        $path = '';
        if ($type === 'submission') {
            $model = new \App\Models\SubmissionModel();
            $sub = $model->getSubmissionById($id);
            $path = UPLOAD_DIR . $sub['file_path'];
        } elseif ($type === 'assessment') {
            // ...
        }

        if ($path && file_exists($path)) {
            $mime = mime_content_type($path);
            header("Content-Type: $mime");
            header("Content-Disposition: inline; filename=\"" . basename($path) . "\"");
            readfile($path);
            exit;
        }
        die('File not found.');
    }
}
