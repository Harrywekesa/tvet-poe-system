<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1200px;">
    
    <!-- Breadcrumb -->
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i data-feather="arrow-left" style="width: 16px;"></i> Return to Dashboard
        </a>
    </div>

    <!-- Header Block -->
    <div style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <span class="badge badge-primary">Final Verification Marks</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;"><?= htmlspecialchars($unit['unit_code']) ?></span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;">My Academic Results</h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;"><?= htmlspecialchars($unit['unit_title']) ?></p>
    </div>

    <?php if (isset($isApproved) && $isApproved): ?>
        <div class="card" style="background: rgba(16,185,129,0.03); border: 1px solid rgba(16,185,129,0.3); border-left: 4px solid var(--success); margin-bottom: 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; padding: 24px;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(16,185,129,0.1); display: flex; align-items: center; justify-content: center; color: var(--success);">
                    <i data-feather="check-circle" style="width: 22px;"></i>
                </div>
                <div>
                    <strong style="color: #065f46; font-size: 1.15rem; display: block; margin-bottom: 4px;">Results Fully Verified & Approved</strong>
                    <span style="font-size: 0.95rem; color: #047857; display: block;">
                        Your final marks for this unit have been locked by the Internal Quality Assurer.
                    </span>
                </div>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <?= component('button', [
                    'href' => APP_URL . "/marks/print_result/{$unit['id']}?type=raw", 
                    'label' => 'Download Raw Report', 
                    'icon' => 'download',
                    'variant' => 'outline', 
                    'attrs' => 'target="_blank" style="color: #065f46; border-color: rgba(16,185,129,0.5); background: white;"'
                ]) ?>
                <?= component('button', [
                    'href' => APP_URL . "/marks/print_result/{$unit['id']}?type=weighted", 
                    'label' => 'Download Weighted PDF', 
                    'icon' => 'award',
                    'attrs' => 'target="_blank" style="background: var(--success); border-color: var(--success); color: white;"'
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="grid-main-side" style="margin-top: 10px; align-items: start; gap: 30px;">
        
        <!-- Left Pane: The Log of Assessments -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div style="display: flex; flex-direction: column; gap: 4px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 5px;">
                <h3 style="margin: 0; font-size: 1.25rem;">Atomic Assessment Grades</h3>
                <p class="text-muted" style="margin: 0; font-size: 0.95rem;">Breakdown of grades per specific task.</p>
            </div>

            <?php if (empty($unit['assessments'])): ?>
                 <div class="text-center text-muted" style="padding: 40px; background: var(--bg-app); border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
                    <i data-feather="slash" style="width: 32px; height: 32px; color: #cbd5e1; margin-bottom: 10px;"></i>
                    <p style="margin: 0;">No assessments found in this curriculum matrix.</p>
                </div>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <?php foreach ($unit['assessments'] as $slot): ?>
                        <div class="card" style="padding: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; border-left: 3px solid <?= ($slot['mark'] !== '-' ? 'var(--primary)' : 'var(--border-color)') ?>;">
                            
                            <div style="display: flex; align-items: flex-start; gap: 15px; flex: 1;">
                                <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(37,99,235,0.05); display: flex; align-items: center; justify-content: center; color: var(--primary); margin-top: 2px;">
                                    <i data-feather="target" style="width: 16px;"></i>
                                </div>
                                <div>
                                    <strong style="color: var(--text-primary); font-size: 1.1rem; display: block; margin-bottom: 6px;">
                                        <?= htmlspecialchars($slot['title']) ?>
                                    </strong>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <span style="font-size: 0.8rem; font-family: monospace; background: var(--bg-app); padding: 4px 8px; border-radius: 4px; color: var(--text-secondary); border: 1px solid var(--border-color);">
                                            <?= htmlspecialchars($slot['type']) ?>
                                        </span>
                                        <?php if ($slot['status'] == 'Submitted' || $slot['status'] == 'Graded'): ?>
                                            <?= component('badge', ['label' => 'Evidence Synced', 'variant' => 'success']) ?>
                                        <?php else: ?>
                                            <?= component('badge', ['label' => 'Evidence Pending', 'variant' => 'warning']) ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="text-align: right; min-width: 120px; background: #f8fafc; padding: 15px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
                                <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; margin-bottom: 4px;">Grader Input</div>
                                <?php if ($slot['mark'] !== '-'): ?>
                                    <div style="font-size: 1.75rem; font-weight: 800; color: var(--text-primary); line-height: 1;">
                                        <?= number_format($slot['mark'], 1) ?><span style="font-size: 1rem; color: var(--text-muted);">%</span>
                                    </div>
                                <?php else: ?>
                                    <div style="font-size: 1.5rem; font-weight: bold; color: #cbd5e1; line-height: 1;">-</div>
                                <?php endif; ?>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Pane: Totals -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <div class="card" style="padding: 30px; text-align: center; border-top: 4px solid var(--primary); background: #f8fafc;">
                <h4 style="margin-top: 0; color: var(--text-muted); font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px;">Final Computed Unit Vector</h4>
                
                <div style="font-size: 4rem; font-weight: 800; color: var(--primary); margin: 20px 0; line-height: 1; letter-spacing: -2px;">
                    <?= number_format($totals['final_mark'], 0) ?><span style="font-size: 2rem; color: var(--text-muted); letter-spacing: 0;">%</span>
                </div>
                
                <div style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; color: var(--text-primary); background: white; padding: 8px 16px; border-radius: 20px; border: 1px solid var(--border-color); font-weight: 500;">
                    <i data-feather="settings" style="width: 14px; color: var(--secondary);"></i> Weighted Algorithm Format: <?= htmlspecialchars($totals['level']) ?>
                </div>
            </div>

            <div class="card" style="padding: 24px;">
                <h5 style="margin-top: 0; margin-bottom: 20px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">
                    <i data-feather="pie-chart" style="width: 18px; color: var(--secondary);"></i> Granular Topic Weighting
                </h5>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <?php if (empty($totals['topics'])): ?>
                        <div style="color: var(--text-muted); font-size: 0.9rem; font-style: italic;">No specific topics aggregated.</div>
                    <?php else: ?>
                        <?php foreach ($totals['topics'] as $t): ?>
                            <div style="border: 1px solid var(--border-color); border-radius: var(--radius-sm); overflow: hidden;">
                                <div style="background: #f8fafc; padding: 10px 15px; font-weight: 600; color: var(--text-primary); font-size: 0.95rem; border-bottom: 1px solid var(--border-color);">
                                    <?= htmlspecialchars($t['title']) ?>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 15px; background: white;">
                                    <div style="font-size: 0.9rem; color: var(--text-secondary);">
                                        System Weight: <strong style="color: var(--text-primary); font-family: monospace;"><?= number_format($t['weight'], 0) ?>%</strong>
                                    </div>
                                    <div style="font-size: 1.05rem; font-weight: 700; color: var(--primary);">
                                        <?= number_format($t['score'], 1) ?>%
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>