<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="margin-top: 40px;">
    <a href="<?= APP_URL ?>/audit/unit?course_id=<?= $course_id ?>" class="btn btn-outline"
        style="margin-bottom: 20px;">&larr; Back to Classes</a>
    <h1>Select Unit to Audit</h1>
    <p>Class: <strong>
            <?= htmlspecialchars($class['class_code']) ?>
        </strong></p>

    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <?php foreach ($units as $u): ?>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 15px;">
                        <strong>
                            <?= htmlspecialchars($u['unit_code']) ?>
                        </strong>
                        <br>
                        <?= htmlspecialchars($u['unit_title']) ?>
                    </td>
                    <td style="padding: 15px; text-align: right;">
                        <a href="<?= APP_URL ?>/audit/workspace?class_id=<?= $class['id'] ?>&unit_id=<?= $u['id'] ?>"
                            class="btn btn-primary">Audit Unit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>