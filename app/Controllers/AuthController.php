<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

class AuthController extends Controller
{

    public function login()
    {
        $this->view('auth/login');
    }

    public function loginPost()
    {
        $input = $_POST['identifier'] ?? ''; // Renamed from email
        $password = $_POST['password'] ?? '';

        if (empty($input) || empty($password)) {
            $this->view('auth/login', ['error' => 'Please fill in all fields']);
            return;
        }

        $db = Database::getInstance();
        // Join with roles table to get role name
        // Check both email and identifier (reg no)
        $stmt = $db->query("
            SELECT u.*, r.name as role_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            WHERE u.email = ? OR u.identifier = ?
        ", [$input, $input]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role_name'];
            $_SESSION['name'] = $user['full_name'];

            // Ensure audit log runs before potential redirect return
            \App\Core\Audit::log('Login', 'User ' . ($user['email'] ?? $user['identifier']) . ' logged in.');

            // Force Change Password Check
            if ($user['must_change_password'] == 1) {
                $_SESSION['force_change_password'] = true;
                $this->redirect('/change-password');
                return;
            }

            $this->redirect('/dashboard');
        } else {
            $this->view('auth/login', ['error' => 'Invalid credentials']);
        }
    }

    public function changePassword()
    {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['force_change_password'])) {
            $this->redirect('/login');
        }
        $this->view('auth/change_password', ['title' => 'Change Password']);
    }

    public function changePasswordPost()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $newPass = $_POST['new_password'];
        $confirmPass = $_POST['confirm_password'];

        if (strlen($newPass) < 6) {
            $this->view('auth/change_password', ['error' => 'Password must be at least 6 characters']);
            return;
        }

        if ($newPass !== $confirmPass) {
            $this->view('auth/change_password', ['error' => 'Passwords do not match']);
            return;
        }

        $userModel = new \App\Models\UserModel();
        $hash = password_hash($newPass, PASSWORD_BCRYPT);

        // Update password and clear the force flag
        $userModel->updatePassword($_SESSION['user_id'], $hash);

        unset($_SESSION['force_change_password']);
        \App\Core\Audit::log('Password Change', 'User ID ' . $_SESSION['user_id'] . ' changed password.');

        $_SESSION['flash_success'] = 'Password changed successfully.';
        $this->redirect('/dashboard');
    }

    public function logout()
    {
        if (isset($_SESSION['user_id'])) {
            \App\Core\Audit::log('Logout', 'User ' . $_SESSION['email'] . ' logged out.');
        }
        session_destroy();
        $this->redirect('/login');
    }
}
