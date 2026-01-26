<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
    </div>

    <h1>Review Professional Documents</h1>
    <p class="text-secondary">Approve or reject documents submitted by trainers in your department.</p>

    <div style="display: grid; gap: 20px; margin-top: 20px;">
        <?php foreach ($pending as $d): ?>
            <div
                style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px;">
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

        <?php if (empty($pending)): ?>
            <div
                style="background: white; padding: 40px; text-align: center; border-radius: 8px; border: 1px solid #e2e8f0; color: #64748b;">
                No pending documents to review. Great job!
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>