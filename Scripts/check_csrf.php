<?php
$viewsDir = 'C:/xampp/htdocs/APOE/app/Views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
$missing = [];
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getRealPath());
        if (stripos($content, '<form') !== false && stripos($content, 'method="POST"') !== false && stripos($content, 'csrf_field()') === false && stripos($content, 'csrf_token') === false) {
            $missing[] = str_replace($viewsDir, '', $file->getRealPath());
        }
    }
}
echo "Missing: " . count($missing) . "\n" . implode("\n", $missing) . "\n";
