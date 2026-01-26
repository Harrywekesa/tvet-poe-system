<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <h1>My POE Dashboard</h1>
    <p class="text-secondary">Track your competency evidence.</p>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 30px;">
        <h3>My Enrolled Classes</h3>

        <?php if (empty($classes)): ?>
            <p style="color: #64748b; margin-top: 15px;">You are not enrolled in any classes yet.</p>
        <?php else: ?>
            <div class="grid-3" style="margin-top: 20px;">
                <?php foreach ($classes as $c): ?>
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                        <h4 style="font-size: 1.1rem; margin-bottom: 5px;">
                            <?= htmlspecialchars($c['class_code']) ?>
                        </h4>
                        <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 15px;">
                            <?= htmlspecialchars($c['course_title']) ?>
                        </p>
                        <a href="<?= APP_URL ?>/poe/class/<?= $c['id'] ?>" class="btn btn-primary"
                            style="width: 100%; text-align: center;">View Units</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>