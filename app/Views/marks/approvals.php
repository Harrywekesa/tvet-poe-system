<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1000px;">
    <div class="flex-between align-center" style="margin-bottom: 24px;">
        <div>
            <h1 class="page-title">Marksheet Approvals</h1>
            <p class="text-muted">Pending approvals for HOD and IQS verification.</p>
        </div>
        <div>
            <?= component('button', ['href' => APP_URL . '/dashboard', 'label' => '&larr; Dashboard', 'variant' => 'outline']) ?>
        </div>
    </div>

    <div class="card" style="margin-bottom: 30px;">
        <h3 style="margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
            <i data-feather="clock" style="color: var(--warning);"></i> 
            <span style="color: var(--text-primary);">Pending Action</span>
        </h3>
        
        <?php if (empty($pending)): ?>
            <div class="text-center text-muted" style="padding: 30px; background: var(--bg-app); border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
                <i data-feather="check-circle" style="width: 40px; height: 40px; color: var(--success); margin-bottom: 15px;"></i>
                <p style="margin: 0;">No marksheets require your immediate attention. You're all caught up!</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Date Submitted</th>
                            <th style="width: 25%;">Class / Unit</th>
                            <th style="width: 20%;">Trainer</th>
                            <th style="width: 20%;">Status</th>
                            <th style="width: 15%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending as $p): ?>
                            <tr>
                                <td style="color: var(--text-muted); font-size: 0.9rem;">
                                    <?= date('Y-m-d H:i', strtotime($p['submitted_at'])) ?>
                                </td>
                                <td>
                                    <strong style="color: var(--text-primary); display: block; margin-bottom: 4px;"><?= htmlspecialchars($p['class_code']) ?></strong>
                                    <span style="font-size: 0.8rem; background: var(--bg-app); padding: 2px 6px; border-radius: 4px; color: var(--text-muted);">
                                        <?= htmlspecialchars($p['unit_code']) ?>
                                    </span>
                                </td>
                                <td style="font-weight: 500;">
                                    <?= htmlspecialchars($p['trainer_name']) ?>
                                </td>
                                <td>
                                    <?= component('badge', ['label' => str_replace('_', ' ', $p['status']), 'variant' => 'warning']) ?>
                                </td>
                                <td>
                                    <?= component('button', ['href' => APP_URL . "/marks/marksheet/{$p['unit_id']}/{$p['class_id']}", 'label' => 'Review', 'class' => 'w-100']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($history)): ?>
        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i data-feather="file-text" style="color: var(--secondary);"></i> 
                <span style="color: var(--text-primary);">Approval History</span>
            </h3>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Last Action</th>
                            <th style="width: 20%;">Class / Unit</th>
                            <th style="width: 15%;">Trainer</th>
                            <th style="width: 15%;">HOD Approved</th>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 20%;">Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $h): ?>
                            <tr>
                                <td style="font-size: 0.85rem; color: var(--text-muted);">
                                    <?php
                                    $d = $h['iqs_action_at'] ?? $h['hod_action_at'] ?? $h['submitted_at'];
                                    echo date('Y-m-d H:i', strtotime($d));
                                    ?>
                                </td>
                                <td>
                                    <strong style="color: var(--text-primary); display: block; margin-bottom: 4px;"><?= htmlspecialchars($h['class_code']) ?></strong>
                                    <span style="font-size: 0.8rem; background: var(--bg-app); padding: 2px 6px; border-radius: 4px; color: var(--text-muted);">
                                        <?= htmlspecialchars($h['unit_code']) ?>
                                    </span>
                                </td>
                                <td style="font-size: 0.9rem;">
                                    <?= htmlspecialchars($h['trainer_name']) ?>
                                </td>
                                <td style="font-size: 0.85rem; color: var(--text-muted);">
                                    <?php if ($h['hod_action_at']): ?>
                                        <?= date('Y-m-d H:i', strtotime($h['hod_action_at'])) ?><br>
                                        <span style="font-size: 0.75rem; color: var(--primary);">(<?= htmlspecialchars($h['hod_name'] ?? 'HOD') ?>)</span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $variant = 'info';
                                    if (strpos($h['status'], 'Approved') !== false) {
                                        $variant = 'success';
                                    } elseif (strpos($h['status'], 'Rejected') !== false) {
                                        $variant = 'danger';
                                    } elseif (strpos($h['status'], 'Review') !== false) {
                                        $variant = 'warning';
                                    }
                                    ?>
                                    <?= component('badge', ['label' => str_replace('_', ' ', $h['status']), 'variant' => $variant]) ?>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem; color: var(--text-muted); background: var(--bg-app); padding: 10px; border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
                                        <?php
                                        $comment = '';
                                        if (strpos($h['status'], 'IQS') !== false) {
                                            $comment = $h['iqs_comments'];
                                            echo "<strong style='color:var(--primary); font-size:0.75rem; text-transform:uppercase;'>IQS Note:</strong><br>";
                                        } elseif (strpos($h['status'], 'HOD') !== false) {
                                            $comment = $h['hod_comments'];
                                            echo "<strong style='color:var(--success); font-size:0.75rem; text-transform:uppercase;'>HOD Note:</strong><br>";
                                        }
                                        echo nl2br(htmlspecialchars($comment ?? 'None'));
                                        ?>
                                    </div>
                                    <div style="margin-top: 10px; text-align: right;">
                                        <a href="<?= APP_URL ?>/marks/marksheet/<?= $h['unit_id'] ?>/<?= $h['class_id'] ?>" style="font-size: 0.85rem; font-weight: 500; color: var(--primary); text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                            View Sheet &rarr;
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>