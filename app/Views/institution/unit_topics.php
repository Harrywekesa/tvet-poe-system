<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px; max-width: 900px;">
    <div style="margin-bottom: 20px;">
        <?php if (($_SESSION['role'] ?? '') === 'Trainer'): ?>
            <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/institution/unit/<?= $unit['id'] ?>" class="btn btn-outline">&larr; Back to Unit</a>
        <?php endif; ?>
    </div>

    <h1>Manage Topics for:
        <?= htmlspecialchars($unit['unit_title']) ?> (
        <?= htmlspecialchars($unit['unit_code']) ?>)
    </h1>

    <!-- Level Configuration -->
    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Assessment Level</h3>
        <p class="text-muted">This setting determines the Written/Practical ratio for grading.</p>
        <form action="<?= APP_URL ?>/unit/update_level" method="POST"
            style="display: flex; gap: 10px; align-items: center;">
    <?= csrf_field() ?>
            <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">
            <select name="assessment_level" class="form-control" style="max-width: 200px;">
                <option value="Level 6" <?= $unit['assessment_level'] == 'Level 6' ? 'selected' : '' ?>>Level 6 (40/60)
                </option>
                <option value="Level 5" <?= $unit['assessment_level'] == 'Level 5' ? 'selected' : '' ?>>Level 5 (30/70)
                </option>
                <option value="Level 4" <?= $unit['assessment_level'] == 'Level 4' ? 'selected' : '' ?>>Level 4 (10/90)
                </option>
            </select>
            <button type="submit" class="btn btn-primary">Update Level</button>
        </form>
    </div>

    <!-- Stats -->
    <div style="margin: 20px 0; display: flex; gap: 20px;">
        <div class="card" style="flex: 1; text-align: center; padding: 15px; border: 1px solid #e2e8f0;">
            <h4 style="margin:0;">Total Weight</h4>
            <div style="font-size: 24px; font-weight: bold; color: <?= $totalWeight == 100 ? 'green' : 'red' ?>;">
                <?= number_format($totalWeight, 0) ?>%
            </div>
            <?php if ($totalWeight != 100): ?>
                <small style="color: red;">Must equal 100%</small>
            <?php endif; ?>
        </div>
        <div class="card" style="flex: 1; text-align: center; padding: 15px; border: 1px solid #e2e8f0;">
            <h4 style="margin:0;">Topics</h4>
            <div style="font-size: 24px; font-weight: bold;">
                <?= count($topics) ?>
            </div>
        </div>
    </div>

    <!-- Topics List -->
    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
        <h3 style="margin-top: 0;">Existing Topics (Elements)</h3>

        <?php if (empty($topics)): ?>
            <p>No topics defined yet.</p>
        <?php else: ?>
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 10px;">Order</th>
                        <th style="padding: 10px;">Topic/Element Title</th>
                        <th style="padding: 10px;">Weight (%)</th>
                        <th style="padding: 10px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topics as $t): ?>
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 10px;">
                                <?= $t['sequence_order'] ?>
                            </td>
                            <td style="padding: 10px;">
                                <?= htmlspecialchars($t['title']) ?>
                            </td>
                            <td style="padding: 10px;">
                                <?= number_format($t['weight_percentage'], 0) ?>%
                            </td>
                            <td style="padding: 10px;">
                                <form action="<?= APP_URL ?>/topic/delete/<?= $t['id'] ?>" method="POST"
                                    onsubmit="return confirm('Are you sure?');" style="display:inline;">
    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Add Topic Form -->
    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Add New Topic</h3>
        <form action="<?= APP_URL ?>/topic/add" method="POST">
    <?= csrf_field() ?>
            <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">

            <div class="row" style="display: flex; gap: 15px;">
                <div style="flex: 3;">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required
                        placeholder="e.g. Identify Hardware Components">
                </div>
                <div style="flex: 1;">
                    <label>Weight (%)</label>
                    <input type="number" name="weight" class="form-control" required min="1" max="100" placeholder="20">
                </div>
                <div style="flex: 1;">
                    <label>Order</label>
                    <input type="number" name="sequence_order" class="form-control" value="<?= count($topics) + 1 ?>">
                </div>
            </div>

            <div style="margin-top: 15px;">
                <button type="submit" class="btn btn-primary">Add Topic</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>