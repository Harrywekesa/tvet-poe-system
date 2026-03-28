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
        $hasMarks = false;
        foreach ($unitData['assessments'] as &$slot) {
            $slot['mark'] = $marksMap[$slot['id']] ?? '-';
            if ($slot['mark'] !== '-' && $slot['mark'] !== '') {
                $hasMarks = true;
            }
        }

        // Calculate Totals (Calculator Logic)
        $calculator = new \App\Services\MarksCalculator($this->unitModel, $this->marksModel); // We'll create this Service
        $totals = $calculator->calculateUnitTotal($unitId, $studentId);

        // Check Marksheet Status (Approvals)
        $statusRecord = $this->marksModel->getMarksheetStatus($classData['id'], $unitId);
        // Only show as Approved if the Class is Approved AND the Student has actual marks
        $isApproved = ($statusRecord && $statusRecord['status'] === 'IQS_Approved' && $hasMarks);

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

        // 1. Get Existing Marks for comparison
        $existingMarks = $this->marksModel->getMarksForStudent($studentId, $unitId);
        $oldMarks = [];
        foreach ($existingMarks as $m) {
            $oldMarks[$m['assessment_slot_id']] = $m['marks_obtained'];
        }

        $changes = [];

        foreach ($marks as $slotId => $val) {
            // 1. Process Trainer Uploads
            if (isset($_FILES['evidence']['name'][$slotId]) && $_FILES['evidence']['error'][$slotId] === UPLOAD_ERR_OK) {
                // Spoof $_FILES array format for UploadService
                $_FILES['tmp_trainer_upload'] = [
                    'name' => $_FILES['evidence']['name'][$slotId],
                    'type' => $_FILES['evidence']['type'][$slotId],
                    'tmp_name' => $_FILES['evidence']['tmp_name'][$slotId],
                    'error' => $_FILES['evidence']['error'][$slotId],
                    'size' => $_FILES['evidence']['size'][$slotId]
                ];
                
                $result = \App\Services\UploadService::handleUpload('tmp_trainer_upload', '', ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']);
                
                if ($result['success']) {
                    $this->marksModel->submitEvidenceTrainer($studentId, $slotId, $result['filename'], $result['extension'], $_SESSION['user_id']);
                    $changes[] = "Slot #$slotId Evidence Uploaded";
                } else {
                    $_SESSION['flash_error'] = "File upload failed for Slot #$slotId: " . $result['error'];
                }
            }

            // 2. Process Marks
            if ($val !== '') {
                $oldVal = $oldMarks[$slotId] ?? 'Not Graded';
                // Only log if changed
                if ((string) $oldVal !== (string) $val) {
                    $this->marksModel->saveMark($studentId, $slotId, $val, $_SESSION['user_id']);
                    $changes[] = "Slot #$slotId: $oldVal -> $val";
                }
            }
        }

        if (!empty($changes)) {
            $changeLog = implode(", ", $changes);
            \App\Core\Audit::log('Marks Updated', "Student $studentId, Unit $unitId (Class $classId). Changes: $changeLog");
            $_SESSION['flash_success'] = 'Marks saved successfully.';

            // Email Notification
            $userModel = new \App\Models\UserModel();
            $studentInfo = $userModel->getUserById($studentId);
            if ($studentInfo && !empty($studentInfo['email'])) {
                $subject = "CBET POE: Your Marks have been updated";
                $message = "<p>Hello " . htmlspecialchars($studentInfo['name']) . ",</p>";
                $message .= "<p>Your trainer has updated your marks or uploaded evidence on your behalf for Unit ID: $unitId.</p>";
                $message .= "<p>Log in to your dashboard to view your progress.</p>";
                \App\Services\EmailService::send($studentInfo['email'], $subject, $message);
            }
        } else {
            $_SESSION['flash_success'] = 'No changes made.';
        }
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

        // Get Data
        $data = $this->getTranscriptData($studentId, $type);

        $this->view('marks/transcript', [
            'student' => $data['student'],
            'results' => $data['results'],
            'course' => $data['course'],
            'inst' => $this->institutionModel->getInstitutionDetails(),
            'type' => $type
        ]);
    }

    public function bulk_transcript($classId)
    {
        // Admin/HOD Only
        if (!in_array($_SESSION['role'], ['Admin', 'HOD', 'InternalVerifier'])) {
            die("Unauthorized.");
        }

        $type = $_GET['type'] ?? 'raw';
        $class = $this->academicModel->getClassById($classId);
        $students = $this->academicModel->getEnrolledStudents($classId);
        $inst = $this->institutionModel->getInstitutionDetails();

        $allData = [];
        foreach ($students as $s) {
            $tData = $this->getTranscriptData($s['id'], $type);
            // Verify student belongs to this class context? 
            // getTranscriptData fetches ALL units for student. 
            // Ideally we should filter units belonging to THIS course/class if student is in multiple?
            // For now, assuming student is in one active course/class or we want full history.
            // Given the request is "Whole Class Transcript", usually implies the specific Course Transcripts.
            // Current getTranscriptData gets ALL units. That's fine for now.

            // Add to list
            $allData[] = $tData;
        }

        $this->view('marks/bulk_transcript', [
            'class' => $class,
            'allData' => $allData,
            'inst' => $inst,
            'type' => $type
        ]);
    }

    private function getTranscriptData($studentId, $type)
    {
        $userModel = new \App\Models\UserModel();
        $student = $userModel->getUserById($studentId);
        $units = $this->academicModel->getStudentUnits($studentId);
        $calculator = new \App\Services\MarksCalculator($this->unitModel, $this->marksModel);

        $results = [];
        $course = null;

        foreach ($units as $u) {
            if (!$course && isset($u['course_title'])) {
                $course = ['title' => $u['course_title']];
            }

            $calRes = $calculator->calculateUnitTotal($u['id'], $studentId);
            $finalMark = 0;

            if ($type == 'weighted') {
                $finalMark = $calRes['final_mark'];
            } else {
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

        return [
            'student' => $student,
            'results' => $results,
            'course' => $course
        ];
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

    public function class_transcripts($classId)
    {
        // Admin/HOD/Trainer/IV access
        if (!in_array($_SESSION['role'], ['Admin', 'HOD', 'Trainer', 'InternalVerifier'])) {
            die("Unauthorized.");
        }

        $class = $this->academicModel->getClassById($classId);
        $students = $this->academicModel->getEnrolledStudents($classId);
        $inst = $this->institutionModel->getInstitutionDetails();
        $allClasses = $this->academicModel->getAllClasses();

        if ($_SESSION['role'] === 'HOD') {
            $userModel = new \App\Models\UserModel();
            $deptId = $userModel->getUserDepartment($_SESSION['user_id']);
            $courses = $this->institutionModel->getCoursesByDept($deptId);
            
            $courseIds = array_column($courses, 'id');
            $filteredClasses = [];
            foreach ($allClasses as $c) {
                if (in_array($c['course_id'], $courseIds)) {
                    $filteredClasses[] = $c;
                }
            }
            $allClasses = $filteredClasses;

            // Enforce access control
            if (!in_array($class['course_id'], $courseIds)) {
                die("Unauthorized: Class does not belong to your department.");
            }
        }

        $this->view('marks/class_transcripts', [
            'class' => $class,
            'students' => $students,
            'inst' => $inst,
            'allClasses' => $allClasses
        ]);
    }

    public function transcripts_hub()
    {
        // Admin/HOD/Trainer/IV
        if (!in_array($_SESSION['role'], ['Admin', 'HOD', 'Trainer', 'InternalVerifier'])) {
            die("Unauthorized.");
        }

        $cohorts = $this->academicModel->getAllCohorts();
        // Get all classes grouped by cohort or just list them
        // For simplicity, let's just get all classes and we can filter in view or controller
        $classes = $this->academicModel->getAllClasses();

        if ($_SESSION['role'] === 'HOD') {
            $userModel = new \App\Models\UserModel();
            $deptId = $userModel->getUserDepartment($_SESSION['user_id']);
            $courses = $this->institutionModel->getCoursesByDept($deptId);
            
            $courseIds = array_column($courses, 'id');
            $filteredClasses = [];
            foreach ($classes as $c) {
                if (in_array($c['course_id'], $courseIds)) {
                    $filteredClasses[] = $c;
                }
            }
            $classes = $filteredClasses;
        }

        $this->view('marks/transcripts_hub', [
            'classes' => $classes,
            'cohorts' => $cohorts
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

        // Fetch Marksheet details to notify Trainer
        $marksheet = $this->marksModel->getMarksheetById($id);
        if ($marksheet && $marksheet['submitted_by']) {
            $userModel = new \App\Models\UserModel();
            $trainer = $userModel->getUserById($marksheet['submitted_by']);
            if ($trainer && !empty($trainer['email'])) {
                $subject = "CBET POE: Marksheet Status Updated";
                $message = "<p>Hello " . htmlspecialchars($trainer['name']) . ",</p>";
                $message .= "<p>The status of your submitted marksheet has been updated to <strong>$newStatus</strong> by the $role.</p>";
                if (!empty($comments)) {
                    $message .= "<p><strong>Comments:</strong> " . htmlspecialchars($comments) . "</p>";
                }
                \App\Services\EmailService::send($trainer['email'], $subject, $message);
            }
        }

        // Redirect back (using referer is easiest)
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }

    public function approvals()
    {
        $role = $_SESSION['role'];
        $deptId = null;
        if ($role === 'HOD') {
            $userModel = new \App\Models\UserModel();
            $deptId = $userModel->getUserDepartment($_SESSION['user_id']);
        }
        $all = $this->marksModel->getAllApprovals($role, $deptId);

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
