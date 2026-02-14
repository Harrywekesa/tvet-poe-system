<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'cbet_poe_system');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected.\n";

    // Add suspension_reason
    $stmt = $pdo->prepare("SHOW COLUMNS FROM users LIKE 'suspension_reason'");
    $stmt->execute();
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE users ADD COLUMN suspension_reason TEXT NULL DEFAULT NULL");
        echo "Added 'suspension_reason'.\n";
    }

    // Add is_deleted
    $stmt = $pdo->prepare("SHOW COLUMNS FROM users LIKE 'is_deleted'");
    $stmt->execute();
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE users ADD COLUMN is_deleted TINYINT(1) DEFAULT 0");
        echo "Added 'is_deleted'.\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
