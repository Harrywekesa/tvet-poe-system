<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
    </div>

    <h1>Review Professional Documents</h1>
    <p class="text-secondary">Approve or reject documents submitted by trainers in your department.</p>

    <div style="display: grid; gap: 20px; margin-top: 20px;">
        <?php if (empty($pending)): ?>
            <p>No pending documents to review.</p>
        <?php else: ?>
            <h4 style="color: #b45309;">⏳ Pending Action</h4>
            <?php foreach ($pending as $d): ?>
                <div
                    style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.1rem;">
                            <?= htmlspecialchars($d['type']) ?>
                        </h3>
                        <p style="margin: 5px 0; color: #64748b; font-size: 0.9rem;">
                            Created:
                            <?= $d['created_at'] ?>
                        </p>
                        <div style="margin-top: 10px; font-size: 0.95rem;">
                            <strong>Trainer:</strong>
                            <?= htmlspecialchars($d['trainer_name']) ?><br>
                            <strong>Unit:</strong>
                            <?= htmlspecialchars($d['unit_code']) ?><br>
                            <strong>Class:</strong>
                            <?= htmlspecialchars($d['class_code']) ?>
                        </div>
                    </div>

                    <div style="min-width: 300px; display: flex; flex-direction: column; gap: 10px;">
                        <a href="<?= APP_URL ?>/preview/download?file=docs/<?= $d['file_path'] ?>" class="btn btn-outline"
                            target="_blank" style="text-align: center;">📄 View Document</a>

                        <form action="<?= APP_URL ?>/documents/status" method="POST"
                            style="background: #f8fafc; padding: 10px; border-radius: 6px;">
                            <input type="hidden" name="doc_id" value="<?= $d['id'] ?>">
                            <textarea name="comments" placeholder="Add comments (required for rejection)..."
                                style="width: 100%; border: 1px solid #cbd5e1; border-radius: 4px; padding: 8px; margin-bottom: 10px; font-family: inherit;"></textarea>
                            <div style="display: flex; gap: 10px;">
                                <button type="submit" name="status" value="Approved" class="btn btn-primary"
                                    style="background: #16a34a; border: none; flex: 1;">Approve</button>
                                <button type="submit" name="status" value="Rejected" class="btn btn-primary"
                                    style="background: #dc2626; border: none; flex: 1;">Reject</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($history)): ?>
            <h4 style="margin-top: 40px; color: #64748b;">📜 Approval History</h4>
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Trainer</th>
                        <th>Status</th>
                        <th>Comments</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $h): ?>
                        <tr>
                            <td><?= date('Y-m-d H:i', strtotime($h['created_at'])) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($h['type']) ?></strong><br>
                                <small><?= htmlspecialchars($h['unit_code']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($h['trainer_name']) ?></td>
                            <td>
                                <?php
                                $color = ($h['status'] == 'Approved') ? 'green' : 'red';
                                ?>
                                <span style="font-weight: bold; color: <?= $color ?>;">
                                    <?= $h['status'] ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($h['comments'] ?? '-') ?></td>
                            <td>
                                <?php if ($h['status'] === 'Approved'): ?>
                                    <a href="<?= APP_URL ?>/documents/certificate/<?= $h['id'] ?>" class="btn btn-outline btn-sm"
                                        target="_blank">View Stamped</a>
                                <?php else: ?>
                                    <a href="<?= APP_URL ?>/preview/download?file=docs/<?= $h['file_path'] ?>"
                                        class="btn btn-outline btn-sm" target="_blank">View File</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>