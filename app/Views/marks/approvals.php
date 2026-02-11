<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px; max-width: 1000px;">
    <h1>Marksheet Approvals</h1>
    <p class="text-secondary">Pending approvals for HOD and IQS verification.</p>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <?php if (empty($pending)): ?>
            <p>No pending approvals found.</p>
        <?php else: ?>
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Date Submitted</th>
                        <th>Class / Unit</th>
                        <th>Trainer</th>
                        <th>Current Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending as $p): ?>
                        <tr>
                            <td>
                                <?= date('Y-m-d H:i', strtotime($p['submitted_at'])) ?>
                            </td>
                            <td>
                                <strong>
                                    <?= htmlspecialchars($p['class_code']) ?>
                                </strong>
                                <div style="font-size: 0.85rem; color: #64748b;">
                                    <?= htmlspecialchars($p['unit_code']) ?> -
                                    <?= htmlspecialchars($p['unit_title']) ?>
                                </div>
                            </td>
                            <td>
                                <?= htmlspecialchars($p['trainer_name']) ?>
                            </td>
                            <td>
                                <span style="
                                padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;
                                <?= $p['status'] == 'Submitted_to_HOD' ? 'background:#fef3c7; color:#b45309;' :
                                    ($p['status'] == 'HOD_Approved' ? 'background:#dcfce7; color:#15803d;' : '') ?>
                            ">
                                    <?= str_replace('_', ' ', $p['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= APP_URL ?>/marks/marksheet/<?= $p['unit_id'] ?>/<?= $p['class_id'] ?>"
                                    class="btn btn-primary btn-sm">
                                    Review
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>