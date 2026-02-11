<?php

namespace App\Core;

class Controller
{
    protected $db;

    public function __construct()
    {
        // Basic constructor
    }

    protected function ensureAuthenticated()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . APP_URL . "/login");
            exit;
        }
    }
    protected function view($view, $data = [])
    {
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View does not exist: " . $view);
        }
    }

    protected function redirect($url)
    {
        header("Location: " . APP_URL . $url);
        exit;
    }
}
