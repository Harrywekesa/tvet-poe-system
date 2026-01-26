<?php
require_once __DIR__ . '/app/Core/Database.php';

$db = \App\Core\Database::getInstance();

echo "Checking poe_submissions columns:\n";
try {
    $cols = $db->query("DESCRIBE poe_submissions")->fetchAll();
    foreach ($cols as $c) {
        echo "- " . $c['Field'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nChecking poe_reviews table:\n";
try {
    $cols = $db->query("DESCRIBE poe_reviews")->fetchAll();
    foreach ($cols as $c) {
        echo "- " . $c['Field'] . "\n";
    }
} catch (Exception $e) {
    echo "Error (likely table missing): " . $e->getMessage() . "\n";
}
