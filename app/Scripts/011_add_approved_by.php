<?php
require_once __DIR__ . '/../../public/index.php';

use App\Core\Database;

$db = new Database();
$conn = $db->connect();

try {
    $conn->exec("ALTER TABLE professional_documents ADD COLUMN approved_by INT NULL DEFAULT NULL");
    echo "Column 'approved_by' added successfully.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "Duplicate column name") !== false) {
        echo "Column 'approved_by' already exists.\n";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
