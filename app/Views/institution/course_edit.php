<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 600px;">
    <div class="flex-between align-center" style="margin-bottom: 24px;">
        <h1 class="page-title">Edit Course</h1>
        <?= component('button', ['href' => APP_URL . "/institution/department/{$course['department_id']}", 'label' => '&larr; Cancel', 'variant' => 'outline']) ?>
    </div>

    <div class="card">
        <form action="<?= APP_URL ?>/institution/course/update" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($course['id']) ?>">

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Department <span style="color:var(--danger)">*</span></label>
                <select name="department_id" class="form-control" required>
                    <?php foreach ($departments as $d): ?>
                        <option value="<?= htmlspecialchars($d['id']) ?>" <?= $d['id'] == $course['department_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <?= component('input', [
                    'name' => 'title',
                    'label' => 'Course Title',
                    'value' => $course['title'],
                    'required' => true
                ]) ?>
            </div>

            <div style="margin-bottom: 20px;">
                <?= component('input', [
                    'name' => 'code',
                    'label' => 'Code',
                    'value' => $course['code'],
                    'required' => true
                ]) ?>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label">Level <span style="color:var(--danger)">*</span></label>
                <select name="level" class="form-control" required>
                    <option value="Level 6 (Diploma)" <?= $course['level'] == 'Level 6 (Diploma)' ? 'selected' : '' ?>>Diploma (Level 6)</option>
                    <option value="Level 5 (Certificate)" <?= $course['level'] == 'Level 5 (Certificate)' ? 'selected' : '' ?>>Certificate (Level 5)</option>
                    <option value="Level 4 (Artisan)" <?= $course['level'] == 'Level 4 (Artisan)' ? 'selected' : '' ?>>Artisan (Level 4)</option>
                </select>
            </div>

            <?= component('button', ['type' => 'submit', 'label' => 'Update Course', 'class' => 'w-100']) ?>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>