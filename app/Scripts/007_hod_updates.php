<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Core/Database.php';

$db = \App\Core\Database::getInstance();

echo "Running Migration: HOD & Professional Docs...\n";

// 1. Add department_id to users
try {
    $db->query("ALTER TABLE users ADD COLUMN department_id INT NULL DEFAULT NULL");
    echo "- Added department_id to users.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "- department_id already exists.\n";
    } else {
        echo "Error adding col: " . $e->getMessage() . "\n";
    }
}

// 2. Create professional_documents table
try {
    $sql = "CREATE TABLE IF NOT EXISTS professional_documents (
        id INT AUTO_INCREMENT PRIMARY KEY,
        trainer_user_id INT NOT NULL,
        unit_id INT NOT NULL,
        class_id INT NOT NULL,
        type VARCHAR(50) NOT NULL, -- 'Course Outline', 'Attendance', etc.
        file_path VARCHAR(255) NOT NULL,
        status VARCHAR(20) DEFAULT 'Pending', -- 'Pending', 'Approved', 'Rejected'
        comments TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (trainer_user_id) REFERENCES users(id),
        FOREIGN KEY (unit_id) REFERENCES units(id),
        FOREIGN KEY (class_id) REFERENCES classes(id)
    )";
    $db->query($sql);
    echo "- Created professional_documents table.\n";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
}

echo "Done.\n";
