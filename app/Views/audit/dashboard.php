<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="max-width: 1400px; margin-top: 40px;">
    
    <div class="flex-between align-center mb-4">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.05); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <i data-feather="shield" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h1 class="page-title" style="margin-bottom: 2px; font-size: 1.5rem;">Quality Assurance Hub</h1>
                <p class="text-muted" style="margin: 0; font-size: 0.9rem;">
                    Perform class verifications & generate compliance reports
                </p>
            </div>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 6px 12px; display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
                <div class="pulsing-dot" style="width: 6px; height: 6px; border-radius: 50%; background: var(--success);"></div> IQA Active
            </span>
            <?= component('button', ['href' => APP_URL . '/dashboard', 'label' => 'Exit Hub', 'variant' => 'outline']) ?>
        </div>
    </div>

    <!-- Active Audit Stats -->
    <div class="grid-3 mb-4" style="gap: 20px;">
        <div class="card" style="padding: 24px; text-align: center; border-bottom: 4px solid var(--primary);">
            <div style="font-size: 2.5rem; font-weight: 800; color: var(--text-primary); line-height: 1; margin-bottom: 8px;"><?= $stats['total'] ?></div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Assigned Frameworks</div>
        </div>
        
        <div class="card" style="padding: 24px; text-align: center; border-bottom: 4px solid var(--success);">
            <div style="font-size: 2.5rem; font-weight: 800; color: var(--success); line-height: 1; margin-bottom: 8px;"><?= $stats['completed'] ?></div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Completed Audits</div>
        </div>

        <div class="card" style="padding: 24px; text-align: center; border-bottom: 4px solid var(--warning);">
            <div style="font-size: 2.5rem; font-weight: 800; color: var(--warning); line-height: 1; margin-bottom: 8px;"><?= $stats['pending'] ?></div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Pending Verification</div>
        </div>
    </div>

    <div style="margin-top: 40px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px dashed var(--border-color);">
        <h3 style="font-size: 1.15rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px; margin: 0;">
            <i data-feather="inbox" style="color: var(--secondary); width: 18px;"></i> Active System Assignments
        </h3>
    </div>

    <?php if (empty($assigned)): ?>
        <div class="card p-5 text-center" style="border: 2px dashed var(--border-color); background: #f8fafc;">
            <i data-feather="slash" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
            <h4 style="font-size: 1.1rem; color: var(--text-primary);">No Pending Assignments</h4>
            <p style="color: var(--text-muted); margin-bottom: 0;">You have not been assigned any frameworks for internal verification.</p>
        </div>
    <?php else: ?>
        <div class="grid-3" style="gap: 20px;">
            <?php foreach ($assigned as $a):
                $isStarted = (bool) $a['session_id'];
                $isCompleted = $a['session_status'] === 'Completed';
                $progress = 0;
                if ($isStarted) $progress = $isCompleted ? 100 : 50;
            ?>
                <div class="card popup-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="padding: 20px; flex: 1; background: white;">
                        <div class="flex-between align-start" style="margin-bottom: 15px;">
                            <span style="font-family: monospace; font-size: 0.8rem; background: var(--bg-app); padding: 4px 8px; border-radius: 4px; border: 1px solid var(--border-color); color: var(--text-primary);">
                                <?= htmlspecialchars($a['unit_code']) ?>
                            </span>
                            
                            <?php if ($isCompleted): ?>
                                <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2);"><i data-feather="check" style="width: 12px; margin-right: 4px;"></i> Verified</span>
                            <?php elseif ($isStarted): ?>
                                <span class="badge" style="background: rgba(59, 130, 246, 0.1); color: var(--primary); border: 1px solid rgba(59, 130, 246, 0.2);"><i data-feather="loader" style="width: 12px; margin-right: 4px;"></i> In Progress</span>
                            <?php else: ?>
                                <span class="badge" style="background: #f1f5f9; color: var(--text-muted); border: 1px solid var(--border-color);">Pending</span>
                            <?php endif; ?>
                        </div>

                        <h4 style="font-size: 1.05rem; margin-bottom: 15px; color: var(--text-primary); line-height: 1.4;">
                            <?= htmlspecialchars($a['unit_title']) ?>
                        </h4>

                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div style="display: flex; align-items: flex-start; gap: 8px; font-size: 0.85rem; color: var(--text-muted);">
                                <i data-feather="book" style="width: 14px; margin-top: 2px;"></i>
                                <span style="line-height: 1.3;"><?= htmlspecialchars($a['course_title']) ?></span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 15px; font-size: 0.85rem; color: var(--text-muted); background: #f8fafc; padding: 6px 10px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <i data-feather="users" style="width: 14px;"></i> <?= htmlspecialchars($a['class_code']) ?>
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px; font-weight: 600;">
                                    <?= $a['population'] ?> Candidates
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="padding: 15px 20px; background: #f8fafc; border-top: 1px solid var(--border-color);">
                        <?php if ($isStarted): ?>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">
                                    <span>Audit Progress</span>
                                    <span><?= $progress ?>%</span>
                                </div>
                                <div style="height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                                    <div style="height: 100%; width: <?= $progress ?>%; background: var(--primary);"></div>
                                </div>
                            </div>
                            
                            <?php if ($isCompleted): ?>
                                <?= component('button', ['href' => APP_URL . '/audit/report?id=' . $a['session_id'], 'label' => 'View Final Report', 'variant' => 'outline', 'class' => 'w-100', 'icon' => 'file-text']) ?>
                            <?php else: ?>
                                <?= component('button', ['href' => APP_URL . '/audit/perform?id=' . $a['session_id'], 'label' => 'Resume Audit Session', 'variant' => 'primary', 'class' => 'w-100', 'icon' => 'play']) ?>
                            <?php endif; ?>
                            
                        <?php else: ?>
                            <?php if ($a['population'] > 0): ?>
                                <?= component('button', ['href' => APP_URL . '/audit/setup?unit_id=' . $a['unit_id'] . '&class_id=' . $a['class_id'], 'label' => 'Initiate Target Audit', 'variant' => 'success', 'class' => 'w-100', 'icon' => 'crosshair']) ?>
                            <?php else: ?>
                                <button class="btn btn-outline w-100" disabled style="background: white; color: var(--text-muted); border-style: dashed; justify-content: center; font-size: 0.85rem;">
                                    <i data-feather="lock" style="width: 14px; margin-right: 6px;"></i> Empty Cohort Null
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>