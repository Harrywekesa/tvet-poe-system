<?php

namespace App\Models;

use App\Core\Model;

class InstitutionModel extends Model
{

    public function getInstitutionDetails()
    {
        return $this->db->query("SELECT * FROM institution LIMIT 1")->fetch();
    }

    public function updateInstitution($name, $code, $address, $systemName, $email, $phone, $about, $logoPath = null, $heroPath = null)
    {
        // Upsert
        $sql = "
            INSERT INTO institution (id, name, tvet_code, address, system_name, contact_email, contact_phone, about_text, logo_path, hero_image_path) 
            VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE 
                name=?, tvet_code=?, address=?, system_name=?, contact_email=?, contact_phone=?, about_text=?
        ";
        $params = [$name, $code, $address, $systemName, $email, $phone, $about, $logoPath, $heroPath, $name, $code, $address, $systemName, $email, $phone, $about];

        if ($logoPath) {
            $sql .= ", logo_path=?";
            $params[] = $logoPath;
        }
        if ($heroPath) {
            $sql .= ", hero_image_path=?";
            $params[] = $heroPath;
        }

        return $this->db->query($sql, $params);
    }

    public function getAllDepartments()
    {
        return $this->db->query("SELECT d.*, u.full_name as head_name FROM departments d LEFT JOIN users u ON d.head_user_id = u.id")->fetchAll();
    }

    public function addDepartment($name)
    {
        return $this->db->query("INSERT INTO departments (name) VALUES (?)", [$name]);
    }

    public function getCoursesByDept($deptId)
    {
        return $this->db->query("SELECT * FROM courses WHERE department_id = ?", [$deptId])->fetchAll();
    }

    public function addCourse($title, $code, $deptId, $level)
    {
        return $this->db->query("INSERT INTO courses (title, code, department_id, level) VALUES (?, ?, ?, ?)", [$title, $code, $deptId, $level]);
    }

    public function getCourseById($id)
    {
        return $this->db->query("SELECT * FROM courses WHERE id = ?", [$id])->fetch();
    }

    public function updateCourse($id, $title, $code, $level, $deptId)
    {
        return $this->db->query("
            UPDATE courses SET title=?, code=?, level=?, department_id=? 
            WHERE id=?
        ", [$title, $code, $level, $deptId, $id]);
    }

    public function getUnitsByCourse($courseId)
    {
        return $this->db->query("SELECT * FROM units WHERE course_id = ? ORDER BY sequence_order ASC, unit_code ASC", [$courseId])->fetchAll(); // Assumes sequence_order col exists? Check schema. 
        // Schema checks: units table: id, unit_code, unit_title, category, course_id, description. No sequence_order in migration 001. Removing order by sequence.
    }

    // Corrected query without sequence_order
    public function getUnitsByCourseSafe($courseId)
    {
        return $this->db->query("SELECT * FROM units WHERE course_id = ? ORDER BY unit_code ASC", [$courseId])->fetchAll();
    }

    public function addUnit($courseId, $code, $title, $category, $desc)
    {
        $this->db->query("INSERT INTO units (course_id, unit_code, unit_title, category, description) VALUES (?, ?, ?, ?, ?)", [$courseId, $code, $title, $category, $desc]);
        return $this->db->getConnection()->lastInsertId();
    }

    public function getUnitById($id)
    {
        return $this->db->query("SELECT * FROM units WHERE id = ?", [$id])->fetch();
    }

    public function updateUnit($id, $code, $title, $category, $desc)
    {
        return $this->db->query("UPDATE units SET unit_code=?, unit_title=?, category=?, description=? WHERE id=?", [$code, $title, $category, $desc, $id]);
    }
}
