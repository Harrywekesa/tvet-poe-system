<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
    </div>

    <h1>Cohort Management</h1>
    <p class="text-secondary">manage academic intakes and sessions.</p>

    <div class="grid-main-side" style="margin-top: 20px;">

        <!-- Cohort List -->
        <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <h3>Intakes / Cohorts</h3>
            <ul style="margin-top: 20px; list-style: none; padding: 0;">
                <?php foreach ($cohorts as $c): ?>
                    <li
                        style="padding: 15px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="font-weight: 600; font-size: 1.1rem; display: block;">
                                <?= htmlspecialchars($c['name']) ?>
                            </span>
                            <span style="color: #64748b; font-size: 0.9rem;">
                                <?= $c['start_date'] ?> to
                                <?= $c['end_date'] ?? 'Ongoing' ?>
                            </span>
                        </div>
                        <a href="<?= APP_URL ?>/academic/cohort/<?= $c['id'] ?>" class="btn btn-primary"
                            style="padding: 6px 15px; font-size: 0.9rem;">Manage Classes</a>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($cohorts)): ?>
                    <li style="color: #64748b; padding: 10px;">No cohorts found.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Add Form -->
        <?php if ($_SESSION['role'] === 'Admin'): ?>
            <div
                style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; height: fit-content;">
                <h3>New Cohort</h3>
                <form action="<?= APP_URL ?>/academic/cohort" method="POST" style="margin-top: 20px;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px;">Cohort Name</label>
                        <input type="text" name="name" placeholder="e.g. Jan 2024 Intake" required
                            style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px;">Start Date</label>
                        <input type="date" name="start_date"
                            style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px;">End Date (Optional)</label>
                        <input type="date" name="end_date"
                            style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Create Cohort</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>