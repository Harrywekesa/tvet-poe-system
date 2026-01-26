<?php
require_once __DIR__ . '/../../app/init.php';
require_once __DIR__ . '/../../app/Core/Database.php';

$db = \App\Core\Database::getInstance();

echo "Running Migration: IV Tables...\n";

// 1. Add verification_status to poe_submissions
try {
    $db->query("ALTER TABLE poe_submissions ADD COLUMN verification_status VARCHAR(50) DEFAULT NULL");
    echo "- Added verification_status column to poe_submissions.\n";
} catch (PDOException $e) {
    echo "- verification_status column likely exists (Error: " . $e->getMessage() . ")\n";
}

// 2. Create poe_reviews table
try {
    $db->query("
        CREATE TABLE IF NOT EXISTS poe_reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            submission_id INT NOT NULL,
            reviewer_user_id INT NOT NULL,
            role_at_time VARCHAR(50),
            decision VARCHAR(50),
            comments TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (submission_id) REFERENCES poe_submissions(id) ON DELETE CASCADE,
            FOREIGN KEY (reviewer_user_id) REFERENCES users(id)
        ) ENGINE=InnoDB;
    ");
    echo "- Created poe_reviews table.\n";
} catch (PDOException $e) {
    echo "- Error creating poe_reviews: " . $e->getMessage() . "\n";
}

echo "Done.\n";
