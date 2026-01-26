<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="margin-top: 40px;">
    <h1>Audit: Select Department</h1>
    <p>Choose a department to begin auditing.</p>

    <div class="grid-3" style="margin-top: 20px;">
        <?php foreach ($depts as $d): ?>
            <a href="<?= APP_URL ?>/audit/course?dept_id=<?= $d['id'] ?>" style="text-decoration: none; color: inherit;">
                <div
                    style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; transition: transform 0.2s;">
                    <h3 style="margin: 0; color: #2563eb;">
                        <?= htmlspecialchars($d['name']) ?>
                    </h3>
                    <p style="color: #64748b; margin-top: 5px;">Head:
                        <?= htmlspecialchars($d['head_name'] ?? 'Unassigned') ?>
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>