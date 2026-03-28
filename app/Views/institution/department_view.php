<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
            <a href="<?= APP_URL ?>/institution" class="btn btn-outline">&larr; Back to Institution</a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
        <?php endif; ?>
    </div>

    <h1>Department Management</h1>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Courses (Qualifications)</h3>

        <form action="<?= APP_URL ?>/institution/course" method="POST" class="form-grid-4" style="margin-top: 20px;">
    <?= csrf_field() ?>
            <input type="hidden" name="department_id" value="<?= $dept_id ?>">

            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Course Title</label>
                <input type="text" name="title" placeholder="e.g. Diploma in ICT" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Code</label>
                <input type="text" name="code" placeholder="e.g. DICT/2024" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Level</label>
                <select name="level" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <option value="Level 6 (Diploma)">Diploma (Level 6)</option>
                    <option value="Level 5 (Certificate)">Certificate (Level 5)</option>
                    <option value="Level 4 (Artisan)">Artisan (Level 4)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="height: 38px;">Add Course</button>
        </form>

        <div
            style="margin-top: 25px; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px;">
            <?php foreach ($courses as $c): ?>
                <div
                    style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 100%; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 5px;">
                            <span
                                style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;"><?= htmlspecialchars($c['code']) ?></span>
                            <span
                                style="font-size: 0.75rem; background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 12px;"><?= htmlspecialchars($c['level']) ?></span>
                        </div>
                        <h4 style="margin: 0; color: #1e293b; font-size: 1.1rem; font-weight: 600; line-height: 1.4;">
                            <?= htmlspecialchars($c['title']) ?></h4>
                    </div>

                    <div style="display: flex; gap: 10px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                        <a href="<?= APP_URL ?>/institution/course/<?= $c['id'] ?>" class="btn btn-outline"
                            style="flex: 1; text-align: center; justify-content: center; font-size: 0.85rem;">
                            <i class="fas fa-list-ul" style="margin-right: 5px;"></i> Units
                        </a>
                        <a href="<?= APP_URL ?>/institution/course/edit/<?= $c['id'] ?>" class="btn btn-outline"
                            style="flex: 1; text-align: center; justify-content: center; font-size: 0.85rem; border-color: #cbd5e1; color: #475569;">
                            <i class="fas fa-edit" style="margin-right: 5px;"></i> Edit
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($courses)): ?>
                <div
                    style="grid-column: 1 / -1; padding: 40px; text-align: center; color: #64748b; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                    <p style="margin: 0;">No courses added yet. Use the form above to add a new course.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>