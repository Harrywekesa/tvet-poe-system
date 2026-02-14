<?php

session_start();

require_once __DIR__ . '/../config/config.php';

// Simple Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Router;

$router = new Router();

// -- Define Routes --

// Public Pages
$router->get('/', 'HomeController', 'index');

// Auth
$router->get('/', 'HomeController', 'index');
$router->get('/login', 'AuthController', 'login');
$router->post('/login', 'AuthController', 'loginPost');
$router->get('/logout', 'AuthController', 'logout');
$router->get('/change-password', 'AuthController', 'changePassword');
$router->post('/change-password', 'AuthController', 'changePasswordPost');

// Dashboard (Role Based Redirect)
$router->get('/dashboard', 'DashboardController', 'index');

// Institution Management
$router->get('/institution', 'InstitutionController', 'index');
$router->post('/institution/update', 'InstitutionController', 'updateDetails');
$router->post('/institution/department', 'InstitutionController', 'storeDepartment');
$router->get('/institution/department/{id}', 'InstitutionController', 'viewDepartment');
$router->post('/institution/course', 'InstitutionController', 'storeCourse');
$router->get('/institution/course/edit/{id}', 'InstitutionController', 'editCourse');
$router->post('/institution/course/update', 'InstitutionController', 'updateCourse');
$router->get('/institution/course/{id}', 'InstitutionController', 'viewCourse');
$router->post('/institution/unit', 'InstitutionController', 'storeUnit');
$router->get('/institution/unit/edit/{id}', 'InstitutionController', 'editUnit');
$router->post('/institution/unit/update', 'InstitutionController', 'updateUnit');

// Academic Management (Cohorts/Classes)
$router->get('/academic', 'AcademicController', 'index');
$router->post('/academic/cohort', 'AcademicController', 'storeCohort');
$router->get('/academic/cohort/{id}', 'AcademicController', 'viewCohort');
$router->post('/academic/class', 'AcademicController', 'storeClass');
$router->get('/academic/class/{id}', 'AcademicController', 'viewClass');
$router->post('/academic/enroll', 'AcademicController', 'enrollStudent');
$router->post('/academic/allocate', 'AcademicController', 'allocateUnit');
$router->post('/academic/import_enrollment', 'AcademicController', 'importEnrollment');
$router->get('/academic/template/enrollment', 'AcademicController', 'downloadEnrollmentTemplate');

// Topic Management
$router->get('/unit/topics/{id}', 'TopicController', 'manage');
$router->post('/topic/add', 'TopicController', 'add');
$router->post('/topic/delete/{id}', 'TopicController', 'delete');
$router->post('/unit/update_level', 'TopicController', 'update_level');

// Grading / Marks
$router->get('/marks/grade/{unitId}/{classId}/{studentId}', 'MarksController', 'grade_student');
$router->post('/marks/save', 'MarksController', 'save_marks');
$router->get('/marks/my_view/{unitId}', 'MarksController', 'my_marks');
$router->get('/marks/marksheet/{unitId}/{classId}', 'MarksController', 'marksheet');
$router->post('/marks/submit', 'MarksController', 'submit_marksheet');
$router->post('/marks/status', 'MarksController', 'update_status');
$router->get('/marks/approvals', 'MarksController', 'approvals');
$router->get('/marks/print_result/{unitId}', 'MarksController', 'print_result');
$router->get('/marks/transcript/{studentId}', 'MarksController', 'transcript');


// Institution Imports
$router->post('/institution/import', 'InstitutionController', 'import');
$router->get('/institution/template/{type}', 'InstitutionController', 'downloadTemplate');

// Assessments
$router->get('/assessment/manage/{id}', 'AssessmentController', 'manage');
$router->post('/assessment/store', 'AssessmentController', 'store');
$router->get('/assessment/delete/{id}', 'AssessmentController', 'delete');

// Student POE
$router->get('/poe/dashboard', 'SubmissionController', 'studentDashboard');
$router->get('/poe/class/{id}', 'SubmissionController', 'viewUnitHelper');
$router->get('/poe/unit/{id}', 'SubmissionController', 'viewUnitPOE');
$router->post('/poe/upload', 'SubmissionController', 'upload');
$router->get('/poe/view/{id}', 'SubmissionController', 'viewEvidence');

// Trainer Review
$router->get('/review/unit/{unit_id}/class/{class_id}', 'ReviewController', 'reviewUnit');
$router->post('/review/update', 'ReviewController', 'updateStatus');
$router->post('/review/bulk', 'ReviewController', 'bulkUpdate');

// Verification
$router->get('/verification/list/{unit_id}/class/{class_id}', 'VerificationController', 'listItems');
$router->post('/verification/submit', 'VerificationController', 'submitResult');

// Profile
$router->get('/profile', 'ProfileController', 'index');
$router->post('/profile/update', 'ProfileController', 'update');

// User Management
$router->get('/users', 'UserController', 'index');
$router->post('/users/store', 'UserController', 'store');
$router->get('/users/edit/{id}', 'UserController', 'edit');
$router->post('/users/update', 'UserController', 'update');
$router->get('/users/import', 'UserController', 'importView');
$router->get('/users/template', 'UserController', 'downloadTemplate');
$router->get('/users/import', 'UserController', 'importView');
$router->get('/users/template', 'UserController', 'downloadTemplate');
$router->post('/users/import', 'UserController', 'import');
$router->post('/users/suspend', 'UserController', 'suspend');
$router->get('/users/activate/{id}', 'UserController', 'activate');
$router->get('/users/delete/{id}', 'UserController', 'delete');

// Preview
$router->get('/preview/assessment/{id}', 'PreviewController', 'assessment');
$router->get('/preview/submission/{id}', 'PreviewController', 'submission');
$router->get('/preview/download', 'PreviewController', 'download');
$router->get('/preview/serve', 'PreviewController', 'serve');

// Reports
$router->get('/reports', 'ReportController', 'index');
$router->get('/reports/iv_analytics', 'ReportController', 'ivAnalytics');
$router->get('/reports/dept_overview', 'ReportController', 'deptOverview');
$router->get('/reports/iv_detailed', 'ReportController', 'ivDetailedReport');

// Professional Docs
$router->get('/documents/upload', 'ProfessionalDocController', 'uploadView');
$router->post('/documents/store', 'ProfessionalDocController', 'upload');
$router->get('/documents/review', 'ProfessionalDocController', 'review');
$router->post('/documents/status', 'ProfessionalDocController', 'updateStatus');
$router->get('/documents/certificate/{id}', 'ProfessionalDocController', 'viewCertificate');

// Audit
$router->get('/audit', 'AuditController', 'index');
$router->get('/audit/course', 'AuditController', 'selectCourse');
$router->get('/audit/unit', 'AuditController', 'selectUnit');
$router->get('/audit/workspace', 'AuditController', 'workspace');

// Reviews
$router->get('/review/unit/{unitId}/{classId}', 'ReviewController', 'reviewUnit');
$router->post('/review/status', 'ReviewController', 'updateStatus');
$router->post('/review/verification_update', 'ReviewController', 'updateVerification');
$router->post('/review/verify', 'ReviewController', 'updateVerification');

// -- Dispatch --
$router->dispatch($_SERVER['REQUEST_URI']);
