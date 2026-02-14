<?php

namespace App\Services;

class MarksCalculator
{
    private $unitModel;
    private $marksModel;

    public function __construct($unitModel, $marksModel)
    {
        $this->unitModel = $unitModel;
        $this->marksModel = $marksModel;
    }

    public function calculateUnitTotal($unitId, $studentId)
    {
        // 1. Get Unit Level & Assessment Weights
        $unit = $this->unitModel->getUnitById($unitId);
        $level = $unit['assessment_level'];

        // Ratios
        $wRatio = 0.4;
        $pRatio = 0.6; // Default Level 6
        if ($level == 'Level 5') {
            $wRatio = 0.3;
            $pRatio = 0.7;
        }
        if ($level == 'Level 4') {
            $wRatio = 0.1;
            $pRatio = 0.9;
        }

        // 2. Get Topics & Their Weights
        $topics = $this->unitModel->getTopics($unitId);
        // Map topic_id -> weight
        $topicWeights = [];
        foreach ($topics as $t) {
            $topicWeights[$t['id']] = $t['weight_percentage'];
        }

        // 3. Get Student Marks
        $marks = $this->marksModel->getMarksForStudent($studentId, $unitId);

        // 4. Group Marks by Topic
        $topicScores = []; // topic_id => ['written' => [], 'practical' => []]

        // Initialize topics + "General" catch-all
        foreach ($topics as $t) {
            $topicScores[$t['id']] = ['written' => 0, 'practical' => 0, 'w_count' => 0, 'p_count' => 0, 'slots' => []];
        }
        // Default "General" topic for slots without a topic
        $topicScores[0] = ['written' => 0, 'practical' => 0, 'w_count' => 0, 'p_count' => 0, 'slots' => []];

        foreach ($marks as $m) {
            $tId = $m['topic_id'];
            // If topic is missing or invalid, assign to General (0)
            if (!$tId || !isset($topicScores[$tId])) {
                $tId = 0;
            }

            $val = floatval($m['marks_obtained']);
            if ($m['type'] == 'Written') {
                $topicScores[$tId]['written'] += $val;
                $topicScores[$tId]['w_count']++;
            } else {
                $topicScores[$tId]['practical'] += $val;
                $topicScores[$tId]['p_count']++;
            }
            // Store slot detail for view mapping
            $topicScores[$tId]['slots'][] = [
                'id' => $m['assessment_slot_id'],
                'mark' => $m['marks_obtained']
            ];
        }

        // 5. Calculate per Topic
        $finalScore = 0;
        $topicResults = [];

        // Include General Topic in iteration if it has data
        $allTopics = $topics;
        if ($topicScores[0]['w_count'] > 0 || $topicScores[0]['p_count'] > 0) {
            $allTopics[] = [
                'id' => 0,
                'title' => 'General / Unassigned',
                'weight_percentage' => 0 // Or should we fallback to remaining weight? For now 0 to avoid skewing unless configured.
            ];
        }

        foreach ($allTopics as $t) {
            $tid = $t['id'];
            $data = $topicScores[$tid];

            // Average? Or Sum?  Usually Average of assessments if multiple in same category? 
            // Or Sum if max_marks not 100?
            // "All assessments use 0-100 scale".
            // So if there are 2 Written exams, we probably average them to get the "Written Component Score".

            $avgW = $data['w_count'] > 0 ? $data['written'] / $data['w_count'] : 0;
            $avgP = $data['p_count'] > 0 ? $data['practical'] / $data['p_count'] : 0;

            // Topic Score = (W * ratio) + (P * ratio)
            // But if one component is missing? "Mandatory Participation".
            // If missing, score is incomplete.

            $topicScore = ($avgW * $wRatio) + ($avgP * $pRatio);

            // Weight this topic adds to Unit Total
            $contribution = $topicScore * (($t['weight_percentage'] ?? 0) / 100);

            $finalScore += $contribution;

            $topicResults[$tid] = [
                'id' => $tid,
                'title' => $t['title'],
                'score' => $topicScore,
                'weight' => $t['weight_percentage'] ?? 0,
                'contribution' => $contribution,
                'is_complete' => ($data['w_count'] > 0 || $wRatio == 0) && ($data['p_count'] > 0 || $pRatio == 0),
                'w_count' => $data['w_count'],
                'p_count' => $data['p_count'],
                'slots' => $data['slots'] ?? []
            ];
        }

        return [
            'final_mark' => $finalScore,
            'topics' => $topicResults,
            'level' => $level,
            'ratios' => ['w' => $wRatio, 'p' => $pRatio]
        ];
    }
}
