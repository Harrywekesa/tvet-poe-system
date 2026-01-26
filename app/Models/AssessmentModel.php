<?php

namespace App\Models;

use App\Core\Model;

class AssessmentModel extends Model
{

    public function getAllocatedUnitsForTrainer($trainerId)
    {
        return $this->db->query("
            SELECT u.*, c.class_code, c.id as class_id, co.title as course_title 
            FROM unit_allocations ua 
            JOIN units u ON ua.unit_id = u.id 
            JOIN classes c ON ua.class_id = c.id 
            JOIN courses co ON u.course_id = co.id 
            WHERE ua.trainer_user_id = ?
        ", [$trainerId])->fetchAll();
    }

    public function getAssessmentSlots($unitId)
    {
        return $this->db->query("SELECT * FROM assessment_slots WHERE unit_id = ? ORDER BY sequence_order ASC", [$unitId])->fetchAll();
    }

    public function getSlotById($id)
    {
        return $this->db->query("SELECT * FROM assessment_slots WHERE id = ?", [$id])->fetch();
    }

    public function addAssessmentSlot($unitId, $title, $type, $instructions, $filePath = null)
    {
        return $this->db->query("INSERT INTO assessment_slots (unit_id, title, type, instructions, file_path) VALUES (?, ?, ?, ?, ?)", [$unitId, $title, $type, $instructions, $filePath]);
    }

    public function deleteAssessmentSlot($id)
    {
        return $this->db->query("DELETE FROM assessment_slots WHERE id = ?", [$id]);
    }
}
