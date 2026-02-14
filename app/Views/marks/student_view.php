<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px; max-width: 900px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
    </div>

    <h1>My Marks:
        <?= htmlspecialchars($unit['unit_title']) ?>
    </h1>
    <h3 class="text-secondary">
        <?= htmlspecialchars($unit['unit_code']) ?>
    </h3>

    <?php if (isset($isApproved) && $isApproved): ?>
        <div
            style="margin-top: 15px; padding: 15px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 1.5rem;">✅</span>
                <div>
                    <strong style="color: #166534;">Result Verified & Approved</strong>
                    <div style="font-size: 0.85rem; color: #15803d;">
                        This result has been officially verified by the Internal Quality Assurer.
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="<?= APP_URL ?>/marks/print_result/<?= $unit['id'] ?>?type=raw" target="_blank"
                    class="btn btn-primary" style="background: #166534; border-color: #166534;">
                    Download Result (Raw)
                </a>
                <a href="<?= APP_URL ?>/marks/print_result/<?= $unit['id'] ?>?type=weighted" target="_blank"
                    class="btn btn-outline" style="color: #166534; border-color: #166534; background: white;">
                    Download Result (Weighted)
                </a>
            </div>
        </div>
    <?php endif; ?>

    <div class="row" style="margin-top: 30px; display: flex; gap: 20px;">
        <div style="flex: 2;">
            <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <h3>Assessments & Progress</h3>

                <table class="table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Assessment</th>
                            <th>Type</th>
                            <th>Submisison</th>
                            <th>Mark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($unit['assessments'] as $slot): ?>
                            <tr>
                                <td>
                                    <strong>
                                        <?= htmlspecialchars($slot['title']) ?>
                                    </strong>
                                </td>
                                <td>
                                    <?= $slot['type'] ?>
                                </td>
                                <td>
                                    <?php if ($slot['status'] == 'Submitted' || $slot['status'] == 'Graded'): ?>
                                        <span style="color: green;">Submitted</span>
                                    <?php else: ?>
                                        <span style="color: #94a3b8;">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($slot['mark'] !== '-'): ?>
                                        <strong>
                                            <?= number_format($slot['mark'], 1) ?>%
                                        </strong>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="flex: 1;">
            <div
                style="background: #f0fdf4; padding: 25px; border-radius: 8px; border: 1px solid #bbf7d0; text-align: center;">
                <h4 style="margin-top: 0; color: #166534;">Final Unit Mark</h4>
                <div style="font-size: 3rem; font-weight: bold; color: #15803d; margin: 10px 0;">
                    <?= number_format($totals['final_mark'], 0) ?>%
                </div>
                <div style="font-size: 0.9rem; color: #166534;">
                    Based on
                    <?= $totals['level'] ?> Weighting
                </div>
            </div>

            <div
                style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
                <h5 style="margin-top: 0;">Topic Breakdown</h5>
                <ul style="padding-left: 20px; margin-bottom: 0;">
                    <?php foreach ($totals['topics'] as $t): ?>
                        <li style="margin-bottom: 8px;">
                            <div><strong>
                                    <?= htmlspecialchars($t['title']) ?>
                                </strong></div>
                            <div style="font-size: 0.85rem; display: flex; justify-content: space-between;">
                                <span>Score:
                                    <?= number_format($t['score'], 1) ?>%
                                </span>
                                <span class="text-muted">(Weight:
                                    <?= number_format($t['weight'], 0) ?>%)
                                </span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>