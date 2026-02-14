<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <!-- Simple Back history or link to dashboard -->
        <a href="<?= APP_URL ?>/poe/dashboard" class="btn btn-outline">&larr; Back</a>
    </div>

    <h1>Evidence:
        <?= htmlspecialchars($unit['unit_title']) ?>
    </h1>

    <div style="margin-top: 30px; display: flex; flex-direction: column; gap: 30px;">
        <?php foreach ($slots as $s): ?>
            <?php
            // Find latest submission for this slot
            $mySub = null;
            if (isset($submissions[$s['id']])) {
                // Assuming last is latest if multiple, or sort
                $mySub = end($submissions[$s['id']]);
            }
            $isSubmitted = !empty($mySub);
            $status = $isSubmitted ? $mySub['status'] : 'Not Submitted';
            $color = match ($status) {
                'Approved' => '#16a34a',
                'Rejected' => '#dc2626',
                'Submitted' => '#2563eb',
                default => '#94a3b8'
            };
            ?>

            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px;">
                <div class="flex-between" style="margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h3 style="margin-bottom: 5px;">
                            <?= htmlspecialchars($s['title']) ?>
                        </h3>
                        <p style="color: #64748b; font-size: 0.9rem;">
                            <?= htmlspecialchars($s['instructions']) ?>
                        </p>
                    </div>
                    <span
                        style="padding: 6px 12px; border-radius: 20px; color: white; background: <?= $color ?>; font-size: 0.85rem; font-weight: 600;">
                        <?= $status ?>
                    </span>
                </div>

                <?php if ($isSubmitted && !empty($mySub['latest_comment'])): ?>
                    <div
                        style="margin-bottom: 15px; padding: 12px; background: #fff1f2; border-left: 4px solid #e11d48; border-radius: 4px; color: #881337;">
                        <strong>Feedback:</strong> <?= htmlspecialchars($mySub['latest_comment']) ?>
                    </div>
                <?php endif; ?>

                <?php if ($status === 'Approved' || $status === 'Verified'): ?>
                    <div
                        style="padding: 15px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; color: #166534;">
                        ✅ Evidence Locked & Verified. <a href="<?= APP_URL ?>/poe/view/<?= $mySub['id'] ?>" target="_blank"
                            class="btn btn-sm"
                            style="margin-left:10px; background:#16a34a; color:white; text-decoration:none;">View Certificate &
                            File</a>
                    </div>
                <?php else: ?>
                    <div class="grid-main-side" style="align-items: center;">
                        <div>
                            <?php if ($isSubmitted): ?>
                                <p style="font-size: 0.9rem; margin-bottom: 10px;">
                                    Current File: <a href="<?= APP_URL ?>/preview/submission/<?= $mySub['id'] ?>" target="_blank"
                                        style="color: #2563eb;">
                                        📄 Preview Evidence
                                    </a><br>
                                    <small style="color: #64748b;">Uploaded:
                                        <?= $mySub['submitted_at'] ?>
                                    </small>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Upload Form -->
                        <form action="<?= APP_URL ?>/poe/upload" method="POST" enctype="multipart/form-data"
                            class="form-grid-3">
                            <input type="hidden" name="slot_id" value="<?= $s['id'] ?>">
                            <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">

                            <input type="file" name="evidence_file" required style="width: 100%;">

                            <button type="submit" class="btn btn-primary" style="white-space: nowrap;">
                                <?= $isSubmitted ? 'Re-Upload' : 'Upload Evidence' ?>
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <?php if (empty($slots)): ?>
            <p>No assessment slots defined for this unit. Contact your trainer.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>