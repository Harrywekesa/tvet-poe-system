<?php
$file = 'c:\\xampp\\htdocs\\APOE\\app\\Views\\partials\\header.php';
$content = file_get_contents($file);

@mkdir('c:\\xampp\\htdocs\\APOE\\public\\css', 0777, true);
@mkdir('c:\\xampp\\htdocs\\APOE\\public\\js', 0777, true);

$cssExtracted = false;
$jsExtracted = false;

// 1. Extract CSS
if (preg_match('/<style>(.*?)<\/style>/is', $content, $matches)) {
    $css = trim($matches[1]);
    file_put_contents('c:\\xampp\\htdocs\\APOE\\public\\css\\style.css', $css);
    $content = preg_replace('/<style>.*?<\/style>/is', '<link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">', $content, 1);
    $cssExtracted = true;
}

// 2. Extract JS (Toast block)
// The toast block is like: <script> ... toast logic ... </script>
if (preg_match('/<script>(.*?const toast = document\.getElementById.*?toast\.remove.*?<\/script>)/is', $content, $matches)) {
    $js = trim($matches[1]);
    // The `<script>` tag is already matched. We need to grab `<script>...</script>` and replace with `<script src...></script>`
    file_put_contents('c:\\xampp\\htdocs\\APOE\\public\\js\\toast.js', $js);
    // Replace the exact matched full block
    $content = str_replace($matches[0], '<script src="<?= APP_URL ?>/js/toast.js"></script>', $content);
    $jsExtracted = true;
}

// 3. Extract Sidebar JS
if (preg_match('/<script>(.*?function toggleSidebar.*?<\/script>)/is', $content, $matches)) {
    $js = trim($matches[1]);
    file_put_contents('c:\\xampp\\htdocs\\APOE\\public\\js\\sidebar.js', $js);
    $content = str_replace($matches[0], '<script src="<?= APP_URL ?>/js/sidebar.js"></script>', $content);
    $jsExtracted = true;
}

// 4. Remove the inline slideIn style for toast
if (preg_match('/<style>.*?@keyframes slideIn.*?<\/style>/is', $content, $matches)) {
    $content = str_replace($matches[0], '', $content);
    // append to style.css
    file_put_contents('c:\\xampp\\htdocs\\APOE\\public\\css\\style.css', "\n\n/* Toast Animation */\n@keyframes slideIn {\n  from { transform: translateX(100%); opacity: 0; }\n  to { transform: translateX(0); opacity: 1; }\n}\n", FILE_APPEND);
}

file_put_contents($file, $content);
echo "Extraction Complete. CSS: " . ($cssExtracted ? "Yes" : "No") . " JS: " . ($jsExtracted ? "Yes" : "No");
