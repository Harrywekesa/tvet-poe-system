<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/institution" class="btn btn-outline">&larr; Back to Institution</a>
    </div>

    <h1>Department Management</h1>
    
    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Courses (Qualifications)</h3>
        
        <form action="<?= APP_URL ?>/institution/course" method="POST" class="form-grid-4" style="margin-top: 20px;">
            <input type="hidden" name="department_id" value="<?= $dept_id ?>">
            
            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Course Title</label>
                <input type="text" name="title" placeholder="e.g. Diploma in ICT" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>
            
            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Code</label>
                <input type="text" name="code" placeholder="e.g. DICT/2024" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
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

        <table style="width: 100%; border-collapse: collapse; margin-top: 25px;">
            <thead>
                <tr style="background: #f8fafc; text-align: left;">
                    <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Code</th>
                    <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Title</th>
                    <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Level</th>
                    <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $c): ?>
                <tr>
                    <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;"><?= htmlspecialchars($c['code']) ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; font-weight: 500;"><?= htmlspecialchars($c['title']) ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;"><?= htmlspecialchars($c['level']) ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">
                        <a href="<?= APP_URL ?>/institution/course/<?= $c['id'] ?>" class="btn btn-outline" style="padding: 4px 10px; font-size: 0.8rem; margin-right: 5px;">Units</a>
                        <a href="<?= APP_URL ?>/institution/course/edit/<?= $c['id'] ?>" class="btn btn-primary" style="padding: 4px 10px; font-size: 0.8rem; background: #64748b;">Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($courses)): ?>
                    <tr><td colspan="4" style="padding: 20px; text-align: center; color: #64748b;">No courses added yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
