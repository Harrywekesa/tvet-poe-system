<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Core/Database.php';

$db = \App\Core\Database::getInstance();

echo "Adding must_change_password column to users table...\n";

try {
    $db->query("ALTER TABLE users ADD COLUMN must_change_password TINYINT(1) DEFAULT 0");
    echo "- Added must_change_password column.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "- Column already exists.\n";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "Updating existing users to NOT require change (optional, or set 1 if you want to force everyone)...\n";
// Let's set default to 0 for existing admin, keeping them safe.
// New users created via import will be set to 1.
echo "Done.\n";
