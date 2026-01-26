<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../../config/config.php';

use App\Core\Database;

$db = Database::getInstance();

echo "Adding columns to users table...\n";

try {
    $db->getConnection()->exec("ALTER TABLE users ADD COLUMN identifier VARCHAR(50) NULL AFTER email");
    echo "- Added identifier column.\n";
} catch (\PDOException $e) {
    echo "- Identifier column likely exists or error: " . $e->getMessage() . "\n";
}

try {
    $db->getConnection()->exec("ALTER TABLE users ADD COLUMN phone_number VARCHAR(20) NULL AFTER identifier");
    echo "- Added phone_number column.\n";
} catch (\PDOException $e) {
    echo "- Phone_number column likely exists.\n";
}

try {
    $db->getConnection()->exec("ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) NULL AFTER phone_number");
    echo "- Added profile_picture column.\n";
} catch (\PDOException $e) {
    echo "- Profile_picture column likely exists.\n";
}

echo "Done.\n";
