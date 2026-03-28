<?php

namespace App\Services;

class UploadService
{
    /**
     * Handles file upload securely with strict MIME and extension validation.
     * 
     * @param string $formFieldName The name of the file input in the form.
     * @param string $targetDir The directory to save the file (relative to public/uploads/).
     * @param array $allowedExtensions Valid file extensions (default: images, docs, pdfs).
     * @param int $maxFileSize Maximum file size in bytes (default: 5MB).
     * @return array ['success' => bool, 'path' => string, 'error' => string]
     */
    public static function handleUpload($formFieldName, $targetDir, $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'], $maxFileSize = 5242880)
    {
        if (!isset($_FILES[$formFieldName]) || $_FILES[$formFieldName]['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'No file uploaded or upload error occurred. Error code: ' . ($_FILES[$formFieldName]['error'] ?? 'Unknown')];
        }

        $fileTmpPath = $_FILES[$formFieldName]['tmp_name'];
        $fileName = $_FILES[$formFieldName]['name'];
        $fileSize = $_FILES[$formFieldName]['size'];

        // 1. Size Validation
        if ($fileSize > $maxFileSize) {
            return ['success' => false, 'error' => 'File size exceeds maximum limit of ' . ($maxFileSize / 1024 / 1024) . 'MB'];
        }

        // 2. Extension Validation
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExtensions)) {
            return ['success' => false, 'error' => 'Invalid file extension. Allowed: ' . implode(', ', $allowedExtensions)];
        }

        // 3. MIME Type Validation (Strict)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fileTmpPath);
        finfo_close($finfo);

        $allowedMimes = [
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        // Ensure the mime maps to our strict list and matches the claimed extension
        if (!isset($allowedMimes[$ext]) || $allowedMimes[$ext] !== $mimeType) {
            return ['success' => false, 'error' => 'File content does not match the file extension or is not an allowed type.'];
        }

        // 4. Safe Filename Generation
        $newFileName = bin2hex(random_bytes(8)) . '_' . time() . '.' . $ext;
        
        // Target paths
        $baseUploadDir = UPLOAD_DIR; // Defined in config.php
        $relativeDir = trim($targetDir, '/');
        $fullDestDir = $baseUploadDir . $relativeDir . '/';
        
        // Ensure directory exists
        if (!is_dir($fullDestDir)) {
            if (!mkdir($fullDestDir, 0777, true)) {
                 return ['success' => false, 'error' => 'Failed to create upload directory.'];
            }
        }

        $destPath = $fullDestDir . $newFileName;
        
        // 5. Move File
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Return relative path to be stored in DB (e.g. '/uploads/settings/file.png')
            return [
                'success' => true, 
                'path' => '/uploads/' . $relativeDir . '/' . $newFileName,
                'extension' => $ext,
                'filename' => $newFileName
            ];
        }

        return ['success' => false, 'error' => 'Failed to write uploaded file to disk.'];
    }
}
