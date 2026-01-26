<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px; height: 85vh; display: flex; flex-direction: column;">
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <a href="javascript:history.back()" class="btn btn-outline">&larr; Back</a>
        <h2 style="margin: 0; font-size: 1.2rem;">
            <?= htmlspecialchars($title ?? 'Document Preview') ?>
        </h2>
        <?php if (isset($downloadUrl)): ?>
            <a href="<?= $downloadUrl ?>" download class="btn btn-primary">Download Order</a>
        <?php endif; ?>
    </div>

    <div style="flex: 1; background: #e2e8f0; border-radius: 8px; overflow: hidden; border: 1px solid #cbd5e1;">
        <?php if ($fileType === 'pdf'): ?>
            <iframe src="<?= $fileUrl ?>" style="width: 100%; height: 100%; border: none;"></iframe>
        <?php elseif (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])): ?>
            <div
                style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; overflow: auto;">
                <img src="<?= $fileUrl ?>" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 50px;">
                <p>Preview not available for this file type.</p>
                <a href="<?= $fileUrl ?>" class="btn btn-primary">Download File</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>