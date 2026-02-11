<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px; max-width: 1000px;">
    <div style="margin-bottom: 20px;">
        <!-- We need class_id to go back to class. If not available, go to dashboard. -->
        <?php $backLink = isset($class_id) ? APP_URL . "/academic/class/$class_id" : APP_URL . "/dashboard"; ?>
        <a href="<?= $backLink ?>" class="btn btn-outline">&larr; Back</a>
    </div>

    <h1>Grading:
        <?= htmlspecialchars($studentName) ?>
    </h1>
    <h3 class="text-secondary">
        <?= htmlspecialchars($unit['unit_title']) ?> (
        <?= htmlspecialchars($unit['unit_code']) ?>)
    </h3>

    <div
        style="background: #e0f2fe; padding: 15px; border-radius: 8px; border: 1px solid #7dd3fc; margin-bottom: 20px;">
        <strong>Assessment Level:</strong>
        <?= $unit['assessment_level'] ?>
        (
        <?= $unit['assessment_level'] == 'Level 6' ? '40% Written / 60% Practical' :
            ($unit['assessment_level'] == 'Level 5' ? '30% Written / 70% Practical' : '10% Written / 90% Practical') ?>)
    </div>

    <form action="<?= APP_URL ?>/marks/save" method="POST">
        <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">
        <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
        <input type="hidden" name="student_id" value="<?= $studentId ?>">

        <?php foreach ($matrix as $topicId => $group): ?>
            <?php if (empty($group['slots']))
                continue; ?>

            <div
                style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 25px;">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 15px;">
                    <h3 style="margin: 0;">
                        <?php if ($topicId == 0): ?>
                            General Assessments
                        <?php else: ?>
                            Topic:
                            <?= htmlspecialchars($group['topic']['title']) ?>
                        <?php endif; ?>
                    </h3>
                    <?php if ($topicId != 0): ?>
                        <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 12px; font-size: 0.9rem;">
                            Weight:
                            <?= number_format($group['topic']['weight_percentage'], 0) ?>%
                        </span>
                    <?php endif; ?>
                </div>

                <table class="table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Assessment Title</th>
                            <th style="width: 15%;">Type</th>
                            <th style="width: 25%;">POE Status</th>
                            <th style="width: 20%;">Mark (0-100)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($group['slots'] as $slot): ?>
                            <tr>
                                <td>
                                    <strong>
                                        <?= htmlspecialchars($slot['title']) ?>
                                    </strong>
                                    <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 5px;">
                                        <?= htmlspecialchars($slot['instructions'] ?? 'No instructions provided.') ?>
                                    </div>
                                </td>
                                <td>
                                    <?= $slot['type'] ?>
                                </td>
                                <td>
                                    <?php if ($slot['status'] == 'Submitted'): ?>
                                        <span style="color: green;">Submitted</span>
                                        <br>
                                        <a href="<?= APP_URL ?>/preview/submission/<?= $slot['submission_id'] ?>" target="_blank"
                                            style="font-size: 0.85rem;">View File</a>
                                    <?php elseif ($slot['status'] == 'Graded'): ?>
                                        <span style="color: blue;">Graded</span>
                                    <?php else: ?>
                                        <span style="color: #94a3b8;">Not Submitted</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <input type="number" name="marks[<?= $slot['id'] ?>]" value="<?= $slot['mark'] ?>"
                                        class="form-control" min="0" max="100" step="0.01" placeholder="Enter mark">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>

        <div
            style="position: sticky; bottom: 20px; background: white; padding: 15px; border-radius: 8px; border: 1px solid #cbd5e1; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); display: flex; justify-content: flex-end; align-items: center; gap: 15px;">
            <div style="margin-right: auto; font-size: 0.9rem; color: #64748b;">
                Changes are saved when you click "Save Marks".
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 10px 30px; font-size: 1.1rem;">Save
                Marks</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>