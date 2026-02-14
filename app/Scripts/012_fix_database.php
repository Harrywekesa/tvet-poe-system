<?php
// Standalone script to avoid index.php side effects

// 1. Define constants usually in config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'cbet_poe_system');
define('DB_USER', 'root');
define('DB_PASS', '');

// 2. Simple Database connection (bypassing App\Core\Database to be safe and simple)
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database.\n";

    // 3. Add column
    echo "Attempting to add 'approved_by' column to 'professional_documents'...\n";

    // Check if column exists first to avoid error spam
    $stmt = $pdo->prepare("SHOW COLUMNS FROM professional_documents LIKE 'approved_by'");
    $stmt->execute();
    if ($stmt->fetch()) {
        echo "Column 'approved_by' already exists.\n";
    } else {
        $pdo->exec("ALTER TABLE professional_documents ADD COLUMN approved_by INT NULL DEFAULT NULL");
        echo "Column 'approved_by' added successfully.\n";
    }

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
