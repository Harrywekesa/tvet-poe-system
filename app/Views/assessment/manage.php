<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <?php if (($_SESSION['role'] ?? '') === 'Trainer'): ?>
            <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/institution/course/<?= $unit['course_id'] ?>" class="btn btn-outline">&larr; Back to
                Course</a>
        <?php endif; ?>
    </div>

    <h1>Assessments:
        <?= htmlspecialchars($unit['unit_code']) ?>
    </h1>
    <p class="text-secondary">
        <?= htmlspecialchars($unit['unit_title']) ?>
    </p>

    <div class="grid-main-side" style="margin-top: 30px; align-items: start;">

        <!-- List -->
        <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <h3>Defined Assessments</h3>
            <p class="text-secondary" style="font-size: 0.9rem; margin-bottom: 20px;">Evidence slots students must
                submit to.</p>

            <?php if (empty($slots)): ?>
                <div style="text-align: center; padding: 30px; color: #94a3b8; background: #f8fafc; border-radius: 8px;">
                    No assessments defined for this unit yet.
                </div>
            <?php else: ?>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach ($slots as $s): ?>
                        <li
                            style="padding: 15px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 600; font-size: 1rem;">
                                    <?= htmlspecialchars($s['title']) ?>
                                    <span
                                        style="font-size: 0.8rem; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; border: 1px solid #cbd5e1; margin-left: 8px;">
                                        <?= htmlspecialchars($s['type']) ?>
                                    </span>
                                    <?php if (!empty($s['topic_title'])): ?>
                                        <span
                                            style="font-size: 0.8rem; background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px; border: 1px solid #7dd3fc; margin-left: 8px;">
                                            Topic: <?= htmlspecialchars($s['topic_title']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div style="color: #64748b; font-size: 0.9rem; margin-top: 4px;">
                                    <?= htmlspecialchars($s['instructions']) ?>
                                    <?php if (!empty($s['file_path'])): ?>
                                        <div style="margin-top: 5px;">
                                            <a href="<?= APP_URL ?>/uploads/assessments/<?= htmlspecialchars($s['file_path']) ?>"
                                                target="_blank" style="color: #2563eb; font-size: 0.85rem; text-decoration: none;">
                                                📄 View Question Paper
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <a href="<?= APP_URL ?>/assessment/delete/<?= $s['id'] ?>" class="btn btn-outline"
                                style="color: #ef4444; border-color: #ef4444; font-size: 0.8rem; padding: 4px 10px;"
                                onclick="return confirm('Are you sure? This will delete all student submissions for this slot!');">Delete</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Add Form -->
        <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <h3>Add Assessment Slot</h3>

            <form action="<?= APP_URL ?>/assessment/store" method="POST" enctype="multipart/form-data"
                style="margin-top: 20px; display: flex; flex-direction: column; gap: 15px;">
                <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">

                <div>
                    <label style="display: block; font-size: 0.9rem; margin-bottom: 5px;">Title</label>
                    <input type="text" name="title" placeholder="e.g. Assessment 1 (Written)" required
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.9rem; margin-bottom: 5px;">Topic (Element)</label>
                    <select name="topic_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                        <option value="">Select Topic...</option>
                        <?php foreach ($topics as $t): ?>
                            <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['title']) ?>
                                (<?= $t['sequence_order'] ?>)</option>
                        <?php endforeach; ?>
                        <option value="">-- General / No Topic --</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 0.9rem; margin-bottom: 5px;">Type</label>
                    <select name="type" required
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                        <option value="Written">Written Assessment</option>
                        <option value="Practical">Practical Assessment</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 0.9rem; margin-bottom: 5px;">Question Paper / Guide
                        (PDF/Image)</label>
                    <input type="file" name="assessment_file" accept=".pdf,.png,.jpg,.jpeg"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.9rem; margin-bottom: 5px;">Instructions /
                        Requirements</label>
                    <textarea name="instructions" placeholder="e.g. Upload scanned PDF of answer booklet."
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; min-height: 80px;"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Create Slot</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>