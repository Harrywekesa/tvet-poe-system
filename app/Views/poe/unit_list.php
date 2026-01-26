<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/poe/dashboard" class="btn btn-outline">&larr; My Dashboard</a>
    </div>

    <h1>
        <?= htmlspecialchars($class['class_code']) ?>
    </h1>
    <p class="text-secondary">Select a unit to manage submissions.</p>

    <div class="grid-3" style="margin-top: 30px;">
        <?php foreach ($units as $u): ?>
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                    <h4 style="font-size: 1.1rem;">
                        <?= htmlspecialchars($u['unit_title']) ?>
                    </h4>
                    <span
                        style="font-size: 0.8rem; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; border: 1px solid #cbd5e1;">
                        <?= htmlspecialchars($u['unit_code']) ?>
                    </span>
                </div>

                <a href="<?= APP_URL ?>/poe/unit/<?= $u['id'] ?>" class="btn btn-outline"
                    style="width: 100%; text-align: center;">Manage Evidence</a>
            </div>
        <?php endforeach; ?>
        <?php if (empty($units)): ?>
            <p>No units found for this course.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>