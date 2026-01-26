<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../../config/config.php';

use App\Core\Database;

$db = Database::getInstance();

echo "Adding file_path to assessment_slots table...\n";

try {
    $db->getConnection()->exec("ALTER TABLE assessment_slots ADD COLUMN file_path VARCHAR(255) NULL AFTER instructions");
    echo "- Added file_path column.\n";
} catch (\PDOException $e) {
    echo "- Column likely exists or error: " . $e->getMessage() . "\n";
}

echo "Done.\n";
