<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/academic/class/<?= $class['id'] ?>" class="btn btn-outline">&larr; Back to Class</a>
    </div>

    <h1>Review Evidence</h1>
    <p class="text-secondary">
        <?= htmlspecialchars($unit['unit_title']) ?> (<?= htmlspecialchars($class['class_code']) ?>)
    </p>

    <!-- Filter / Stats -->
    <div
        style="margin-top: 20px; padding: 15px; background: white; border-radius: 8px; border: 1px solid #e2e8f0; display: flex; flex-wrap: wrap; gap: 20px; align-items: center;">
        <div>
            <strong>Total Students:</strong> <?= count($students) ?>
        </div>
        <div>
            <strong>Assessment Slots:</strong> <?= count($slots) ?>
        </div>
    </div>

    <div style="margin-top: 30px; overflow-x: auto;">
        <input type="text" id="reviewScan" onkeyup="searchTable('reviewScan', 'reviewTable')"
            placeholder="Search student name..."
            style="width: 300px; max-width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #cbd5e1; border-radius: 4px;">
        <table id="reviewTable"
            style="width: 100%; border-collapse: collapse; min-width: 600px; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
            <thead>
                <tr style="background: #f8fafc; text-align: left;">
                    <th
                        style="padding: 10px; text-align: left; position: sticky; left: 0; background: #fff; z-index: 10;">
                        Student
                    </th>
                    <th style="padding: 10px; min-width: 100px;">Reg No.</th>
                    <?php foreach ($slots as $slot): ?>
                        <th style="padding: 12px; border-bottom: 2px solid #e2e8f0; font-size: 0.85rem; min-width: 150px;">
                            <?= htmlspecialchars($slot['title']) ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td
                            style="padding: 12px; font-weight: 500; position: sticky; left: 0; background: white; z-index: 10; border-right: 1px solid #f1f5f9;">
                            <?= htmlspecialchars($student['full_name']) ?>
                            <div style="font-size: 0.75rem; color: #64748b; font-weight: normal;">
                                <?= htmlspecialchars($student['email']) ?>
                            </div>
                        </td>
                        <td style="padding: 12px; font-size: 0.9rem; color: #64748b;">
                            <?= htmlspecialchars($student['identifier'] ?? '-') ?>
                        </td>
                        <td style="padding: 12px; font-size: 0.9rem; color: #64748b;">
                            <?= htmlspecialchars($student['reg_no']) ?>
                        </td>
                        <?php foreach ($slots as $slot): ?>
                            <?php
                            $sub = $matrix[$student['id']][$slot['id']] ?? null;
                            $status = $sub ? $sub['status'] : 'Missing';
                            $color = match ($status) {
                                'Approved' => '#16a34a',
                                'Rejected' => '#dc2626',
                                'Submitted' => '#2563eb',
                                'Missing' => '#94a3b8',
                                default => '#64748b'
                            };
                            $bg = match ($status) {
                                'Approved' => '#f0fdf4',
                                'Rejected' => '#fef2f2',
                                'Submitted' => '#eff6ff',
                                default => '#f8fafc'
                            };
                            ?>
                            <td style="padding: 12px; background: <?= $bg ?>;">
                                <div style="display: flex; flex-direction: column; gap: 5px;">
                                    <span style="font-size: 0.8rem; font-weight: 600; color: <?= $color ?>;">
                                        <?= $status ?>
                                    </span>
                                    <?php if (!empty($sub['latest_comment'])): ?>
                                        <div
                                            style="font-size: 0.7rem; color: #475569; background: #fff; padding: 2px 4px; border: 1px solid #cbd5e1; border-radius: 3px; max-width: 140px; white-space: normal;">
                                            "<?= htmlspecialchars($sub['latest_comment']) ?>"
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($sub): ?>
                                        <div style="font-size: 0.75rem; color: #64748b;">Ver: <?= $sub['version'] ?></div>
                                        <a href="<?= APP_URL ?>/preview/submission/<?= $sub['id'] ?>" target="_blank"
                                            class="btn btn-outline"
                                            style="padding: 2px 8px; font-size: 0.75rem; width: fit-content;">Preview</a>

                                        <!-- Trainer Controls -->
                                        <?php if ($status === 'Submitted' && $_SESSION['role'] === 'Trainer'): ?>
                                            <div style="display: flex; gap: 5px; margin-top: 5px;">
                                                <form action="<?= APP_URL ?>/review/status" method="POST" style="display: inline;">
                                                    <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
                                                    <input type="hidden" name="status" value="Approved">
                                                    <input type="hidden" name="comments" value="Quick Approval">
                                                    <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                                    <button type="submit"
                                                        style="background: none; border: none; cursor: pointer; color: #16a34a; font-size: 1.2rem;"
                                                        title="Approve">✓</button>
                                                </form>
                                                <form action="<?= APP_URL ?>/review/status" method="POST" style="display: inline;">
                                                    <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <input type="hidden" name="comments" value="Quick Rejection">
                                                    <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                                    <button type="submit"
                                                        style="background: none; border: none; cursor: pointer; color: #dc2626; font-size: 1.2rem;"
                                                        title="Reject">✗</button>
                                                </form>
                                            </div>
                                        <?php endif; ?>

                                        <!-- IV Controls -->
                                        <?php if ($_SESSION['role'] === 'InternalVerifier' && $status === 'Approved'): ?>
                                            <div style="margin-top: 8px; border-top: 1px dashed #cbd5e1; padding-top: 4px;">
                                                <span style="font-size: 0.7rem; color: #64748b; display: block;">IV Status:
                                                    <?= $sub['verification_status'] ?? 'None' ?></span>

                                                <?php if (($sub['verification_status'] ?? 'None') === 'None'): ?>
                                                    <form action="<?= APP_URL ?>/review/verify" method="POST" style="display: inline;">
                                                        <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
                                                        <input type="hidden" name="status" value="Sampled">
                                                        <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                                        <button type="submit" class="btn btn-outline"
                                                            style="font-size: 0.7rem; padding: 2px 5px; margin-top: 2px;">Sample</button>
                                                    </form>
                                                <?php elseif (($sub['verification_status'] ?? '') === 'Sampled'): ?>
                                                    <div style="display: flex; gap: 5px; margin-top: 2px;">
                                                        <form action="<?= APP_URL ?>/review/verify" method="POST" style="display: inline;">
                                                            <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
                                                            <input type="hidden" name="status" value="Verified">
                                                            <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                                            <button type="submit"
                                                                style="color: #16a34a; background:none; border:none; cursor:pointer;"
                                                                title="Verify">✓</button>
                                                        </form>
                                                        <form action="<?= APP_URL ?>/review/verify" method="POST" style="display: inline;">
                                                            <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
                                                            <input type="hidden" name="status" value="IV_Rejected">
                                                            <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                                            <button type="submit"
                                                                style="color: #dc2626; background:none; border:none; cursor:pointer;"
                                                                title="Reject">✗</button>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        <span style="font-size: 0.75rem; color: #cbd5e1;">-</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>