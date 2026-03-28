<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 600px;">
    <div class="flex-between align-center" style="margin-bottom: 24px;">
        <h1 class="page-title">Edit Unit</h1>
        <?= component('button', ['href' => APP_URL . "/institution/course/{$unit['course_id']}", 'label' => '&larr; Cancel', 'variant' => 'outline']) ?>
    </div>

    <div class="card">
        <form action="<?= APP_URL ?>/institution/unit/update" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($unit['id']) ?>">
            <input type="hidden" name="course_id" value="<?= htmlspecialchars($unit['course_id']) ?>">

            <div style="margin-bottom: 20px;">
                <?= component('input', [
                    'name' => 'unit_code',
                    'label' => 'Unit Code',
                    'value' => $unit['unit_code'],
                    'required' => true
                ]) ?>
            </div>

            <div style="margin-bottom: 20px;">
                <?= component('input', [
                    'name' => 'unit_title',
                    'label' => 'Unit Title',
                    'value' => $unit['unit_title'],
                    'required' => true
                ]) ?>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Category <span style="color:var(--danger)">*</span></label>
                <select name="category" class="form-control" required>
                    <option value="Basic" <?= $unit['category'] == 'Basic' ? 'selected' : '' ?>>Basic</option>
                    <option value="Common" <?= $unit['category'] == 'Common' ? 'selected' : '' ?>>Common</option>
                    <option value="Core" <?= $unit['category'] == 'Core' ? 'selected' : '' ?>>Core</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label">Description (Optional)</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($unit['description']) ?></textarea>
            </div>

            <?= component('button', ['type' => 'submit', 'label' => 'Update Unit', 'class' => 'w-100']) ?>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>