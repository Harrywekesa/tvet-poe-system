<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../../config/config.php';

use App\Core\Database;

$db = Database::getInstance();

echo "Adding verification_status to poe_submissions...\n";

try {
    $db->getConnection()->exec("
        ALTER TABLE poe_submissions 
        ADD COLUMN verification_status ENUM('None', 'Sampled', 'Verified', 'IV_Rejected') DEFAULT 'None' AFTER status
    ");
    echo "- Added verification_status column.\n";
} catch (\PDOException $e) {
    echo "- Column likely exists or error: " . $e->getMessage() . "\n";
}

echo "Done.\n";
