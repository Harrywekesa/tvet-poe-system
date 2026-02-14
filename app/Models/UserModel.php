<?php

namespace App\Models;

use App\Core\Model;

class UserModel extends Model
{

    public function getAllUsers()
    {
        return $this->db->query("
            SELECT u.*, r.name as role_name, d.name as dept_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            LEFT JOIN departments d ON u.department_id = d.id
            WHERE u.is_deleted = 0
            ORDER BY u.created_at DESC
        ")->fetchAll();
    }

    public function getUsersByDepartment($deptId)
    {
        return $this->db->query("
            SELECT u.*, r.name as role_name, d.name as dept_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            LEFT JOIN departments d ON u.department_id = d.id
            WHERE u.department_id = ? AND u.is_deleted = 0
            ORDER BY u.created_at DESC
        ", [$deptId])->fetchAll();
    }

    // ... roles ...

    // New Control Methods
    public function suspendUser($id, $reason)
    {
        return $this->db->query("UPDATE users SET is_active = 0, suspension_reason = ? WHERE id = ?", [$reason, $id]);
    }

    public function activateUser($id)
    {
        return $this->db->query("UPDATE users SET is_active = 1, suspension_reason = NULL WHERE id = ?", [$id]);
    }

    public function deleteUser($id)
    {
        return $this->db->query("UPDATE users SET is_deleted = 1 WHERE id = ?", [$id]);
    }

    public function getAllRoles()
    {
        return $this->db->query("SELECT * FROM roles")->fetchAll();
    }

    public function createUser($name, $email, $roleId, $passwordRaw, $identifier = null, $departmentId = null)
    {
        $hash = password_hash($passwordRaw, PASSWORD_BCRYPT);
        // Default must_change_password = 1
        return $this->db->query("
            INSERT INTO users (full_name, email, role_id, password_hash, identifier, must_change_password, department_id) 
            VALUES (?, ?, ?, ?, ?, 1, ?)
        ", [$name, $email, $roleId, $hash, $identifier, $departmentId]);
    }

    public function getUserById($id)
    {
        return $this->db->query("
            SELECT u.*, r.name as role_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            WHERE u.id = ?
        ", [$id])->fetch();
    }

    public function updateUser($id, $name, $email, $roleId, $identifier, $password = null, $forceChange = 0, $departmentId = null)
    {
        $depSql = $departmentId ? ", department_id = ?" : ", department_id = NULL";
        $extraParams = $departmentId ? [$departmentId] : [];

        $sql = "UPDATE users SET full_name=?, email=?, role_id=?, identifier=?, must_change_password=? $depSql WHERE id=?";
        $baseParams = [$name, $email, $roleId, $identifier, $forceChange];

        if ($password) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET full_name=?, email=?, role_id=?, identifier=?, must_change_password=?, password_hash=? $depSql WHERE id=?";
            $baseParams = [$name, $email, $roleId, $identifier, $forceChange, $hash];
        }

        return $this->db->query($sql, array_merge($baseParams, $extraParams, [$id]));
    }

    public function getUserDepartment($userId)
    {
        // 1. Check direct assignment
        $u = $this->db->query("SELECT department_id FROM users WHERE id = ?", [$userId])->fetch();
        if ($u && $u['department_id'])
            return $u['department_id'];

        // 2. Fallback: If HOD, check departments table HEAD
        $d = $this->db->query("SELECT id FROM departments WHERE head_user_id = ?", [$userId])->fetch();
        if ($d)
            return $d['id'];

        return null;
    }

    public function updatePassword($userId, $newHash)
    {
        return $this->db->query("
            UPDATE users SET password_hash = ?, must_change_password = 0 WHERE id = ?
        ", [$newHash, $userId]);
    }

    // -- HOD Team View Helpers --

    public function getTrainersWithAllocations($deptId)
    {
        // Trainers in the department, and their allocations
        // Group by Trainer + Class to show "Class: Units"
        return $this->db->query("
            SELECT u.id, u.full_name, u.email, u.identifier, 
                   c.class_code, 
                   GROUP_CONCAT(un.unit_code ORDER BY un.unit_code SEPARATOR ', ') as units,
                   co.title as course_title
            FROM users u
            JOIN unit_allocations ua ON u.id = ua.trainer_user_id
            JOIN classes c ON ua.class_id = c.id
            JOIN units un ON ua.unit_id = un.id
            JOIN courses co ON c.course_id = co.id
            WHERE u.department_id = ?
            GROUP BY u.id, c.id
            ORDER BY u.full_name, c.class_code
        ", [$deptId])->fetchAll();
    }

    public function getStudentsInDeptClasses($deptId)
    {
        // Students enrolled in classes belonging to this department's courses
        // Show Student, Class, and All Units in that Class (Course)
        return $this->db->query("
            SELECT u.id, u.full_name, u.identifier, u.email,
                   c.class_code,
                   co.title as course_title,
                   GROUP_CONCAT(un.unit_code ORDER BY un.unit_code SEPARATOR ', ') as units
            FROM users u
            JOIN enrollments e ON u.id = e.user_id
            JOIN classes c ON e.class_id = c.id
            JOIN courses co ON c.course_id = co.id
            JOIN units un ON un.course_id = co.id
            WHERE co.department_id = ? AND u.role_id = (SELECT id FROM roles WHERE name = 'Student')
            GROUP BY u.id, c.id
            ORDER BY c.class_code, u.full_name
        ", [$deptId])->fetchAll();
    }
}
