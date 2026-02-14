<?php

namespace App\Controllers;

use App\Core\Controller;

class ProfileController extends Controller
{

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $db = \App\Core\Database::getInstance();
        $user = $db->query("
            SELECT u.*, r.name as role_name, d.name as dept_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            LEFT JOIN departments d ON u.department_id = d.id
            WHERE u.id = ?
        ", [$_SESSION['user_id']])->fetch();

        $classes = [];
        if ($user['role_name'] === 'Student') {
            $classes = $db->query("
                SELECT c.class_code, co.title as course_title, co.code as course_code 
                FROM enrollments e 
                JOIN classes c ON e.class_id = c.id 
                JOIN courses co ON c.course_id = co.id 
                WHERE e.user_id = ?
            ", [$_SESSION['user_id']])->fetchAll();
        }

        $this->view('profile/index', [
            'user' => $user,
            'classes' => $classes,
            'title' => 'My Profile'
        ]);
    }

    public function update()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $name = $_POST['full_name'];
        $phone = $_POST['phone_number'];
        $password = $_POST['password'];

        $db = \App\Core\Database::getInstance();

        // Handle Photo Upload
        $picSql = "";
        $params = [];

        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $fileName = $_FILES['profile_picture']['name'];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                $newFileName = $userId . '_' . time() . '.' . $ext;
                $uploadDir = UPLOAD_DIR . 'profile/';

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadDir . $newFileName)) {
                    $picSql = ", profile_picture = ?";
                    $params[] = $newFileName;
                }
            }
        }

        // Update Logic
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET full_name = ?, phone_number = ?, password_hash = ? $picSql WHERE id = ?";
            $baseParams = [$name, $phone, $hash];
        } else {
            $sql = "UPDATE users SET full_name = ?, phone_number = ? $picSql WHERE id = ?";
            $baseParams = [$name, $phone];
        }

        // Merge params
        $finalParams = array_merge($baseParams, $params, [$userId]);

        $db->query($sql, $finalParams);

        // Update session name if changed
        $_SESSION['name'] = $name;

        $_SESSION['flash_success'] = 'Profile updated successfully!';
        $this->redirect('/profile');
    }
}
