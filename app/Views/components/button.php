<?php
$label = $label ?? 'Button';
$type = $type ?? 'button'; // submit, button
$variant = $variant ?? 'primary'; // primary, outline, danger
$class = $class ?? '';
$href = $href ?? null;
$icon = $icon ?? null;
$attrs = $attrs ?? '';

$variantClass = $variant ? "btn-$variant" : "";
$classes = trim("btn $variantClass $class");

$iconHtml = $icon ? "<i data-feather=\"{$icon}\" style=\"width: 16px; height: 16px; margin-right: 6px; flex-shrink: 0;\"></i> " : "";

if ($href) {
    echo "<a href=\"{$href}\" class=\"{$classes}\" {$attrs}>{$iconHtml}{$label}</a>";
} else {
    echo "<button type=\"{$type}\" class=\"{$classes}\" {$attrs}>{$iconHtml}{$label}</button>";
}
?>
