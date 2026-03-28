<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4" style="max-width: 1000px;">
    
    <div class="flex-between align-center" style="margin-bottom: 30px;">
        <div>
            <h1 class="page-title">Reports & Analytics</h1>
            <p class="text-muted">Generate formal documents and monitor system-wide assessment quality.</p>
        </div>
        <div>
            <?= component('button', ['href' => APP_URL . '/dashboard', 'label' => '&larr; Dashboard', 'variant' => 'outline']) ?>
        </div>
    </div>

    <div class="grid-2" style="gap: 24px;">
        
        <!-- Standard Reports -->
        <div class="card" style="display: flex; flex-direction: column;">
            <div style="margin-bottom: 20px;">
                <div style="width: 48px; height: 48px; background: var(--bg-app); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                    <i data-feather="file-text" style="color: var(--primary); width: 24px;"></i>
                </div>
                <h3 style="margin-top: 0; font-size: 1.25rem; color: var(--text-primary);">Generate Matrix Report</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.5;">Print official Class Matrices, Student transcripts, and detailed unit-level achievements.</p>
            </div>
            
            <div style="margin-top: auto; padding-top: 20px; border-top: 1px dashed var(--border-color);">
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 15px;">
                    <i data-feather="info" style="width: 14px; vertical-align: -2px;"></i> Matrix reports are scoped to specific classes. Navigate to a class via your dashboard to generate its reports.
                </p>
                <?= component('button', ['href' => APP_URL . '/dashboard', 'label' => 'Go to Dashboard', 'class' => 'w-100']) ?>
            </div>
        </div>

        <!-- Audit Logs (Admin) -->
        <div class="card" style="display: flex; flex-direction: column;">
            <div style="margin-bottom: 20px;">
                <div style="width: 48px; height: 48px; background: var(--bg-app); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                    <i data-feather="list" style="color: var(--secondary); width: 24px;"></i>
                </div>
                <h3 style="margin-top: 0; font-size: 1.25rem; color: var(--text-primary);">System Audit Logs</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.5;">View the immutable trail of system activities, logins, and data modifications.</p>
            </div>
            
            <div style="margin-top: auto;">
                <?= component('button', [
                    'href' => APP_URL . '/reports/index', 
                    'label' => 'View Activity Logs', 
                    'variant' => 'outline',
                    'class' => 'w-100'
                ]) ?>
            </div>
        </div>

    </div>

    <!-- Admin & IV Advanced Analytics -->
    <?php if ($role === 'InternalVerifier' || $role === 'Admin'): ?>
        <div class="card" style="margin-top: 30px; border-left: 4px solid var(--primary);">
            <div style="margin-bottom: 25px;">
                <h3 style="margin-top: 0; display: flex; align-items: center; gap: 10px; font-size: 1.25rem;">
                    <i data-feather="pie-chart" style="color: var(--primary);"></i> Quality Assurance Analytics
                </h3>
                <p style="color: var(--text-muted);">High-level verification tracking and trainer consistency metrics.</p>
            </div>
            
            <div class="grid-3" style="gap: 15px; margin-bottom: 30px;">
                <a href="<?= APP_URL ?>/reports/iv_analytics?type=progress" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: rgba(37, 99, 235, 0.05); border: 1px solid rgba(37, 99, 235, 0.2); border-radius: var(--radius-md); text-decoration: none; color: var(--primary); font-weight: 500; transition: all 0.2s;">
                    <i data-feather="trending-up" style="width: 18px;"></i> IV Progress Coverage
                </a>
                <a href="<?= APP_URL ?>/reports/iv_analytics?type=consistency" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: rgba(234, 179, 8, 0.05); border: 1px solid rgba(234, 179, 8, 0.3); border-radius: var(--radius-md); text-decoration: none; color: #a16207; font-weight: 500; transition: all 0.2s;">
                    <i data-feather="activity" style="width: 18px;"></i> Trainer Consistency
                </a>
                <a href="<?= APP_URL ?>/reports/iv_analytics?type=dept" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: var(--radius-md); text-decoration: none; color: #047857; font-weight: 500; transition: all 0.2s;">
                    <i data-feather="grid" style="width: 18px;"></i> Department Quality
                </a>
            </div>

            <div style="background: var(--bg-app); padding: 20px; border-radius: var(--radius-md); border: 1px dashed var(--border-color);">
                <h4 style="margin-top: 0; margin-bottom: 15px; font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="download-cloud" style="width: 18px; color: var(--secondary);"></i> Export Detailed Findings Report
                </h4>
                
                <form action="<?= APP_URL ?>/reports/iv_detailed" method="GET" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; margin: 0;">
                    <div style="flex: 1; min-width: 250px;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-secondary);">Target Department</label>
                        <select name="dept_id" class="form-control" required>
                            <option value="">Select Department...</option>
                            <?php if (isset($departments)): ?>
                                <?php foreach ($departments as $d): ?>
                                    <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Generate QA Report</button>
                    </div>
                </form>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 10px; margin-bottom: 0;">Produces a granular, printable QA report mapping compliance across all courses and levels within the selected department.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>