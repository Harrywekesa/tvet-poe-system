<?php
$label = $label ?? 'Badge';
$variant = $variant ?? 'primary'; // primary, success, warning, danger, secondary
$class = $class ?? '';

$variantClass = $variant ? "badge-$variant" : "";
$classes = trim("badge $variantClass $class");
?>
<span class="<?= htmlspecialchars($classes) ?>"><?= htmlspecialchars($label) ?></span>
