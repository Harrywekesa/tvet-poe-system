<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\MarksModel;
use App\Models\UnitModel;
use App\Models\AcademicModel;
use App\Models\ReportModel; // To get student progress/POEs

class MarksController extends Controller
{
    private $marksModel;
    private $unitModel;
    private $reportModel;
    private $academicModel;

    public function __construct()
    {
        $this->ensureAuthenticated();
        $this->marksModel = new MarksModel();
        $this->unitModel = new UnitModel();
        $this->reportModel = new ReportModel();
        $this->academicModel = new AcademicModel();
    }

    // ... constructor ...

    public function my_marks($unitId)
    {
        $studentId = $_SESSION['user_id'];

        // We need to know which class the student is in for this unit.
        // ReportModel->getStudentProgress finds enrollments.
        // But units are course-wide. A student is enrolled in a class of that course.

        $progress = $this->reportModel->getStudentProgress($studentId);
        // Iterate to find the unit and the class
        $unitData = null;
        $classData = null;

        foreach ($progress as $c) {
            foreach ($c['units'] as $u) {
                if ($u['id'] == $unitId) {
                    $unitData = $u;
                    $classData = $c;
                    break 2;
                }
            }
        }

        if (!$unitData) {
            die("Unit not found or not enrolled.");
        }

        // Get Marks from DB to supplement ReportModel (which might only have submission status)
        // ReportModel getStudentProgress doesn't seem to fetch 'marks_obtained' from student_marks table yet?
        // Let's check ReportModel... It fetches `poe_submissions` status but NOT `student_marks`.
        // So we need to fetch marks separately or update ReportModel.
        // Let's fetch separately here.

        $marks = $this->marksModel->getMarksForStudent($studentId, $unitId);
        $marksMap = [];
        foreach ($marks as $m) {
            $marksMap[$m['assessment_slot_id']] = $m['marks_obtained'];
        }

        // Merge marks into unitData assessments
        foreach ($unitData['assessments'] as &$slot) {
            $slot['mark'] = $marksMap[$slot['id']] ?? '-';
        }

        // Calculate Totals (Calculator Logic)
        $calculator = new \App\Services\MarksCalculator($this->unitModel, $this->marksModel); // We'll create this Service
        $totals = $calculator->calculateUnitTotal($unitId, $studentId);

        $this->view('marks/student_view', [
            'unit' => $unitData,
            'class' => $classData,
            'totals' => $totals
        ]);
    }

    public function grade_student($unitId, $classId, $studentId)
    {
        // 1. Get Unit & Class Details
        $unit = $this->unitModel->getUnitById($unitId);
        $class = $this->academicModel->getClassById($classId);

        // Handle entry from Dashboard where studentId might be 0
        if ($studentId == 0) {
            $students = $this->academicModel->getEnrolledStudents($classId);
            if (!empty($students)) {
                $this->redirect("/marks/grade/$unitId/$classId/" . $students[0]['id']);
            } else {
                die("No students enrolled in this class.");
            }
        }

        // 2. Get Student Details
        // We can reuse getUserById from a User model, or ReportModel usually fetches user details
        // Let's just fetch basic user info. I'll use direct DB in model or add a method.
        // For now, let's use a quick query or assume passed. 
        // Better: use ReportModel->getStudentProgress which fetches deeply.

        $progress = $this->reportModel->getStudentProgress($studentId, $classId);
        // getStudentProgress returns array of Classes. We filtered by classId so index 0 is our class.
        $studentUnitData = null;
        if (!empty($progress) && isset($progress[0]['units'])) {
            foreach ($progress[0]['units'] as $u) {
                if ($u['id'] == $unitId) {
                    $studentUnitData = $u;
                    break;
                }
            }
        }

        // 3. Get Topics (Elements) & Assessment Slots
        $topics = $this->unitModel->getTopics($unitId);

        // 4. Get Existing Marks
        $existingMarks = $this->marksModel->getMarksForStudent($studentId, $unitId);
        // Index marks by slot_id for easy lookup
        $marksBySlot = [];
        foreach ($existingMarks as $m) {
            $marksBySlot[$m['assessment_slot_id']] = $m['marks_obtained'];
        }

        // 5. Structure data for View
        // We want to group Assessments by Topic
        $gradingMatrix = [];

        // Initializing with Topics
        foreach ($topics as $t) {
            $gradingMatrix[$t['id']] = [
                'topic' => $t,
                'slots' => []
            ];
        }
        $gradingMatrix[0] = ['topic' => ['title' => 'General (No Topic)', 'weight_percentage' => 0], 'slots' => []]; // For unassigned

        // Place slots into matrix
        if ($studentUnitData) {
            foreach ($studentUnitData['assessments'] as $slot) {
                $tId = $slot['topic_id'] ?? 0;
                if (!isset($gradingMatrix[$tId]))
                    $tId = 0; // fallback

                // Inject existing mark
                $slot['mark'] = $marksBySlot[$slot['id']] ?? '';

                $gradingMatrix[$tId]['slots'][] = $slot;
            }
        }

        $this->view('marks/grade_student', [
            'unit' => $unit,
            'class' => $class,
            'studentId' => $studentId,
            'studentName' => $progress['student_name'] ?? 'Student', // ReportModel might need adjustment to return name at top level
            'matrix' => $gradingMatrix,
            'totalWeight' => $this->unitModel->getTotalWeight($unitId)
        ]);
    }

    public function save_marks()
    {
        $unitId = $_POST['unit_id'];
        $classId = $_POST['class_id'];
        $studentId = $_POST['student_id'];
        $marks = $_POST['marks']; // array of slot_id -> value

        foreach ($marks as $slotId => $val) {
            if ($val !== '') {
                $this->marksModel->saveMark($studentId, $slotId, $val, $_SESSION['user_id']);
            }
        }

        $_SESSION['flash_success'] = 'Marks saved successfully.';
        $this->redirect("/marks/grade/$unitId/$classId/$studentId");
    }

    // -- Marksheets & Approvals --

    public function marksheet($unitId, $classId)
    {
        // View Marksheet (Brings up print view)
        // Check Status
        $statusRecord = $this->marksModel->getMarksheetStatus($classId, $unitId);
        $status = $statusRecord['status'] ?? 'Draft'; // Default

        // Type: 'raw' or 'weighted'. Default 'raw'
        $type = $_GET['type'] ?? 'raw';

        // Get Unit/Class info
        $unit = $this->unitModel->getUnitById($unitId);
        $class = $this->academicModel->getClassById($classId);

        // Get Students
        $students = $this->academicModel->getEnrolledStudents($classId);

        // Get Unit Topics & Assessments details structure for the header columns
        // We need to know specific assessment slots to build columns
        // Let's fetch the full structure (Topics -> Slots)
        $topics = $this->unitModel->getTopics($unitId);
        // We need slots for each topic. 
        // A better way: Fetch ALL slots for this unit, then group by Type (Written / Practical) as per DCS layout
        // DCS Layout: Written Columns | Practical Columns.
        // Let's fetch all slots
        $allSlots = $this->unitModel->getAssessmentSlots($unitId);

        $writtenSlots = [];
        $practicalSlots = [];
        foreach ($allSlots as $slot) {
            if ($slot['type'] === 'Written') {
                $writtenSlots[] = $slot;
            } else {
                $practicalSlots[] = $slot;
            }
        }

        // Get Calculator
        $calculator = new \App\Services\MarksCalculator($this->unitModel, $this->marksModel);

        // Calculate for ALL students
        $studentResults = [];
        foreach ($students as $student) {
            $studentResults[$student['id']] = $calculator->calculateUnitTotal($unitId, $student['id']);
        }

        $this->view('marks/marksheet_print', [
            'unit' => $unit,
            'class' => $class,
            'students' => $students,
            'results' => $studentResults,
            'status' => $status,
            'statusRecord' => $statusRecord,
            'type' => $type,
            'writtenSlots' => $writtenSlots,
            'practicalSlots' => $practicalSlots
        ]);
    }

    public function submit_marksheet()
    {
        // Trainer Action: Submit to HOD
        $unitId = $_POST['unit_id'];
        $classId = $_POST['class_id'];
        $trainerId = $_SESSION['user_id'];

        $this->marksModel->initMarksheet($classId, $unitId, $trainerId);

        $this->redirect("/marks/marksheet/$unitId/$classId");
    }

    public function update_status()
    {
        // HOD/IQS Action
        $id = $_POST['id']; // marksheet_status id
        $action = $_POST['action']; // approve / reject
        $comments = $_POST['comments'];
        $role = $_POST['role']; // HOD or IQS

        // Determine new status
        $newStatus = '';
        if ($role == 'HOD') {
            $newStatus = ($action == 'approve') ? 'HOD_Approved' : 'HOD_Rejected';
        } elseif ($role == 'IQS') {
            $newStatus = ($action == 'approve') ? 'IQS_Approved' : 'IQS_Rejected';
        }

        $this->marksModel->updateMarksheetStatus($id, $newStatus, $comments, $_SESSION['user_id'], $role);

        // Redirect back (using referer is easiest)
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }

    public function approvals()
    {
        // List pending approvals for HOD/IQS
        // We'll show ALL for now, filter in view?
        $pending = $this->marksModel->getPendingApprovals();
        $this->view('marks/approvals', ['pending' => $pending]);
    }
}
