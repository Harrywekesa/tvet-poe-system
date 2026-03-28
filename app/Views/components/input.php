<?php
$type = $type ?? 'text';
$name = $name ?? '';
$label = $label ?? '';
$value = $value ?? '';
$required = ($required ?? false) ? 'required' : '';
$placeholder = $placeholder ?? '';
$class = $class ?? '';
$attrs = $attrs ?? '';
?>
<div class="form-group <?= htmlspecialchars($class) ?>">
    <?php if($label): ?>
        <label class="form-label"><?= htmlspecialchars($label) ?><?= $required ? ' <span style="color:var(--danger)">*</span>' : '' ?></label>
    <?php endif; ?>
    <input type="<?= htmlspecialchars($type) ?>" name="<?= htmlspecialchars($name) ?>" value="<?= htmlspecialchars((string)$value) ?>" placeholder="<?= htmlspecialchars($placeholder) ?>" class="form-control" <?= $required ?> <?= $attrs ?>>
</div>
