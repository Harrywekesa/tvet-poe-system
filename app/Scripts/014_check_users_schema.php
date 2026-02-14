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
    echo "Columns in 'users' table:\n";

    $stmt = $pdo->prepare("SHOW COLUMNS FROM users");
    $stmt->execute();
    $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cols as $col) {
        echo "- " . $col['Field'] . " (" . $col['Type'] . ")\n";
    }

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
}
