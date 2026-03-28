<?php
$message = $message ?? '';
$variant = $variant ?? 'info'; // success, error/danger, warning, info
$class = $class ?? '';

// Support standard alert-danger mapping
if ($variant === 'error') $variant = 'danger';

$variantClass = $variant ? "alert-$variant" : "";
$classes = trim("alert $variantClass $class");

$iconMap = [
    'success' => 'check-circle',
    'danger' => 'alert-circle',
    'warning' => 'alert-triangle',
    'info' => 'info'
];
$icon = $iconMap[$variant] ?? 'info';
?>
<?php if($message): ?>
<div class="<?= htmlspecialchars($classes) ?>" style="display: flex; align-items: flex-start; gap: 12px;">
    <i data-feather="<?= $icon ?>" style="flex-shrink: 0; width: 20px; height: 20px;"></i>
    <div style="flex: 1;"><?= $message ?></div> <!-- Note: raw message to allow HTML if needed, sanitize beforehand if necessary -->
</div>
<?php endif; ?>
