<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/institution/department/<?= $course['department_id'] ?>" class="btn btn-outline">&larr;
            Back to Department</a>
    </div>

    <h1><?= htmlspecialchars($course['title']) ?> (<?= htmlspecialchars($course['code']) ?>)</h1>
    <p class="text-secondary">Manage Units of Competency</p>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Units Library</h3>

        <form action="<?= APP_URL ?>/institution/unit" method="POST" class="form-grid-5" style="margin-top: 20px;">
            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">

            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Unit Code</label>
                <input type="text" name="unit_code" placeholder="e.g. ENG/CU/EI/CC/01/6/A" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Unit Title</label>
                <input type="text" name="unit_title" placeholder="Demonstrate OSH Practices" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Category</label>
                <select name="category"
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <option value="Basic">Basic</option>
                    <option value="Common">Common</option>
                    <option value="Core">Core</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Description</label>
                <input type="text" name="description" placeholder="Optional"
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <button type="submit" class="btn btn-primary" style="height: 38px;">Add Unit</button>
        </form>

        <div
            style="margin-top: 25px; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px;">
            <?php foreach ($units as $u): ?>
                <div
                    style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 100%; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 5px;">
                            <span
                                style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;"><?= htmlspecialchars($u['unit_code']) ?></span>
                            <span
                                style="font-size: 0.75rem; background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 12px; font-weight: 600;"><?= htmlspecialchars($u['category']) ?></span>
                        </div>
                        <h4 style="margin: 0; color: #1e293b; font-size: 1.1rem; font-weight: 600; line-height: 1.4;">
                            <?= htmlspecialchars($u['unit_title']) ?></h4>
                        <?php if (!empty($u['description'])): ?>
                            <p
                                style="font-size: 0.85rem; color: #64748b; margin-top: 5px; margin-bottom: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= htmlspecialchars($u['description']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div style="display: flex; gap: 10px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                        <!-- Placeholder for assessment link -->
                        <a href="<?= APP_URL ?>/assessment/manage/<?= $u['id'] ?>" class="btn btn-outline"
                            style="flex: 1; text-align: center; justify-content: center; font-size: 0.85rem; color: #475569; border-color: #cbd5e1;">
                            <i class="fas fa-tasks" style="margin-right: 5px;"></i> Assessments
                        </a>
                        <a href="<?= APP_URL ?>/institution/unit/edit/<?= $u['id'] ?>" class="btn btn-outline"
                            style="flex: 1; text-align: center; justify-content: center; font-size: 0.85rem; border-color: #cbd5e1; color: #475569;">
                            <i class="fas fa-edit" style="margin-right: 5px;"></i> Edit
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($units)): ?>
                <div
                    style="grid-column: 1 / -1; padding: 40px; text-align: center; color: #64748b; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                    <p style="margin: 0;">No units added yet. Use the form above to add a new unit.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>