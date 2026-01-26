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
            ORDER BY u.created_at DESC
        ")->fetchAll();
    }

    public function getAllRoles()
    {
        return $this->db->query("SELECT * FROM roles")->fetchAll();
    }

    public function createUser($name, $email, $roleId, $passwordRaw, $identifier = null)
    {
        $hash = password_hash($passwordRaw, PASSWORD_BCRYPT);
        // Default must_change_password = 1
        return $this->db->query("
            INSERT INTO users (full_name, email, role_id, password_hash, identifier, must_change_password) 
            VALUES (?, ?, ?, ?, ?, 1)
        ", [$name, $email, $roleId, $hash, $identifier]);
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
}
