<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/academic" class="btn btn-outline">&larr; All Cohorts</a>
    </div>

    <h1><?= htmlspecialchars($cohort['name']) ?></h1>
    <p class="text-secondary">classes running in this intake.</p>
    
    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Classes</h3>
        
        <form action="<?= APP_URL ?>/academic/class" method="POST" class="form-grid-3" style="margin-top: 20px;">
    <?= csrf_field() ?>
            <input type="hidden" name="cohort_id" value="<?= $cohort['id'] ?>">
            
            <div>
                 <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Course</label>
                 <select name="course_id" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                     <option value="">Select Course...</option>
                     <?php foreach ($courses as $c): ?>
                         <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['title']) ?> (<?= $c['code'] ?>)</option>
                     <?php endforeach; ?>
                 </select>
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 3px;">Unique Class Code</label>
                <input type="text" name="class_code" placeholder="e.g. ICT-JAN-24-A" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>
            
            <button type="submit" class="btn btn-primary" style="height: 38px;">Create Class</button>
        </form>

        <table style="width: 100%; border-collapse: collapse; margin-top: 25px;">
            <thead>
                <tr style="background: #f8fafc; text-align: left;">
                    <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Class Code</th>
                    <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Course</th>
                    <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $cl): ?>
                <tr>
                    <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; font-weight: 500;"><?= htmlspecialchars($cl['class_code']) ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;"><?= htmlspecialchars($cl['course_title']) ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">
                         <a href="<?= APP_URL ?>/academic/class/<?= $cl['id'] ?>" class="btn btn-outline" style="padding: 4px 10px; font-size: 0.8rem;">Manage View</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($classes)): ?>
                    <tr><td colspan="3" style="padding: 20px; text-align: center; color: #64748b;">No classes defined in this cohort.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
