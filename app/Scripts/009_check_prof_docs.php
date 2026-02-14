<?php
require_once __DIR__ . '/../public/index.php';

use App\Core\Database;

$db = new Database();
$conn = $db->connect();

try {
    $conn->query("SELECT 1 FROM professional_documents LIMIT 1");
    echo "Table 'professional_documents' EXISTS.\n";
} catch (PDOException $e) {
    echo "Table 'professional_documents' DOES NOT EXIST. Creating...\n";
    $sql = "
        CREATE TABLE IF NOT EXISTS professional_documents (
            id INT AUTO_INCREMENT PRIMARY KEY,
            trainer_user_id INT NOT NULL,
            unit_id INT NOT NULL,
            class_id INT NOT NULL,
            type VARCHAR(50) NOT NULL,
            file_path VARCHAR(255) NOT NULL,
            status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
            comments TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (trainer_user_id) REFERENCES users(id),
            FOREIGN KEY (unit_id) REFERENCES units(id),
            FOREIGN KEY (class_id) REFERENCES classes(id)
        ) ENGINE=InnoDB;
    ";
    $conn->exec($sql);
    echo "Table created successfully.\n";
}
