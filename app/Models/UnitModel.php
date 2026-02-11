<?php

namespace App\Models;

use App\Core\Model;

class UnitModel extends Model
{
    // -- Units --

    public function getUnitById($id)
    {
        return $this->db->query("SELECT * FROM units WHERE id = ?", [$id])->fetch();
    }

    public function updateAssessmentLevel($id, $level)
    {
        // level should be 'Level 4', 'Level 5', or 'Level 6'
        return $this->db->query("UPDATE units SET assessment_level = ? WHERE id = ?", [$level, $id]);
    }

    // -- Topics (Elements) --

    public function getTopics($unitId)
    {
        return $this->db->query("SELECT * FROM unit_topics WHERE unit_id = ? ORDER BY sequence_order ASC", [$unitId])->fetchAll();
    }

    public function addTopic($unitId, $title, $weight, $order = 1)
    {
        return $this->db->query("
            INSERT INTO unit_topics (unit_id, title, weight_percentage, sequence_order) 
            VALUES (?, ?, ?, ?)
        ", [$unitId, $title, $weight, $order]);
    }

    public function updateTopic($id, $title, $weight, $order)
    {
        return $this->db->query("
            UPDATE unit_topics SET title=?, weight_percentage=?, sequence_order=? WHERE id=?
        ", [$title, $weight, $order, $id]);
    }

    public function deleteTopic($id)
    {
        return $this->db->query("DELETE FROM unit_topics WHERE id = ?", [$id]);
    }

    public function getTotalWeight($unitId)
    {
        $result = $this->db->query("SELECT SUM(weight_percentage) as total FROM unit_topics WHERE unit_id = ?", [$unitId])->fetch();
        return $result['total'] ?? 0;
    }

    public function getAssessmentSlots($unitId)
    {
        return $this->db->query("SELECT * FROM assessment_slots WHERE unit_id = ? ORDER BY id ASC", [$unitId])->fetchAll();
    }
}
