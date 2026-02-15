<?php

namespace App\Controllers;

use App\Core\Controller;

class BulkImportController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'HOD')) {
            $this->redirect('/login');
        }
    }

    public function index()
    {
        $this->view('bulk/index', [
            'title' => 'Bulk Data Imports'
        ]);
    }
}
