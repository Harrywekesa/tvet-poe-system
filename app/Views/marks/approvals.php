<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px; max-width: 1000px;">
    <h1>Marksheet Approvals</h1>
    <p class="text-secondary">Pending approvals for HOD and IQS verification.</p>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <?php if (empty($pending)): ?>
            <p>No marksheets require your immediate attention.</p>
        <?php else: ?>
            <h4 style="margin-top: 0; color: #b45309;">⏳ Pending Action</h4>
            <table class="table" style="width: 100%; margin-bottom: 30px;">
                <thead>
                    <tr>
                        <th>Date Submitted</th>
                        <th>Class / Unit</th>
                        <th>Trainer</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending as $p): ?>
                        <tr>
                            <td><?= date('Y-m-d H:i', strtotime($p['submitted_at'])) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($p['class_code']) ?></strong><br>
                                <small><?= htmlspecialchars($p['unit_code']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($p['trainer_name']) ?></td>
                            <td>
                                <span class="badge badge-warning"><?= str_replace('_', ' ', $p['status']) ?></span>
                            </td>
                            <td>
                                <a href="<?= APP_URL ?>/marks/marksheet/<?= $p['unit_id'] ?>/<?= $p['class_id'] ?>"
                                    class="btn btn-primary btn-sm">Review</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if (!empty($history)): ?>
            <h4 style="margin-top: 30px; color: #64748b;">📜 Approval History</h4>
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Last Action</th>
                        <th>Class / Unit</th>
                        <th>Trainer</th>
                        <th>HOD Approved</th>
                        <th>Status</th>
                        <th>Comments / Reason</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $h): ?>
                        <tr>
                            <td>
                                <?php
                                // Last Action Date
                                $d = $h['iqs_action_at'] ?? $h['hod_action_at'] ?? $h['submitted_at'];
                                echo date('Y-m-d H:i', strtotime($d));
                                ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($h['class_code']) ?></strong><br>
                                <small><?= htmlspecialchars($h['unit_code']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($h['trainer_name']) ?></td>
                            <td>
                                <?php if ($h['hod_action_at']): ?>
                                    <?= date('Y-m-d H:i', strtotime($h['hod_action_at'])) ?>
                                    <span class="text-secondary">(<?= htmlspecialchars($h['hod_name'] ?? 'HOD') ?>)</span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                $color = '#64748b';
                                if (strpos($h['status'], 'Approved') !== false)
                                    $color = 'green';
                                if (strpos($h['status'], 'Rejected') !== false)
                                    $color = 'red';
                                ?>
                                <span style="font-weight: bold; color: <?= $color ?>;">
                                    <?= str_replace('_', ' ', $h['status']) ?>
                                </span>
                            </td>
                            <td style="font-size: 0.9rem; color: #475569; max-width: 250px;">
                                <?php
                                $comment = '';
                                if (strpos($h['status'], 'IQS') !== false) {
                                    $comment = $h['iqs_comments'];
                                    echo "<span style='color:#7c3aed; font-weight:bold; font-size:0.8rem;'>IQS:</span> ";
                                } elseif (strpos($h['status'], 'HOD') !== false) {
                                    $comment = $h['hod_comments'];
                                    echo "<span style='color:#059669; font-weight:bold; font-size:0.8rem;'>HOD:</span> ";
                                }
                                echo nl2br(htmlspecialchars($comment ?? ''));
                                ?>
                            </td>
                            <td>
                                <a href="<?= APP_URL ?>/marks/marksheet/<?= $h['unit_id'] ?>/<?= $h['class_id'] ?>"
                                    class="btn btn-outline btn-sm">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>