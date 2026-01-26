<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="margin-top: 40px;">
    <h1>
        <?= $title ?>
    </h1>
    <a href="<?= APP_URL ?>/reports" class="btn btn-outline" style="margin-bottom: 20px;">&larr; Back</a>

    <div style="background: white; padding: 25px; border-radius: 8px; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: left;">Department</th>
                    <th style="padding: 12px;">Active Courses</th>
                    <th style="padding: 12px;">Total Evidence</th>
                    <th style="padding: 12px;">Pass Rate</th>
                    <th style="padding: 12px;">IV Coverage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row):
                    $passRate = $row['total_evidence'] > 0 ? round(($row['passed_evidence'] / $row['total_evidence']) * 100) : 0;
                    $ivRate = $row['total_evidence'] > 0 ? round(($row['verified_evidence'] / $row['total_evidence']) * 100) : 0;
                    ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 12px; font-weight: 500;">
                            <?= htmlspecialchars($row['dept_name']) ?>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <?= $row['active_courses'] ?>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <?= $row['total_evidence'] ?>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="color: <?= $passRate >= 80 ? 'green' : ($passRate >= 50 ? 'orange' : 'red') ?>">
                                <?= $passRate ?>%
                            </span>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <div
                                style="background: #e2e8f0; border-radius: 4px; height: 8px; width: 100px; display: inline-block; overflow: hidden;">
                                <div style="background: #2563eb; width: <?= $ivRate ?>%; height: 100%;"></div>
                            </div>
                            <small style="margin-left: 5px;">
                                <?= $ivRate ?>%
                            </small>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>