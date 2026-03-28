<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4">
    <div class="flex-between align-center" style="margin-bottom: 24px;">
        <div>
            <h1 class="page-title"><?= htmlspecialchars($course['title']) ?> (<?= htmlspecialchars($course['code']) ?>)</h1>
            <p class="text-muted">Manage Units of Competency</p>
        </div>
        <div>
            <?= component('button', ['href' => APP_URL . "/institution/department/{$course['department_id']}", 'label' => '&larr; Back to Department', 'variant' => 'outline']) ?>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-bottom: 20px;">Add New Unit</h3>

        <form action="<?= APP_URL ?>/institution/unit" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">

            <div class="grid-4" style="align-items: start; gap: 15px;">
                <?= component('input', [
                    'name' => 'unit_code',
                    'label' => 'Unit Code',
                    'placeholder' => 'e.g. ENG/CU/...',
                    'required' => true
                ]) ?>

                <?= component('input', [
                    'name' => 'unit_title',
                    'label' => 'Unit Title',
                    'placeholder' => 'Demonstrate OSH',
                    'required' => true
                ]) ?>

                <div class="form-group">
                    <label class="form-label">Category <span style="color:var(--danger)">*</span></label>
                    <select name="category" class="form-control" required>
                        <option value="Basic">Basic</option>
                        <option value="Common">Common</option>
                        <option value="Core">Core</option>
                    </select>
                </div>

                <?= component('input', [
                    'name' => 'description',
                    'label' => 'Description (Optional)',
                    'placeholder' => 'Optional context'
                ]) ?>
            </div>
            
            <div style="text-align: right; margin-top: 10px;">
                <?= component('button', ['type' => 'submit', 'label' => 'Add Unit']) ?>
            </div>
        </form>

        <hr style="margin: 30px 0; border: none; border-top: 1px solid var(--border-color);">

        <h3 style="margin-bottom: 20px;">Units Library</h3>

        <div class="grid-3">
            <?php foreach ($units as $u): ?>
                <div class="card" style="padding: 20px; display: flex; flex-direction: column; justify-content: space-between; border: 1px solid var(--border-color); box-shadow: none;">
                    <div style="margin-bottom: 20px;">
                        <div class="flex-between align-center" style="margin-bottom: 10px;">
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">
                                <?= htmlspecialchars($u['unit_code']) ?>
                            </span>
                            <?= component('badge', ['label' => htmlspecialchars($u['category']), 'variant' => 'info']) ?>
                        </div>
                        <h4 style="margin: 0; color: var(--text-primary); font-size: 1.1rem; font-weight: 600; line-height: 1.4;">
                            <?= htmlspecialchars($u['unit_title']) ?>
                        </h4>
                        <?php if (!empty($u['description'])): ?>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 10px; margin-bottom: 0;">
                                <?= htmlspecialchars($u['description']) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: auto;">
                        <?= component('button', [
                            'href' => APP_URL . "/assessment/manage/{$u['id']}", 
                            'label' => '<i data-feather="check-square" style="width:16px; margin-right:5px;"></i> Assessments', 
                            'variant' => 'outline',
                            'class' => 'w-100'
                        ]) ?>
                        <?= component('button', [
                            'href' => APP_URL . "/institution/unit/edit/{$u['id']}", 
                            'label' => '<i data-feather="edit-2" style="width:16px; margin-right:5px;"></i> Edit', 
                            'variant' => 'outline',
                            'class' => 'w-100'
                        ]) ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($units)): ?>
                <div class="card text-center text-muted" style="grid-column: 1 / -1; background: var(--bg-app); border: 1px dashed var(--border-color); box-shadow: none;">
                    <i data-feather="file" style="width: 40px; height: 40px; color: #cbd5e1; margin-bottom: 15px;"></i>
                    <p style="margin: 0;">No units added yet. Use the form above to add a new unit.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>