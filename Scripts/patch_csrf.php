<?php
$viewsDir = 'C:/xampp/htdocs/APOE/app/Views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
$count = 0;
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        
        if (stripos($content, '<form') !== false && stripos($content, 'method="POST"') !== false && stripos($content, 'csrf_field()') === false && stripos($content, 'csrf_token') === false) {
            
            $pattern = '/(<form\b(?:[^>]|(?<=\\?)>)*?method=["\']POST["\'](?:[^>]|(?<=\\?)>)*?>)/is';
            $replacement = "$1\n    <" . "?= csrf_field() ?" . ">";
            
            $newContent = preg_replace($pattern, $replacement, $content);
            
            if ($newContent !== null && $newContent !== $content) {
                file_put_contents($path, $newContent);
                $count++;
            }
        }
    }
}
echo "Successfully patched $count files.\n";
