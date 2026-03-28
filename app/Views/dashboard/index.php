<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="flex-between mb-4">
    <div>
        <h1 style="margin-bottom: 4px;">Dashboard</h1>
        <p class="text-muted">Welcome back, <strong><?= htmlspecialchars($name) ?></strong> (<?= $role ?><?= isset($dept_name) ? ", " . htmlspecialchars($dept_name) : '' ?>)</p>
    </div>
</div>

<!-- Role Specific Content -->
<?php if ($role === 'Admin'): ?>

    <!-- Admin Stats -->
    <div class="grid-3 mb-4">
        <div class="card" style="border-left: 4px solid var(--primary);">
            <div class="text-muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Total Users</div>
            <div style="font-size: 2rem; font-weight: 700; color: var(--accent);"><?= $counts['users'] ?></div>
        </div>
        <div class="card" style="border-left: 4px solid var(--success);">
            <div class="text-muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Active Content</div>
            <div style="font-size: 2rem; font-weight: 700; color: var(--accent);">
                <?= $counts['courses'] ?><span style="font-size:1rem; color:var(--text-muted); font-weight:400; margin-left: 5px;">courses</span>
            </div>
        </div>
        <div class="card" style="border-left: 4px solid var(--warning);">
            <div class="text-muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Classes</div>
            <div style="font-size: 2rem; font-weight: 700; color: var(--accent);"><?= $counts['classes'] ?></div>
        </div>
    </div>

    <div class="grid-main-side" style="align-items: start;">
        <!-- Cohort Status -->
        <div class="card">
            <h3 class="mb-3">Cohort Status</h3>
            <div class="grid-2 mb-4">
                <div style="text-align: center; padding: 15px; background: #ecfdf5; border-radius: var(--radius-md); border: 1px solid #a7f3d0;">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #059669;"><?= count($active_cohorts) ?></div>
                    <div style="font-size: 0.8rem; color: #065f46;">Active Cohorts</div>
                </div>
                <div style="text-align: center; padding: 15px; background: #fef2f2; border-radius: var(--radius-md); border: 1px solid #fecaca;">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #dc2626;"><?= count($closed_cohorts) ?></div>
                    <div style="font-size: 0.8rem; color: #991b1b;">Closed Cohorts</div>
                </div>
            </div>

            <h4 class="mb-2">Active Cohorts Countdown</h4>
            <ul style="list-style: none; padding: 0;">
                <?php foreach ($active_cohorts as $ac): ?>
                    <li style="padding: 12px 0; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong style="color: var(--accent);"><?= htmlspecialchars($ac['name']) ?></strong><br>
                            <small class="text-muted">Ends: <?= $ac['end_date'] ?? 'N/A' ?></small>
                        </div>
                        <div class="countdown-timer" data-end="<?= $ac['end_date'] ?>" style="font-family: monospace; background: var(--bg-sidebar); color: var(--white); padding: 4px 8px; border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 500;">
                            Calculating...
                        </div>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($active_cohorts)): ?>
                    <li class="text-muted" style="padding: 12px 0;">No active cohorts.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Quick Links -->
        <div class="card" style="display: flex; flex-direction: column; gap: 10px;">
            <h4 class="mb-2">Quick Management</h4>
            <p class="text-muted mb-2" style="font-size: 0.85rem;">Access core modules.</p>
            <?= component('button', ['href' => APP_URL . '/users', 'label' => 'Manage Users', 'variant' => 'outline', 'class' => 'w-100']) ?>
            <?= component('button', ['href' => APP_URL . '/academic', 'label' => 'Academic & Cohorts', 'variant' => 'outline', 'class' => 'w-100']) ?>
            <?= component('button', ['href' => APP_URL . '/institution', 'label' => 'Institution Setup', 'variant' => 'outline', 'class' => 'w-100']) ?>
        </div>
    </div>

<?php elseif ($role === 'Trainer'): ?>
    <div class="mb-4">
        <h3 class="mb-2">My Allocated Units</h3>
        <p class="text-muted mb-4">Manage assessments and review evidence for your classes.</p>

        <?php if (empty($allocations)): ?>
            <?= component('alert', ['message' => 'No units have been allocated to you yet.', 'variant' => 'info']) ?>
        <?php else: ?>
            <div class="grid-3">
                <?php foreach ($allocations as $a): ?>
                    <div class="card">
                        <h4 style="margin-bottom: 4px;"><?= htmlspecialchars($a['unit_title']) ?></h4>
                        <div class="text-muted mb-2" style="font-size: 0.9rem; font-weight: 500;">
                            <?= htmlspecialchars($a['unit_code']) ?>
                        </div>
                        <div class="mb-4">
                            <?= component('badge', ['label' => 'Class: ' . htmlspecialchars($a['class_code']), 'variant' => 'secondary']) ?>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div class="grid-2" style="gap: 8px;">
                                <?= component('button', ['href' => APP_URL . '/assessment/manage/' . $a['id'], 'label' => 'Assessments', 'variant' => 'outline', 'class' => 'w-100']) ?>
                                <?= component('button', ['href' => APP_URL . '/unit/topics/' . $a['id'], 'label' => 'Topics', 'variant' => 'outline', 'class' => 'w-100']) ?>
                            </div>

                            <?= component('button', ['href' => APP_URL . "/marks/grade/{$a['id']}/{$a['class_id']}/0", 'label' => 'Grade Class', 'variant' => 'primary', 'class' => 'w-100']) ?>

                            <div class="grid-2" style="gap: 8px;">
                                <?= component('button', ['href' => APP_URL . "/review/unit/{$a['id']}/class/{$a['class_id']}", 'label' => 'Review', 'variant' => 'outline', 'class' => 'w-100']) ?>
                                <?= component('button', ['href' => APP_URL . "/marks/marksheet/{$a['id']}/{$a['class_id']}", 'label' => 'Marksheet', 'variant' => 'outline', 'class' => 'w-100']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <h3 class="mb-2">Active Classes</h3>
        <p class="text-muted mb-4">Select a class to manage units and self-allocate.</p>
        <div class="grid-3">
            <?php if (!empty($all_classes)): ?>
                <?php foreach ($all_classes as $c): ?>
                    <div class="card flex-between" style="flex-direction: column; align-items: stretch;">
                        <div>
                            <h4 style="margin-bottom: 4px;"><?= htmlspecialchars($c['class_code']) ?></h4>
                            <p class="text-muted mb-4" style="font-size: 0.9rem; font-weight: 500;">
                                <?= htmlspecialchars($c['course_title']) ?>
                            </p>
                        </div>
                        <?= component('button', ['href' => APP_URL . '/academic/class/' . $c['id'], 'label' => 'View Class', 'variant' => 'outline', 'class' => 'w-100']) ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
<?php elseif ($role === 'InternalVerifier'): ?>
    <!-- Quick Actions -->
    <div class="grid-2 mb-4">
        <div class="card" style="border-left: 4px solid var(--primary);">
            <h3 style="color: var(--primary); margin-bottom: 8px;">Start Full Audit</h3>
            <p class="text-muted mb-4" style="font-size: 0.9rem;">
                Begin a new audit cycle by selecting a Department and Course.
            </p>
            <div style="display: flex; gap: 10px;">
                <?= component('button', ['href' => APP_URL . '/audit', 'label' => 'Start New Audit', 'variant' => 'primary', 'icon' => 'play-circle']) ?>
                <?= component('button', ['href' => APP_URL . '/marks/approvals', 'label' => 'Check Approvals', 'variant' => 'outline']) ?>
            </div>
        </div>

        <div class="card" style="border-left: 4px solid var(--info);">
            <h3 style="color: var(--info); margin-bottom: 8px;">QA Reports</h3>
            <p class="text-muted mb-4" style="font-size: 0.9rem;">
                Generate detailed findings and consistency reports.
            </p>
            <?= component('button', ['href' => APP_URL . '/reports/iv_analytics', 'label' => 'View Reports', 'variant' => 'outline', 'icon' => 'bar-chart-2']) ?>
        </div>
    </div>

    <div class="mb-4">
        <h3 class="mb-2">Internal Verification</h3>
        <p class="text-muted mb-4">Sample and verify approved assessments.</p>

        <?php if (empty($iv_allocations)): ?>
            <?= component('alert', ['message' => 'No units assigned for verification.', 'variant' => 'info']) ?>
        <?php else: ?>
            <div class="grid-3">
                <?php foreach ($iv_allocations as $a): ?>
                    <div class="card">
                        <h4 style="margin-bottom: 4px;"><?= htmlspecialchars($a['unit_title']) ?></h4>
                        <div class="text-muted mb-3" style="font-size: 0.9rem; font-weight: 500;">
                            <?= htmlspecialchars($a['unit_code']) ?>
                        </div>

                        <div class="flex-between mb-4">
                            <?= component('badge', ['label' => 'Class: ' . htmlspecialchars($a['class_code']), 'variant' => 'secondary']) ?>
                            <span style="color: var(--success); font-weight: 600; font-size: 0.85rem;"><?= $a['approved_count'] ?> Approved</span>
                        </div>

                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <?= component('button', ['href' => APP_URL . "/verification/list/{$a['id']}/class/{$a['class_id']}", 'label' => 'Verify Samples', 'variant' => 'primary', 'class' => 'w-100']) ?>
                            <div class="grid-2 w-100" style="gap: 8px;">
                                <?= component('button', ['href' => APP_URL . "/marks/marksheet/{$a['id']}/{$a['class_id']}", 'label' => 'Marksheet', 'variant' => 'outline', 'class' => 'w-100']) ?>
                                <?= component('button', ['href' => APP_URL . '/audit', 'label' => 'Audit Hub', 'variant' => 'outline', 'class' => 'w-100']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php elseif ($role === 'HOD'): ?>
    <div class="mb-4">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
            <div>
                <h3 class="mb-2" style="font-size: 1.5rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="briefcase" style="color: var(--primary);"></i> Department Overview
                </h3>
                <p class="text-muted mb-4">Managing Active Division: <strong style="color: var(--text-primary);"><?= htmlspecialchars($dept_name ?? 'Unassigned') ?></strong></p>
            </div>
            <?php if (isset($pending_docs) && count($pending_docs) > 0): ?>
                <div style="background: rgba(239, 68, 68, 0.05); border: 1px dashed rgba(239, 68, 68, 0.4); border-radius: var(--radius-md); padding: 12px 20px; display: inline-flex; align-items: center; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #b91c1c; font-weight: 600;">
                        <i data-feather="alert-circle" style="width: 20px;"></i>
                        Action Required: <?= count($pending_docs) ?> Pending Doc<?= count($pending_docs) > 1 ? 's' : '' ?>
                    </div>
                    <?= component('button', ['href' => APP_URL . '/documents/review', 'label' => 'Review Now', 'variant' => 'danger', 'class' => 'btn-sm']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="grid-3 mb-4">
            <div class="card" style="display: flex; align-items: center; gap: 15px; padding: 24px;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.05); border: 1px solid rgba(37,99,235,0.1); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                    <i data-feather="users" style="width: 24px; height: 24px;"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Active Classes</div>
                    <div style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); line-height: 1.2;"><?= count($dept_classes ?? []) ?></div>
                </div>
                <?= component('button', ['href' => APP_URL . '/academic', 'label' => 'Manage', 'variant' => 'outline', 'class' => 'btn-sm mt-2 w-100', 'style' => 'grid-column: 1 / -1;']) ?>
            </div>

            <div class="card" style="display: flex; align-items: center; gap: 15px; padding: 24px;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16,185,129,0.05); border: 1px solid rgba(16,185,129,0.1); display: flex; align-items: center; justify-content: center; color: var(--success);">
                    <i data-feather="layers" style="width: 24px; height: 24px;"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Courses</div>
                    <div style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); line-height: 1.2;"><?= count($my_courses ?? []) ?></div>
                </div>
                <?= component('button', ['href' => APP_URL . '/institution/department/' . $dept_id, 'label' => 'Curriculum', 'variant' => 'outline', 'class' => 'btn-sm mt-2 w-100', 'style' => 'grid-column: 1 / -1;']) ?>
            </div>

            <div class="card" style="display: flex; align-items: center; gap: 15px; padding: 24px;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(139,92,246,0.05); border: 1px solid rgba(139,92,246,0.1); display: flex; align-items: center; justify-content: center; color: #8b5cf6;">
                    <i data-feather="shield" style="width: 24px; height: 24px;"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Trainers</div>
                    <div style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); line-height: 1.2;"><?= count($trainers ?? []) ?></div>
                </div>
                <?= component('button', ['href' => APP_URL . '/users?dept=' . $dept_id, 'label' => 'View Team', 'variant' => 'outline', 'class' => 'btn-sm mt-2 w-100', 'style' => 'grid-column: 1 / -1;']) ?>
            </div>
        </div>

        <!-- Reports Card -->
        <div class="card mb-4" style="background: linear-gradient(135deg, rgba(37,99,235,0.02) 0%, rgba(37,99,235,0.05) 100%); border: 1px solid rgba(37,99,235,0.1);">
            <div class="flex-between align-center" style="margin-bottom: 15px;">
                <div>
                    <h4 class="mb-2" style="font-size: 1.15rem; color: var(--text-primary);"><i data-feather="bar-chart-2" style="width: 18px; color: var(--primary);"></i> Performance & Approvals</h4>
                    <p class="text-muted mb-3">Generate deep departmental statistics and sign off on internal queries.</p>
                </div>
            </div>
            <div class="grid-2" style="gap: 15px;">
                <?= component('button', ['href' => APP_URL . '/reports/dept_overview', 'label' => 'Generate Dept Stats', 'variant' => 'outline', 'class' => 'w-100', 'icon' => 'pie-chart']) ?>
                <?= component('button', ['href' => APP_URL . '/marks/approvals', 'label' => 'Pending Verification Hub', 'variant' => 'primary', 'class' => 'w-100', 'icon' => 'check-square']) ?>
            </div>
        </div>
    </div>

    <!-- HOD Teaching Allocations -->
    <?php if (!empty($allocations)): ?>
        <div style="margin-top: 40px; border-top: 1px dashed var(--border-color); padding-top: 30px;">
            <h3 class="mb-2" style="display: flex; align-items: center; gap: 8px;">
                <i data-feather="award" style="color: var(--secondary);"></i> My Teaching Allocations
            </h3>
            <p class="text-muted mb-4">Units you are directly assessing outside of managerial duties.</p>
            <div class="grid-3">
                <?php foreach ($allocations as $a): ?>
                    <div class="card popup-card" style="transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                            <h4 style="margin: 0; font-size: 1.1rem; line-height: 1.4;"><?= htmlspecialchars($a['unit_title']) ?></h4>
                        </div>
                        <div class="text-muted mb-3" style="font-size: 0.85rem; font-family: monospace; background: var(--bg-app); padding: 4px 8px; border-radius: 4px; display: inline-block; border: 1px solid var(--border-color);">
                            <?= htmlspecialchars($a['unit_code']) ?>
                        </div>
                        <div class="mb-4">
                            <?= component('badge', ['label' => 'Class: ' . htmlspecialchars($a['class_code']), 'variant' => 'secondary']) ?>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div class="grid-2" style="gap: 8px;">
                                <?= component('button', ['href' => APP_URL . '/assessment/manage/' . $a['id'], 'label' => 'Assessments', 'variant' => 'outline', 'class' => 'w-100 btn-sm']) ?>
                                <?= component('button', ['href' => APP_URL . '/unit/topics/' . $a['id'], 'label' => 'Topics Matrix', 'variant' => 'outline', 'class' => 'w-100 btn-sm']) ?>
                            </div>

                            <?= component('button', ['href' => APP_URL . "/marks/grade/{$a['id']}/{$a['class_id']}/0", 'label' => 'Launch Grader', 'variant' => 'primary', 'class' => 'w-100', 'icon' => 'edit-3']) ?>

                            <div class="grid-2" style="gap: 8px;">
                                <?= component('button', ['href' => APP_URL . "/review/unit/{$a['id']}/class/{$a['class_id']}", 'label' => 'Evidence Review', 'variant' => 'outline', 'class' => 'w-100 btn-sm']) ?>
                                <?= component('button', ['href' => APP_URL . "/marks/marksheet/{$a['id']}/{$a['class_id']}", 'label' => 'Marksheet', 'variant' => 'outline', 'class' => 'w-100 btn-sm']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>


<?php elseif ($role === 'Student'): ?>

    <!-- Student Stats -->
    <div class="grid-3 mb-4">
        <div class="card" style="display: flex; align-items: center; gap: 15px; padding: 24px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.05); border: 1px solid rgba(37,99,235,0.1); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <i data-feather="book-open" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <div class="text-muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Enrolled Classes</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); line-height: 1.2;"><?= count($classes) ?></div>
            </div>
        </div>
        
        <div class="card" style="display: flex; align-items: center; gap: 15px; padding: 24px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245,158,11,0.05); border: 1px solid rgba(245,158,11,0.1); display: flex; align-items: center; justify-content: center; color: var(--warning);">
                <i data-feather="clock" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <div class="text-muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Pending Submissions</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); line-height: 1.2;"><?= $pending_count ?></div>
            </div>
        </div>
        
        <div class="card" style="display: flex; align-items: flex-start; gap: 15px; padding: 24px; <?= $rejected_count > 0 ? 'border: 1px solid rgba(239,68,68,0.3); background: rgba(239,68,68,0.02);' : '' ?>">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.1); display: flex; align-items: center; justify-content: center; color: var(--danger);">
                <i data-feather="alert-triangle" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <div class="text-muted" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Rejected POEs</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: var(--danger); line-height: 1.2;"><?= $rejected_count ?></div>
                <?php if($rejected_count > 0): ?>
                    <div style="font-size: 0.75rem; color: var(--danger); font-weight: 600; margin-top: 4px; display: inline-flex; align-items: center; gap: 4px;"><i data-feather="alert-circle" style="width: 12px;"></i> Action Required</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- POE Hero Banner -->
    <div class="card mb-4" style="background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%); color: white; padding: 32px 40px; border-radius: var(--radius-lg); position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(37,99,235,0.2);">
        <i data-feather="folder" style="position: absolute; right: -20px; top: -20px; width: 150px; height: 150px; color: rgba(255,255,255,0.05); transform: rotate(-15deg);"></i>
        
        <div style="position: relative; z-index: 1;">
            <span class="badge" style="background: rgba(255,255,255,0.2); color: white; margin-bottom: 12px; font-family: monospace;">Core Operation</span>
            <h3 style="color: white; margin-bottom: 8px; font-size: 1.75rem; font-weight: 700;">My Portfolio of Evidence</h3>
            <p style="color: rgba(255,255,255,0.8); margin-bottom: 24px; font-size: 1.05rem; max-width: 600px; line-height: 1.5;">Access your enrolled classes, upload photographic evidence, manage critical documentation, and actively track assessment loops.</p>
            
            <a href="<?= APP_URL ?>/poe/dashboard" class="btn" style="background: white; color: var(--accent); font-weight: 600; padding: 12px 24px; border-radius: var(--radius-md); box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: inline-flex; align-items: center; gap: 8px; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                Launch Dashboard <i data-feather="arrow-right" style="width: 16px;"></i>
            </a>
        </div>
    </div>

    <div class="grid-main-side" style="align-items: start; gap: 30px;">
        
        <!-- Left Pane: My Units -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div style="display: flex; flex-direction: column; gap: 4px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 5px;">
                <h3 style="margin: 0; font-size: 1.25rem;">Curriculum Modules</h3>
                <p class="text-muted" style="margin: 0; font-size: 0.95rem;">Review individual topic marks and unit progression strictly.</p>
            </div>

            <?php if (!empty($my_units)): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                    <?php foreach ($my_units as $u): ?>
                        <div class="card popup-card" style="padding: 20px; transition: transform 0.2s, border-color 0.2s; display: flex; flex-direction: column; justify-content: space-between; border: 1px solid var(--border-color); cursor: pointer;"
                             onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-2px)';" 
                             onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='translateY(0)';">
                            <div style="margin-bottom: 25px;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(37,99,235,0.05); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                        <i data-feather="bookmark" style="width: 16px;"></i>
                                    </div>
                                </div>
                                <h4 style="margin: 0; font-size: 1.1rem; color: var(--text-primary); font-weight: 700; margin-bottom: 6px; line-height: 1.4;">
                                    <?= htmlspecialchars($u['unit_title']) ?>
                                </h4>
                                <div class="text-muted" style="font-size: 0.85rem; font-weight: 500; font-family: monospace;">
                                    <?= htmlspecialchars($u['unit_code']) ?>
                                </div>
                            </div>
                            <div>
                                <?= component('button', [
                                    'href' => APP_URL . '/marks/my_view/' . $u['id'], 
                                    'label' => 'View Marksheet', 
                                    'variant' => 'outline', 
                                    'class' => 'w-100',
                                    'icon' => 'bar-chart-2'
                                ]) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <?= component('alert', ['message' => 'You are not dynamically enrolled in any units yet.', 'variant' => 'info']) ?>
            <?php endif; ?>
        </div>

        <!-- Right Pane: Term Transcripts -->
        <div>
            <div class="card" style="background: #f8fafc; border: 1px solid var(--border-color); position: sticky; top: 20px;">
                <h4 style="margin-top: 0; margin-bottom: 6px; font-size: 1.15rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="file-text" style="color: var(--secondary);"></i> Term Transcripts
                </h4>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px; line-height: 1.5;">Generate official terminal transcripts for internal reviews or sponsor submissions.</p>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    
                    <a href="<?= APP_URL ?>/marks/transcript/<?= $_SESSION['user_id'] ?>?type=weighted" class="card popup-card" style="display: flex; align-items: center; gap: 12px; padding: 16px; text-decoration: none; border: 1px solid var(--border-color); transition: all 0.2s;"
                       onmouseover="this.style.borderColor='var(--primary)'; this.style.boxShadow='var(--shadow-sm)';" 
                       onmouseout="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none';">
                        <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(16,185,129,0.05); display: flex; align-items: center; justify-content: center; color: var(--success); flex-shrink: 0;">
                            <i data-feather="award" style="width: 18px;"></i>
                        </div>
                        <div>
                            <strong style="display: block; font-size: 0.95rem; color: var(--text-primary); margin-bottom: 2px;">Weighted Transcript</strong>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">Calculated final grades</span>
                        </div>
                        <i data-feather="chevron-right" style="margin-left: auto; color: var(--text-muted); width: 16px;"></i>
                    </a>

                    <a href="<?= APP_URL ?>/marks/transcript/<?= $_SESSION['user_id'] ?>?type=raw" class="card popup-card" style="display: flex; align-items: center; gap: 12px; padding: 16px; text-decoration: none; border: 1px solid var(--border-color); transition: all 0.2s;"
                       onmouseover="this.style.borderColor='var(--warning)'; this.style.boxShadow='var(--shadow-sm)';" 
                       onmouseout="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none';">
                        <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(245,158,11,0.05); display: flex; align-items: center; justify-content: center; color: var(--warning); flex-shrink: 0;">
                            <i data-feather="file-text" style="width: 18px;"></i>
                        </div>
                        <div>
                            <strong style="display: block; font-size: 0.95rem; color: var(--text-primary); margin-bottom: 2px;">Raw Topics Matrix</strong>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">Atomic assessment results</span>
                        </div>
                        <i data-feather="chevron-right" style="margin-left: auto; color: var(--text-muted); width: 16px;"></i>
                    </a>

                </div>
            </div>
        </div>

    </div>
<?php elseif ($role === 'InternalVerifier'): ?>
    
    <div class="card mb-4" style="background: linear-gradient(135deg, rgba(37,99,235,0.02) 0%, rgba(37,99,235,0.05) 100%); border: 1px solid rgba(37,99,235,0.1);">
        <div class="flex-between align-center" style="margin-bottom: 15px;">
            <div>
                <h4 class="mb-2" style="font-size: 1.15rem; color: var(--text-primary);"><i data-feather="crosshair" style="width: 18px; color: var(--primary);"></i> Quality Assurance Telemetry</h4>
                <p class="text-muted mb-3">Monitor assessment validity, departmental coverage, and grader calibration matrices.</p>
            </div>
        </div>
        <div class="grid-2" style="gap: 15px;">
            <?= component('button', ['href' => APP_URL . '/reports/iv_dept', 'label' => 'Department IV Coverage', 'variant' => 'outline', 'class' => 'w-100', 'icon' => 'pie-chart']) ?>
            <?= component('button', ['href' => APP_URL . '/reports/iv_progress', 'label' => 'Student Level Progression', 'variant' => 'outline', 'class' => 'w-100', 'icon' => 'trending-up']) ?>
            <?= component('button', ['href' => APP_URL . '/reports/iv_consistency', 'label' => 'Grader Calibration Reports', 'variant' => 'outline', 'class' => 'w-100', 'icon' => 'users']) ?>
            <?= component('button', ['href' => APP_URL . '/reports/iv_detailed_dept', 'label' => 'Full Dept Audit Report', 'variant' => 'primary', 'class' => 'w-100', 'icon' => 'file-text']) ?>
        </div>
    </div>

    <!-- Mapped Audit Allocations -->
    <?php if (!empty($iv_allocations)): ?>
        <div style="margin-top: 40px; border-top: 1px dashed var(--border-color); padding-top: 30px;">
            <h3 class="mb-2" style="display: flex; align-items: center; gap: 8px;">
                <i data-feather="shield" style="color: var(--secondary);"></i> Active Audit Nodes
            </h3>
            <p class="text-muted mb-4">You are actively assigned as the Internal Verifier for the following class units.</p>
            <div class="grid-3">
                <?php foreach ($iv_allocations as $a): ?>
                    <div class="card popup-card" style="transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                            <h4 style="margin: 0; font-size: 1.1rem; line-height: 1.4; color: var(--accent);"><?= htmlspecialchars($a['unit_title']) ?></h4>
                        </div>
                        <div class="text-muted mb-3" style="font-size: 0.85rem; font-family: monospace; background: var(--bg-app); padding: 4px 8px; border-radius: 4px; display: inline-block; border: 1px solid var(--border-color);">
                            <?= htmlspecialchars($a['unit_code']) ?>
                        </div>
                        <div class="mb-4">
                            <?= component('badge', ['label' => 'Audit Class: ' . htmlspecialchars($a['class_code']), 'variant' => 'info']) ?>
                        </div>
                        
                        <?= component('button', ['href' => APP_URL . "/audit/workspace?class_id={$a['class_id']}&unit_id={$a['unit_id']}", 'label' => 'Launch Verification Workspace', 'variant' => 'outline', 'class' => 'w-100', 'icon' => 'external-link']) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <?= component('alert', ['message' => 'Sysconfig: You currently have no active classes assigned to your internal verification matrix.', 'variant' => 'warning']) ?>
    <?php endif; ?>

<?php else: ?>
    <div class="card">
        <p>Dashboard for <?= htmlspecialchars($role) ?> is under construction or disabled.</p>
    </div>
<?php endif; ?>

<!-- Countdown Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const timers = document.querySelectorAll('.countdown-timer');
        timers.forEach(timer => {
            const endDateStr = timer.getAttribute('data-end');
            if (!endDateStr) {
                timer.innerHTML = "No End Date";
                return;
            }

            const endDate = new Date(endDateStr).getTime();
            const now = new Date().getTime();

            if (endDate < now) {
                timer.innerHTML = "Closed";
                timer.style.background = "var(--secondary)";
            } else {
                // Simple visual calculation
                const diff = endDate - now;
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                timer.innerHTML = days + " days left";

                if (days < 7) {
                    timer.style.background = "var(--warning)"; 
                    timer.style.color = "var(--accent)";
                }
            }
        });
    });
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>