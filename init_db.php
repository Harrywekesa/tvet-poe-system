<?php
// init_db.php (Run from CLI)

require_once 'app/Core/DatabaseManager.php';

use App\Core\DatabaseManager;

$db = new DatabaseManager();

echo "Initializing Database...\n";
$db->initDatabase();

echo "Running Migrations...\n";
$db->runMigrations(__DIR__ . '/sql');

echo "Done.\n";
