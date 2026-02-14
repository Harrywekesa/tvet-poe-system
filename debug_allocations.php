<?php
require_once __DIR__ . '/public/init_db.php';
$db = \App\Core\Database::getInstance();

echo "--- Users (Role: InternalVerifier) ---\n";
$ivs = $db->query("SELECT id, full_name, role_id FROM users WHERE role_id = (SELECT id FROM roles WHERE name='InternalVerifier')")->fetchAll();
print_r($ivs);

echo "\n--- Unit Allocations ---\n";
$allocs = $db->query("
    SELECT ua.*, u.full_name as verifier_name, un.unit_title 
    FROM unit_allocations ua 
    LEFT JOIN users u ON ua.verifier_user_id = u.id
    LEFT JOIN units un ON ua.unit_id = un.id
")->fetchAll();
print_r($allocs);

echo "\n--- All Units ---\n";
$units = $db->query("SELECT id, unit_title FROM units LIMIT 5")->fetchAll();
print_r($units);
