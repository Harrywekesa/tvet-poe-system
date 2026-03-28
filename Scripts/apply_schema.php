<?php
require_once __DIR__ . '/../config/config.php';

$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $pdo->exec("ALTER TABLE assessment_slots ADD COLUMN allow_student_uploads TINYINT(1) NOT NULL DEFAULT 1");
    echo "Added allow_student_uploads.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

try {
    $pdo->exec("ALTER TABLE poe_submissions ADD COLUMN uploaded_by INT NULL");
    echo "Added uploaded_by.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

try {
    $pdo->exec("ALTER TABLE poe_submissions ADD CONSTRAINT fk_uploaded_by FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL");
    echo "Added FK.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
