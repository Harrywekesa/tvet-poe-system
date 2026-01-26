<?php

namespace App\Core;

class Audit
{
    public static function log($action, $details = '')
    {
        $db = Database::getInstance();
        $userId = $_SESSION['user_id'] ?? null;
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

        // Simple text log into DB
        $db->getConnection()->prepare("
            INSERT INTO activity_logs (user_id, action, details, ip_address) 
            VALUES (?, ?, ?, ?)
        ")->execute([$userId, $action, $details, $ip]);
    }
}
