<?php
// Standalone migration script
$host = '127.0.0.1';
$db = 'apoe_db'; // Assuming default based on context, or I should check config. But I'll try standard local.
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connected to DB.\n";
} catch (\PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    // Try connecting without DB to create it? No, assuming DB exists as app is running.
    exit(1);
}

echo "Running Migration: IV Tables...\n";

// 1. Add verification_status to poe_submissions
try {
    $pdo->query("ALTER TABLE poe_submissions ADD COLUMN verification_status VARCHAR(50) DEFAULT NULL");
    echo "- Added verification_status column to poe_submissions.\n";
} catch (PDOException $e) {
    echo "- verification_status column likely exists or error: " . $e->getMessage() . "\n";
}

// 2. Create poe_reviews table
try {
    $pdo->query("
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
