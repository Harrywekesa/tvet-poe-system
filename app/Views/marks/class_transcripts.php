<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/academic/class_view/<?= $class['id'] ?>" class="btn btn-outline">&larr; Back to
            Class</a>
    </div>

    <h1>Transcripts:
        <?= htmlspecialchars($class['class_code']) ?>
    </h1>
    <p class="text-secondary">Manage and print student transcripts.</p>

    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <label for="classSelector" style="display: block; font-weight: 500; margin-bottom: 8px;">Switch Class:</label>
        <select id="classSelector"
            onchange="window.location.href='<?= APP_URL ?>/marks/class_transcripts/' + this.value"
            style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px;">
            <?php foreach ($allClasses as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $c['id'] == $class['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['class_code']) ?> - <?= htmlspecialchars($c['course_title']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Student List</h3>
        <p class="text-secondary" style="font-size: 0.9rem; margin-bottom: 20px;">Select a student to view/print their
            individual transcript.</p>

        <?php if (empty($students)): ?>
            <p>No students enrolled in this class.</p>
        <?php else: ?>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc; text-align: left;">
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Name</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Identifier</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $s): ?>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">
                                <?= htmlspecialchars($s['full_name']) ?>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #f1f5f9;">
                                <?= htmlspecialchars($s['identifier']) ?>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                <a href="<?= APP_URL ?>/marks/transcript/<?= $s['id'] ?>?type=raw" target="_blank"
                                    class="btn btn-outline" style="font-size: 0.85rem; margin-right: 5px;">
                                    Transcript (Raw)
                                </a>
                                <a href="<?= APP_URL ?>/marks/transcript/<?= $s['id'] ?>?type=weighted" target="_blank"
                                    class="btn btn-primary" style="font-size: 0.85rem;">
                                    Transcript (Weighted)
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 30px;">
        <h3>Bulk Actions</h3>
        <p class="text-secondary" style="font-size: 0.9rem; margin-bottom: 15px;">Generate transcripts for the entire
            class in a single PDF.</p>

        <div style="display: flex; gap: 10px;">
            <a href="<?= APP_URL ?>/marks/bulk_transcript/<?= $class['id'] ?>?type=raw" target="_blank"
                class="btn btn-outline" style="padding: 10px 20px;">
                Generate All (Raw)
            </a>
            <a href="<?= APP_URL ?>/marks/bulk_transcript/<?= $class['id'] ?>?type=weighted" target="_blank"
                class="btn btn-primary" style="padding: 10px 20px;">
                Generate All (Weighted)
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>