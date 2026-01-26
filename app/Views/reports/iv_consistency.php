<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="margin-top: 40px;">
    <h1>
        <?= $title ?>
    </h1>
    <a href="<?= APP_URL ?>/reports" class="btn btn-outline" style="margin-bottom: 20px;">&larr; Back</a>

    <div class="grid-2">
        <?php foreach ($data as $d):
            $agreeRate = $d['total_checked'] > 0 ? round(($d['agreed'] / $d['total_checked']) * 100) : 0;
            ?>
            <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <div class="flex-between">
                    <div>
                        <h3 style="margin:0;">
                            <?= htmlspecialchars($d['trainer_name']) ?>
                        </h3>
                        <p style="color: #64748b; margin: 5px 0;">Sampled:
                            <?= $d['total_checked'] ?> items
                        </p>
                    </div>
                    <div style="text-align: right;">
                        <div
                            style="font-size: 1.5rem; font-weight: 700; color: <?= $agreeRate > 90 ? 'green' : 'orange' ?>">
                            <?= $agreeRate ?>%
                        </div>
                        <small>Agreement Rate</small>
                    </div>
                </div>
                <div style="margin-top: 15px; display: flex; gap: 10px;">
                    <span
                        style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 4px; font-size: 0.9rem;">
                        ✅
                        <?= $d['agreed'] ?> Agreed
                    </span>
                    <span
                        style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 4px; font-size: 0.9rem;">
                        ❌
                        <?= $d['disagreed'] ?> Disagreed
                    </span>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($data)): ?>
            <p>No verification data available yet.</p>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>