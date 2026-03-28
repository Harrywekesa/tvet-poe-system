<?php
$viewsDir = 'C:/xampp/htdocs/APOE/app/Views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
$count = 0;
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        if (stripos($content, 'method="POST"') !== false && stripos($content, 'csrf_field()') === false) {
            $content = preg_replace('/(<form[^>]+method=["\']POST["\'][^>]*>)/i', "$1\n    <?= csrf_field() ?>", $content);
            file_put_contents($path, $content);
            $count++;
        }
    }
}
echo "Replaced in $count files.\n";
