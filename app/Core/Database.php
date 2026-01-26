<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
            $this->connection = new PDO($dsn, DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Create database if not exists (Lazy init for the connection wrapper, 
            // but usually we want to assume it exists for the app. 
            // The Manager handles creation.)
            $this->connection->exec("USE " . DB_NAME);

        } catch (PDOException $e) {
            // If DB doesn't exist, we might be in setup mode. 
            // Allow connection without DB selected if the error is "Unknown database"
            if (strpos($e->getMessage(), "Unknown database") !== false) {
                try {
                    $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
                    $this->connection = new PDO($dsn, DB_USER, DB_PASS);
                    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $ex) {
                    die("DB Connection Error: " . $ex->getMessage());
                }
            } else {
                die("DB Connection Error: " . $e->getMessage());
            }
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
