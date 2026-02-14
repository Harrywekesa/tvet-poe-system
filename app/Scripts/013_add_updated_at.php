<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'cbet_poe_system');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database.\n";

    echo "Attempting to add 'updated_at' column to 'professional_documents'...\n";

    // Check if column exists
    $stmt = $pdo->prepare("SHOW COLUMNS FROM professional_documents LIKE 'updated_at'");
    $stmt->execute();
    if ($stmt->fetch()) {
        echo "Column 'updated_at' already exists.\n";
    } else {
        // Add updated_at with default NULL, or current timestamp
        $pdo->exec("ALTER TABLE professional_documents ADD COLUMN updated_at DATETIME NULL DEFAULT NULL");
        echo "Column 'updated_at' added successfully.\n";
    }

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
}
