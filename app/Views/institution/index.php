<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="mb-4">
    <div class="mb-3">
        <?= component('button', ['href' => APP_URL . '/dashboard', 'label' => '&larr; Back to Dashboard', 'variant' => 'outline']) ?>
    </div>
    <h1 style="margin-bottom: 8px;">Institution Setup</h1>
    <p class="text-muted">Manage core institutional settings, branding, and departments.</p>
</div>

<!-- Bulk Actions -->
<div class="card mb-4" style="background: var(--bg-card);">
    <details>
        <summary style="cursor: pointer; font-weight: 600; color: var(--primary); outline: none;">📂 Bulk Import Data (CSV)</summary>
        <div class="grid-3 mt-3">

            <!-- Dept Import -->
            <div style="padding: 16px; background: #F8FAFC; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                <strong style="display: block; margin-bottom: 4px;">Departments</strong>
                <a href="<?= APP_URL ?>/institution/template/department" download class="text-muted" style="font-size: 0.8rem; display: block; margin-bottom: 12px; text-decoration: underline;">Download Template</a>
                <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="type" value="department">
                    <input type="file" name="csv_file" required style="font-size: 0.85rem; width: 100%; margin-bottom: 8px;">
                    <?= component('button', ['type' => 'submit', 'label' => 'Upload', 'variant' => 'primary', 'class' => 'w-100']) ?>
                </form>
            </div>

            <!-- Course Import -->
            <div style="padding: 16px; background: #F8FAFC; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                <strong style="display: block; margin-bottom: 4px;">Courses</strong>
                <a href="<?= APP_URL ?>/institution/template/course" download class="text-muted" style="font-size: 0.8rem; display: block; margin-bottom: 12px; text-decoration: underline;">Download Template</a>
                <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="type" value="course">
                    <input type="file" name="csv_file" required style="font-size: 0.85rem; width: 100%; margin-bottom: 8px;">
                    <?= component('button', ['type' => 'submit', 'label' => 'Upload', 'variant' => 'primary', 'class' => 'w-100']) ?>
                </form>
            </div>

            <!-- Unit Import -->
            <div style="padding: 16px; background: #F8FAFC; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                <strong style="display: block; margin-bottom: 4px;">Units</strong>
                <a href="<?= APP_URL ?>/institution/template/unit" download class="text-muted" style="font-size: 0.8rem; display: block; margin-bottom: 12px; text-decoration: underline;">Download Template</a>
                <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="type" value="unit">
                    <input type="file" name="csv_file" required style="font-size: 0.85rem; width: 100%; margin-bottom: 8px;">
                    <?= component('button', ['type' => 'submit', 'label' => 'Upload', 'variant' => 'primary', 'class' => 'w-100']) ?>
                </form>
            </div>

        </div>
    </details>
</div>

<div class="grid-main-side mt-4">

    <!-- Details Form -->
    <div class="card">
        <h3 class="mb-4">Institution Details</h3>
        <form action="<?= APP_URL ?>/institution/update" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <?= component('input', [
                'type' => 'text',
                'name' => 'name',
                'label' => 'Institution Name',
                'value' => $institution['name'] ?? '',
                'required' => true
            ]) ?>
            
            <?= component('input', [
                'type' => 'text',
                'name' => 'tvet_code',
                'label' => 'TVET / CBET Code',
                'value' => $institution['tvet_code'] ?? ''
            ]) ?>

            <div class="form-group">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($institution['address'] ?? '') ?></textarea>
            </div>

            <hr style="margin: 32px 0; border: 0; border-top: 1px solid var(--border-color);">

            <?= component('input', [
                'type' => 'text',
                'name' => 'system_name',
                'label' => 'System Name',
                'value' => $institution['system_name'] ?? 'CBET POE System'
            ]) ?>

            <div class="form-group">
                <label class="form-label">System Logo</label>
                <?php if (!empty($institution['logo_path'])): ?>
                    <div style="margin-bottom: 8px; padding: 12px; background: #F8FAFC; border-radius: var(--radius-sm); display: inline-block; border: 1px solid var(--border-color);">
                        <img src="<?= APP_URL . $institution['logo_path'] ?>" alt="Logo" style="height: 40px; object-fit: contain;">
                    </div>
                <?php endif; ?>
                <input type="file" name="logo" accept="image/*" class="form-control">
                <small class="text-muted mt-2" style="display: block;">Upload a PNG or JPG (approx 40px height recommended)</small>
            </div>

            <div class="form-group">
                <label class="form-label">Hero Image (Landing Page)</label>
                <?php if (!empty($institution['hero_image_path'])): ?>
                    <div style="margin-bottom: 8px; padding: 8px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); display: inline-block;">
                        <img src="<?= APP_URL . $institution['hero_image_path'] ?>" alt="Hero" style="height: 80px; width: auto; object-fit: cover; border-radius: 4px;">
                    </div>
                <?php endif; ?>
                <input type="file" name="hero_image" accept="image/*" class="form-control">
                <small class="text-muted mt-2" style="display: block;">Upload a banner for the home page (approx 600x400px)</small>
            </div>

            <div class="grid-2">
                <?= component('input', [
                    'type' => 'email',
                    'name' => 'contact_email',
                    'label' => 'Contact Email',
                    'value' => $institution['contact_email'] ?? ''
                ]) ?>
                <?= component('input', [
                    'type' => 'text',
                    'name' => 'contact_phone',
                    'label' => 'Contact Phone',
                    'value' => $institution['contact_phone'] ?? ''
                ]) ?>
            </div>

            <div class="form-group">
                <label class="form-label">About / Footer Text</label>
                <textarea name="about_text" rows="3" class="form-control"><?= htmlspecialchars($institution['about_text'] ?? '') ?></textarea>
            </div>

            <div class="mt-4">
                <?= component('button', ['type' => 'submit', 'label' => 'Save Details', 'variant' => 'primary']) ?>
            </div>
        </form>
    </div>

    <!-- Department List -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="card">
            <h3 class="mb-2">Departments</h3>
            <p class="text-muted mb-4">Add and manage institutional departments.</p>

            <form action="<?= APP_URL ?>/institution/department" method="POST" style="display: flex; gap: 10px; margin-bottom: 24px;">
                <?= csrf_field() ?>
                <input type="text" name="name" placeholder="New Department Name" required class="form-control" style="flex: 1;">
                <?= component('button', ['type' => 'submit', 'label' => 'Add', 'variant' => 'primary']) ?>
            </form>

            <div style="display: flex; flex-direction: column; gap: 16px;">
                <?php foreach ($departments as $dept): ?>
                    <div style="padding: 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); background: #F8FAFC;">
                        <div class="flex-between mb-3">
                            <h4 style="margin: 0; color: var(--text-primary);"><?= htmlspecialchars($dept['name']) ?></h4>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px solid #E2E8F0;">
                            <?= component('button', [
                                'href' => APP_URL . '/institution/department/' . $dept['id'], 
                                'label' => 'Manage Courses', 
                                'variant' => 'outline',
                                'class' => 'btn-sm'
                            ]) ?>

                            <form action="<?= APP_URL ?>/institution/department/delete" method="POST" onsubmit="return confirm('Are you sure? This will delete the department and cascade if empty.');" style="margin: 0;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= $dept['id'] ?>">
                                <button type="submit" class="btn btn-outline" style="border: none; color: var(--danger); padding: 5px; font-size: 0.85rem; font-weight: 500;" title="Delete Department">
                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($departments)): ?>
                    <div class="text-center text-muted p-4">No departments found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>