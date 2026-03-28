<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <h1>Confirm Import</h1>
    <p class="text-secondary">Review the data below before finalizing the import.</p>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3 style="margin-bottom: 15px;">
            Type:
            <?= ucfirst($type) ?>
            <span style="font-size: 0.9rem; font-weight: normal; color: #64748b;">
                (
                <?= count($valid_rows) ?> valid rows)
            </span>
        </h3>

        <?php if (!empty($valid_rows)): ?>
            <div style="overflow-x: auto;">
                <table class="table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc; text-align: left;">
                            <?php foreach (array_keys($valid_rows[0]) as $header): ?>
                                <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">
                                    <?= htmlspecialchars($header) ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($valid_rows as $row): ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <?php foreach ($row as $cell): ?>
                                    <td style="padding: 10px;">
                                        <?= htmlspecialchars($cell ?? '') ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 15px;">
                <form action="<?= APP_URL ?>/institution/import/commit" method="POST">
    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary">✅ Confirm & Import</button>
                </form>
                <a href="<?= APP_URL ?>/institution" class="btn btn-outline"
                    style="color: #dc2626; border-color: #dc2626;">Cancel</a>
            </div>

        <?php else: ?>
            <div class="alert" style="background: #fff1f2; color: #9f1239; padding: 15px; border: 1px solid #fecdd3;">
                No valid data found in the CSV. Please check the file format.
            </div>
            <div style="margin-top: 15px;">
                <a href="<?= APP_URL ?>/institution" class="btn btn-outline">Go Back</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>