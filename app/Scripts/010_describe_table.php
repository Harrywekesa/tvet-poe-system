<?php
require_once __DIR__ . '/../../public/index.php'; // Correct path to public/index.php from app/Scripts

use App\Core\Database;

$db = new Database();
$conn = $db->connect();

try {
    $stmt = $conn->query("DESCRIBE professional_documents");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
