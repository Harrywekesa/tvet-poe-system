<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="margin-top: 40px;">
    <h1>
        <?= $title ?>
    </h1>
    <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline" style="margin-bottom: 20px;">&larr; Back</a>

    <div style="background: white; padding: 25px; border-radius: 8px; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: left;">Unit</th>
                    <th style="padding: 12px; text-align: left;">Class</th>
                    <th style="padding: 12px;">Submitted</th>
                    <th style="padding: 12px;">Verified</th>
                    <th style="padding: 12px;">Coverage %</th>
                    <th style="padding: 12px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row):
                    $cov = $row['total_submitted'] > 0 ? round(($row['total_verified'] / $row['total_submitted']) * 100) : 0;
                    ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 12px;">
                            <strong>
                                <?= htmlspecialchars($row['unit_code']) ?>
                            </strong><br>
                            <small>
                                <?= htmlspecialchars($row['unit_title']) ?>
                            </small>
                        </td>
                        <td style="padding: 12px;">
                            <?= htmlspecialchars($row['class_code']) ?>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <?= $row['total_submitted'] ?>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <?= $row['total_verified'] ?>
                        </td>
                        <td
                            style="padding: 12px; text-align: center; font-weight: bold; color: <?= $cov >= 20 ? 'green' : 'orange' ?>">
                            <?= $cov ?>%
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="<?= APP_URL ?>/marks/marksheet/<?= $row['unit_id'] ?>/<?= $row['class_id'] ?>"
                                title="View Marksheet" style="text-decoration: none; margin-right: 10px;">📋</a>
                            <a href="<?= APP_URL ?>/audit/workspace?class_id=<?= $row['class_id'] ?>&unit_id=<?= $row['unit_id'] ?>"
                                title="Audit Workspace" style="text-decoration: none;">🔍</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>