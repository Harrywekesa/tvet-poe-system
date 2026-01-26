<?php

namespace App\Core;

use PDO;
use Exception;

class DatabaseManager
{
    private $pdo;
    private $logFile;

    public function __construct()
    {
        require_once __DIR__ . '/../../config/config.php';
        $this->logFile = __DIR__ . '/../../storage/db_migration_log.txt';

        if (!file_exists(dirname($this->logFile))) {
            mkdir(dirname($this->logFile), 0777, true);
        }

        $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die("Manager Connection Fail: " . $e->getMessage());
        }
    }

    public function log($message)
    {
        $entry = "[" . date('Y-m-d H:i:s') . "] " . $message . PHP_EOL;
        file_put_contents($this->logFile, $entry, FILE_APPEND);
        echo $entry . "<br>";
    }

    public function initDatabase()
    {
        $dbName = DB_NAME;
        try {
            $this->pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $this->log("Database `$dbName` ensured.");
            $this->pdo->exec("USE `$dbName`");
            $this->createMigrationsTable();
        } catch (Exception $e) {
            $this->log("Error creating DB: " . $e->getMessage());
        }
    }

    private function createMigrationsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    public function runMigrations($sqlDir)
    {
        $files = glob($sqlDir . '/*.sql');
        sort($files);

        $this->pdo->exec("USE `" . DB_NAME . "`");

        foreach ($files as $file) {
            $filename = basename($file);

            // Check if migrated
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
            $stmt->execute([$filename]);
            if ($stmt->fetchColumn() > 0) {
                continue; // Already executed
            }

            $this->log("Running migration: $filename");
            $sql = file_get_contents($file);

            try {
                $this->pdo->exec($sql);
                $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
                $stmt->execute([$filename]);
                $this->log("Success: $filename");
            } catch (Exception $e) {
                $this->log("FAILED: $filename - " . $e->getMessage());
                throw $e; // Stop on error
            }
        }
    }
}
