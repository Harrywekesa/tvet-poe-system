<?php

namespace App\Services;

class EmailService
{
    /**
     * Sends an email using PHP's native mail function.
     * 
     * @param string $to Recipient email address
     * @param string $subject Email subject
     * @param string $message HTML or text email content
     * @return bool True on success, false on failure
     */
    public static function send($to, $subject, $message)
    {
        // For development/mock environments where mail is not configured
        // you might log this instead or use MailHog, but we will call mail() directly.
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: CBET POE System <no-reply@cbet-poe.local>" . "\r\n";

        // To prevent hanging on local envs without SMTP, we wrap in try-catch/suppress error
        try {
            return @mail($to, $subject, $message, $headers);
        } catch (\Exception $e) {
            \App\Core\Audit::log('Email Error', "Failed to send email to $to: " . $e->getMessage());
            return false;
        }
    }
}
