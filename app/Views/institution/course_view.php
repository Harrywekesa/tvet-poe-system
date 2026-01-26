<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/institution/department/<?= $course['department_id'] ?>" class="btn btn-outline">&larr; Back to Department</a>
    </div>

    <h1><?= htmlspecialchars($course['title']) ?> (<?= htmlspecialchars($course['code']) ?>)</h1>
    <p class="text-secondary">Manage Units of Competency</p>
    
    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Units Library</h3>
        
        <form action="<?= APP_URL ?>/institution/unit" method="POST" class="form-grid-5" style="margin-top: 20px;">
            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
            
            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Unit Code</label>
                <input type="text" name="unit_code" placeholder="e.g. ENG/CU/EI/CC/01/6/A" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>
            
            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Unit Title</label>
                <input type="text" name="unit_title" placeholder="Demonstrate OSH Practices" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div>
                 <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Category</label>
                 <select name="category" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                     <option value="Basic">Basic</option>
                     <option value="Common">Common</option>
                     <option value="Core">Core</option>
                 </select>
            </div>

            <div>
                 <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Description</label>
                 <input type="text" name="description" placeholder="Optional" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>
            
            <button type="submit" class="btn btn-primary" style="height: 38px;">Add Unit</button>
        </form>

        <table style="width: 100%; border-collapse: collapse; margin-top: 25px;">
            <thead>
                <tr style="background: #f8fafc; text-align: left;">
                    <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Code</th>
                    <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Title</th>
                    <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Category</th>
                    <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($units as $u): ?>
                <tr>
                    <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;"><?= htmlspecialchars($u['unit_code']) ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; font-weight: 500;"><?= htmlspecialchars($u['unit_title']) ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;"><?= htmlspecialchars($u['category']) ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">
                        <!-- Placeholder for assessment link -->
                        <a href="<?= APP_URL ?>/assessment/manage/<?= $u['id'] ?>" class="btn btn-outline" style="padding: 4px 10px; font-size: 0.8rem; margin-right: 5px; color: #475569; border-color: #cbd5e1;">Manage Assessments</a>
                        <a href="<?= APP_URL ?>/institution/unit/edit/<?= $u['id'] ?>" class="btn btn-primary" style="padding: 4px 10px; font-size: 0.8rem; background: #64748b;">Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($units)): ?>
                    <tr><td colspan="4" style="padding: 20px; text-align: center; color: #64748b;">No units added yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
