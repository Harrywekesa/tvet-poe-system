<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4">
    <div class="flex-between align-center" style="margin-bottom: 24px;">
        <div>
            <h1 class="page-title">Department Management</h1>
            <p class="text-muted">Manage qualifications and courses under this department.</p>
        </div>
        <div>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
                <?= component('button', ['href' => APP_URL . '/institution', 'label' => '&larr; Back to Institution', 'variant' => 'outline']) ?>
            <?php else: ?>
                <?= component('button', ['href' => APP_URL . '/dashboard', 'label' => '&larr; Back to Dashboard', 'variant' => 'outline']) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-bottom: 20px;">Add New Course</h3>

        <form action="<?= APP_URL ?>/institution/course" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="department_id" value="<?= htmlspecialchars($dept_id) ?>">

            <div class="grid-4" style="align-items: end; gap: 15px;">
                <?= component('input', [
                    'name' => 'title',
                    'label' => 'Course Title',
                    'placeholder' => 'e.g. Diploma in ICT',
                    'required' => true
                ]) ?>

                <?= component('input', [
                    'name' => 'code',
                    'label' => 'Code',
                    'placeholder' => 'e.g. DICT/2024',
                    'required' => true
                ]) ?>

                <div class="form-group">
                    <label class="form-label">Level <span style="color:var(--danger)">*</span></label>
                    <select name="level" class="form-control" required>
                        <option value="Level 6 (Diploma)">Diploma (Level 6)</option>
                        <option value="Level 5 (Certificate)">Certificate (Level 5)</option>
                        <option value="Level 4 (Artisan)">Artisan (Level 4)</option>
                    </select>
                </div>

                <div class="form-group">
                    <?= component('button', ['type' => 'submit', 'label' => 'Add Course', 'class' => 'w-100']) ?>
                </div>
            </div>
        </form>

        <hr style="margin: 30px 0; border: none; border-top: 1px solid var(--border-color);">

        <h3 style="margin-bottom: 20px;">Active Courses</h3>

        <div class="grid-3">
            <?php foreach ($courses as $c): ?>
                <div class="card" style="padding: 20px; display: flex; flex-direction: column; justify-content: space-between; border: 1px solid var(--border-color); box-shadow: none;">
                    <div style="margin-bottom: 20px;">
                        <div class="flex-between align-center" style="margin-bottom: 10px;">
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">
                                <?= htmlspecialchars($c['code']) ?>
                            </span>
                            <?= component('badge', ['label' => htmlspecialchars($c['level']), 'variant' => 'info']) ?>
                        </div>
                        <h4 style="margin: 0; color: var(--text-primary); font-size: 1.1rem; font-weight: 600;">
                            <?= htmlspecialchars($c['title']) ?>
                        </h4>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: auto;">
                        <?= component('button', [
                            'href' => APP_URL . "/institution/course/{$c['id']}", 
                            'label' => '<i data-feather="book-open" style="width:16px; margin-right:5px;"></i> Units', 
                            'class' => 'w-100'
                        ]) ?>
                        <?= component('button', [
                            'href' => APP_URL . "/institution/course/edit/{$c['id']}", 
                            'label' => '<i data-feather="edit-2" style="width:16px; margin-right:5px;"></i> Edit', 
                            'variant' => 'outline',
                            'class' => 'w-100'
                        ]) ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($courses)): ?>
                <div class="card text-center text-muted" style="grid-column: 1 / -1; background: var(--bg-app); border: 1px dashed var(--border-color); box-shadow: none;">
                    <i data-feather="inbox" style="width: 40px; height: 40px; color: #cbd5e1; margin-bottom: 15px;"></i>
                    <p style="margin: 0;">No courses added yet. Use the form above to add a new course.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>