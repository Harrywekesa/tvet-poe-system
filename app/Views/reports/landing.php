<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="margin-top: 40px;">
    <h1>Reports & Matrix</h1>
    <p>Generate formal documents.</p>

    <div style="background: white; padding: 30px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Generate Report</h3>
        <p>Please select a Unit to generate the Class Matrix / IV Report.</p>
        <p style="color: #64748b;">(Navigate to <a href="<?= APP_URL ?>/dashboard">Dashboard</a> > Unit to find specific
            report links)</p>

        <!-- Could add dropdown here later -->
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-primary">Go to Dashboard</a>
    </div>

    <?php if ($role === 'InternalVerifier' || $role === 'Admin'): ?>
        <div style="background: white; padding: 30px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
            <h3>Analytics & QA</h3>
            <p>High level verification reports.</p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="<?= APP_URL ?>/reports/iv_analytics?type=progress" class="btn btn-outline">📊 IV Progress
                    (Coverage)</a>
                <a href="<?= APP_URL ?>/reports/iv_analytics?type=consistency" class="btn btn-outline">📉 Trainer
                    Consistency</a>
                <a href="<?= APP_URL ?>/reports/iv_analytics?type=dept" class="btn btn-outline">🏢 Department Quality</a>
            </div>

            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px dashed #e2e8f0;">
                <h4>Generate Detailed Findings Report</h4>
                <form action="<?= APP_URL ?>/reports/iv_detailed" method="GET"
                    style="display: flex; gap: 10px; align-items: center;">
                    <select name="dept_id" required style="padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                        <option value="">Select Department...</option>
                        <?php if (isset($departments)): ?>
                            <?php foreach ($departments as $d): ?>
                                <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">Generate</button>
                </form>
                <p style="font-size: 0.8rem; color: #64748b; margin-top: 5px;">Produces granular report for all
                    courses/levels in dept.</p>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>