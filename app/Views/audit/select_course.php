<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="margin-top: 40px;">
    <a href="<?= APP_URL ?>/audit" class="btn btn-outline" style="margin-bottom: 20px;">&larr; Back to Departments</a>
    <h1>Audit: Select Course</h1>

    <div class="grid-3" style="margin-top: 20px;">
        <?php foreach ($courses as $c): ?>
            <a href="<?= APP_URL ?>/audit/unit?course_id=<?= $c['id'] ?>" style="text-decoration: none; color: inherit;">
                <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h3 style="margin: 0; color: #2563eb;">
                        <?= htmlspecialchars($c['title']) ?>
                    </h3>
                    <p style="color: #64748b; margin-top: 5px;">Code:
                        <?= htmlspecialchars($c['code']) ?>
                    </p>
                    <span style="font-size: 0.8rem; background: #e0f2fe; padding: 2px 6px; border-radius: 4px;">Level
                        <?= $c['level'] ?>
                    </span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>