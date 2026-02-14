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
    private $institutionModel;

    public function __construct()
    {
        $this->ensureAuthenticated();
        $this->marksModel = new MarksModel();
        $this->unitModel = new UnitModel();
        $this->reportModel = new ReportModel();
        $this->academicModel = new AcademicModel();
        $this->institutionModel = new \App\Models\InstitutionModel();
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

        // Check Marksheet Status (Approvals)
        $statusRecord = $this->marksModel->getMarksheetStatus($classData['id'], $unitId);
        $isApproved = ($statusRecord && $statusRecord['status'] === 'IQS_Approved');

        $this->view('marks/student_view', [
            'unit' => $unitData,
            'class' => $classData,
            'totals' => $totals,
            'isApproved' => $isApproved,
            'statusRecord' => $statusRecord
        ]);
    }

    public function print_result($unitId)
    {
        // Student Result Slip
        $studentId = $_SESSION['user_id'];

        // 1. Get Progress (Class/Unit context)
        $progress = $this->reportModel->getStudentProgress($studentId);
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

        if (!$unitData)
            die("Unit not found.");

        // 2. Check Status
        $statusRecord = $this->marksModel->getMarksheetStatus($classData['id'], $unitId);
        if (!$statusRecord || $statusRecord['status'] !== 'IQS_Approved') {
            die("Result slip not available yet. Pending IQS Approval.");
        }

        // 3. Get Marks & Totals
        // Re-fetch marks (cleanest way)
        $marks = $this->marksModel->getMarksForStudent($studentId, $unitId);
        $marksMap = [];
        foreach ($marks as $m) {
            $marksMap[$m['assessment_slot_id']] = $m['marks_obtained'];
        }
        foreach ($unitData['assessments'] as &$slot) {
            $slot['mark'] = $marksMap[$slot['id']] ?? '-';
        }

        $calculator = new \App\Services\MarksCalculator($this->unitModel, $this->marksModel);
        $totals = $calculator->calculateUnitTotal($unitId, $studentId);

        // 4. Get Institution Details
        $inst = $this->institutionModel->getInstitutionDetails();

        // 5. Get User Details (Full Name etc)
        $userModel = new \App\Models\UserModel();
        $student = $userModel->getUserById($studentId);

        $type = $_GET['type'] ?? 'raw';

        $this->view('marks/student_result_slip', [
            'student' => $student,
            'unit' => $unitData,
            'class' => $classData,
            'totals' => $totals,
            'statusRecord' => $statusRecord,
            'inst' => $inst,
            'type' => $type
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

    public function transcript($studentId = null)
    {
        // Default to current user if student
        if (!$studentId && ($_SESSION['role'] ?? '') === 'Student') {
            $studentId = $_SESSION['user_id'];
        }

        if (!$studentId) {
            die("Student ID required.");
        }

        // Security: Only Admin, HOD, or the Student themselves can view
        $isSelf = ($_SESSION['user_id'] == $studentId);
        $isAdmin = ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'HOD'); // Maybe IQS too?
        if (!$isSelf && !$isAdmin) {
            die("Unauthorized access.");
        }

        $type = $_GET['type'] ?? 'raw'; // 'raw' or 'weighted'

        // Get Student details
        $userModel = new \App\Models\UserModel();
        $student = $userModel->getUserById($studentId);

        // Get Units
        $units = $this->academicModel->getStudentUnits($studentId);

        $results = [];
        $course = null;

        $calculator = new \App\Services\MarksCalculator($this->unitModel, $this->marksModel);

        foreach ($units as $u) {
            if (!$course && isset($u['course_title'])) {
                $course = ['title' => $u['course_title']];
            }

            // Calculate score
            // Note: calculateUnitTotal logic handles Raw vs Weighted internally? 
            // No, calculateUnitTotal returns the WEIGHTED 'final_mark' and 'topics' structure.
            // It does NOT explicitly return a 'Raw' average of all assessments. 
            // The 'raw' mode in result slip just sums the marks? No, it lists them.
            // For a Transcript 'Raw' request: "It should only show the final mark".
            // If Type is Raw: Sum of all marks / Total Marks? Or Average?
            // Usually "Raw Mark" for a unit = Sum of marks obtained / Sum of max marks * 100.
            // But Slots don't have max marks in DB (assumed 100).
            // So Average of all assessments? 

            $calRes = $calculator->calculateUnitTotal($u['id'], $studentId);

            $finalMark = 0;
            if ($type == 'weighted') {
                $finalMark = $calRes['final_mark']; // This is the weighted contribution sum
            } else {
                // Raw Calculation: Average of all slots?
                // Let's use the 'topics' data from calculator to find all slots
                $totalMark = 0;
                $count = 0;
                foreach ($calRes['topics'] as $t) {
                    foreach ($t['slots'] as $s) {
                        if ($s['mark'] !== '-' && is_numeric($s['mark'])) {
                            $totalMark += $s['mark'];
                            $count++;
                        }
                    }
                }
                $finalMark = ($count > 0) ? ($totalMark / $count) : 0;
            }

            $results[] = [
                'unit_code' => $u['unit_code'],
                'unit_title' => $u['unit_title'],
                'mark' => number_format($finalMark, 0) . '%'
            ];
        }

        // Get Institution Details
        $inst = $this->institutionModel->getInstitutionDetails();

        $this->view('marks/transcript', [
            'student' => $student,
            'results' => $results,
            'inst' => $inst,
            'type' => $type,
            'course' => $course
        ]);
    }

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

        // Get Institution Details (replacing hardcoded)
        $inst = $this->institutionModel->getInstitutionDetails();

        $this->view('marks/marksheet_print', [
            'unit' => $unit,
            'class' => $class,
            'students' => $students,
            'results' => $studentResults,
            'status' => $status,
            'statusRecord' => $statusRecord,
            'type' => $type,
            'writtenSlots' => $writtenSlots,
            'practicalSlots' => $practicalSlots,
            'inst' => $inst
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

        // Security Check: Ensure session role matches action role
        if ($role === 'HOD' && ($_SESSION['role'] !== 'HOD' && $_SESSION['role'] !== 'Admin')) {
            $_SESSION['flash_error'] = 'Unauthorized: HOD access required.';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
        if ($role === 'IQS' && ($_SESSION['role'] !== 'InternalVerifier' && $_SESSION['role'] !== 'Admin')) {
            $_SESSION['flash_error'] = 'Unauthorized: IQS access required.';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

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
        $role = $_SESSION['role'];
        $all = $this->marksModel->getAllApprovals($role);

        $pending = [];
        $history = [];

        foreach ($all as $item) {
            $isPending = false;
            // Define what is "Pending" for this user
            if ($role === 'HOD' && $item['status'] == 'Submitted_to_HOD') {
                $isPending = true;
            } elseif ($role === 'InternalVerifier' && $item['status'] == 'HOD_Approved') {
                $isPending = true;
            }

            if ($isPending) {
                $pending[] = $item;
            } else {
                $history[] = $item;
            }
        }

        $this->view('marks/approvals', [
            'pending' => $pending,
            'history' => $history
        ]);
    }
}
