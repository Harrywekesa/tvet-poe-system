<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../../config/config.php';

use App\Core\Database;

$db = Database::getInstance();

echo "Checking poe_submissions table...\n";

// Table Schema
$sql = "
CREATE TABLE IF NOT EXISTS poe_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_user_id INT NOT NULL,
    assessment_slot_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(50) DEFAULT 'pdf',
    status ENUM('Submitted', 'Under Review', 'Approved', 'Rejected') DEFAULT 'Submitted',
    version INT DEFAULT 1,
    submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    ocr_text TEXT NULL,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assessment_slot_id) REFERENCES assessment_slots(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

try {
    $db->getConnection()->exec($sql);
    echo "- Table poe_submissions exists or created.\n";
} catch (\PDOException $e) {
    echo "- Error: " . $e->getMessage() . "\n";
}

// Reviews Table
$sql2 = "
CREATE TABLE IF NOT EXISTS poe_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    submission_id INT NOT NULL,
    reviewer_user_id INT NOT NULL,
    role_at_time VARCHAR(50) NOT NULL,
    decision ENUM('Approved', 'Rejected', 'Request Changes') NOT NULL,
    comments TEXT,
    reviewed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (submission_id) REFERENCES poe_submissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

try {
    $db->getConnection()->exec($sql2);
    echo "- Table poe_reviews exists or created.\n";
} catch (\PDOException $e) {
    echo "- Error: " . $e->getMessage() . "\n";
}

echo "Done.\n";
