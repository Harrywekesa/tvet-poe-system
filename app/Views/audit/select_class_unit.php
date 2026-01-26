<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="margin-top: 40px;">
    <a href="<?= APP_URL ?>/audit/course?dept_id=<?= $dept_id ?>" class="btn btn-outline"
        style="margin-bottom: 20px;">&larr; Back to Courses</a>
    <h1>Audit: Select Active Class</h1>
    <p>Viewing classes in active cohorts.</p>

    <div class="grid-3" style="margin-top: 20px;">
        <?php foreach ($classes as $c): ?>
            <a href="<?= APP_URL ?>/audit/workspace?class_id=<?= $c['id'] ?>"
                style="text-decoration: none; color: inherit;">
                <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h3 style="margin: 0; color: #2563eb;">
                        <?= htmlspecialchars($c['class_code']) ?>
                    </h3>
                    <p style="color: #64748b; margin-top: 5px;">Cohort:
                        <?= htmlspecialchars($c['cohort_name']) ?>
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
        <?php if (empty($classes)): ?>
            <p>No active classes found for this course.</p>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>