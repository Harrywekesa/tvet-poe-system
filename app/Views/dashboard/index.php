<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>Dashboard</h1>
        <div>
            <span style="margin-right: 15px; color: var(--secondary);">Welcome,
                <strong><?= htmlspecialchars($name) ?></strong>
                (<?= $role ?><?= isset($dept_name) ? ", " . htmlspecialchars($dept_name) : '' ?>)</span>
            <a href="<?= APP_URL ?>/logout" class="btn btn-outline"
                style="font-size: 0.9rem; padding: 5px 15px;">Logout</a>
        </div>
    </div>

    <!-- Role Specific Content -->
    <?php if ($role === 'Admin'): ?>

        <!-- Admin Stats -->
        <div class="grid-3" style="margin-bottom: 30px;">
            <div
                style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; border-left: 4px solid #2563eb;">
                <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Total Users
                </div>
                <div style="font-size: 2rem; font-weight: 700; color: #1e293b;"><?= $counts['users'] ?></div>
            </div>
            <div
                style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; border-left: 4px solid #16a34a;">
                <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Active Content
                </div>
                <div style="font-size: 2rem; font-weight: 700; color: #1e293b;">
                    <?= $counts['courses'] ?><span style="font-size:1rem; color:#94a3b8; font-weight:400;"> courses</span>
                </div>
            </div>
            <div
                style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; border-left: 4px solid #f59e0b;">
                <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Classes</div>
                <div style="font-size: 2rem; font-weight: 700; color: #1e293b;"><?= $counts['classes'] ?></div>
            </div>
        </div>

        <div class="grid-main-side" style="align-items: start;">
            <!-- Cohort Status -->
            <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <h3>Cohort Status</h3>
                <div class="grid-2" style="margin-top: 15px; margin-bottom: 20px;">
                    <div
                        style="text-align: center; padding: 15px; background: #ecfdf5; border-radius: 8px; border: 1px solid #a7f3d0;">
                        <div style="font-size: 1.5rem; font-weight: 700; color: #059669;"><?= count($active_cohorts) ?>
                        </div>
                        <div style="font-size: 0.8rem; color: #065f46;">Active Cohorts</div>
                    </div>
                    <div
                        style="text-align: center; padding: 15px; background: #fef2f2; border-radius: 8px; border: 1px solid #fecaca;">
                        <div style="font-size: 1.5rem; font-weight: 700; color: #dc2626;"><?= count($closed_cohorts) ?>
                        </div>
                        <div style="font-size: 0.8rem; color: #991b1b;">Closed Cohorts</div>
                    </div>
                </div>

                <h4>Active Cohorts Countdown</h4>
                <ul style="list-style: none; padding: 0; margin-top: 10px;">
                    <?php foreach ($active_cohorts as $ac): ?>
                        <li
                            style="padding: 10px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <strong><?= htmlspecialchars($ac['name']) ?></strong><br>
                                <small style="color: #64748b;">Ends: <?= $ac['end_date'] ?? 'N/A' ?></small>
                            </div>
                            <div class="countdown-timer" data-end="<?= $ac['end_date'] ?>"
                                style="font-family: monospace; background: #1e293b; color: #fff; padding: 2px 6px; border-radius: 4px; font-size: 0.85rem;">
                                Calculating...
                            </div>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($active_cohorts)): ?>
                        <li style="color:#64748b;">No active cohorts.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Quick Links -->
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h4>Quick Management</h4>
                    <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 15px;">Access core modules.</p>
                    <a href="<?= APP_URL ?>/users" class="btn btn-outline"
                        style="display: block; text-align: center; margin-bottom: 10px;">Manage Users</a>
                    <a href="<?= APP_URL ?>/academic" class="btn btn-outline"
                        style="display: block; text-align: center; margin-bottom: 10px;">Academic & Cohorts</a>
                    <a href="<?= APP_URL ?>/institution" class="btn btn-outline"
                        style="display: block; text-align: center;">Institution Setup</a>
                </div>
            </div>
        </div>

    <?php elseif ($role === 'Trainer'): ?>
        <div style="margin-top: 20px;">
            <h3>My Allocated Units</h3>
            <p class="text-secondary" style="margin-bottom: 20px;">Manage assessments and review evidence for your classes.
            </p>

            <?php if (empty($allocations)): ?>
                <div style="background: #f8fafc; padding: 20px; border-radius: 8px; color: #64748b;">
                    No units have been allocated to you yet.
                </div>
            <?php else: ?>
                <div class="grid-3">
                    <?php foreach ($allocations as $a): ?>
                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                            <h4 style="font-size: 1.1rem; margin-bottom: 5px;"><?= htmlspecialchars($a['unit_title']) ?></h4>
                            <div style="font-size: 0.9rem; color: #64748b; margin-bottom: 5px;">
                                <?= htmlspecialchars($a['unit_code']) ?>
                            </div>
                            <div
                                style="font-size: 0.85rem; background: #e0f2fe; color: #0284c7; display: inline-block; padding: 2px 8px; border-radius: 4px; margin-bottom: 15px;">
                                Class: <?= htmlspecialchars($a['class_code']) ?>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; gap: 8px;">
                                    <a href="<?= APP_URL ?>/assessment/manage/<?= $a['id'] ?>" class="btn btn-outline"
                                        style="flex: 1; text-align: center; font-size: 0.8rem;">Assessments</a>
                                    <a href="<?= APP_URL ?>/unit/topics/<?= $a['id'] ?>" class="btn btn-outline"
                                        style="flex: 1; text-align: center; font-size: 0.8rem;">Topics</a>
                                </div>

                                <a href="<?= APP_URL ?>/marks/grade/<?= $a['id'] ?>/<?= $a['class_id'] ?>/0" class="btn btn-primary"
                                    style="text-align: center; font-size: 0.9rem;">Grade Class</a>

                                <div style="display: flex; gap: 8px;">
                                    <a href="<?= APP_URL ?>/review/unit/<?= $a['id'] ?>/class/<?= $a['class_id'] ?>"
                                        class="btn btn-outline" style="flex: 1; text-align: center; font-size: 0.8rem;">Review</a>
                                    <a href="<?= APP_URL ?>/marks/marksheet/<?= $a['id'] ?>/<?= $a['class_id'] ?>"
                                        class="btn btn-outline"
                                        style="flex: 1; text-align: center; font-size: 0.8rem;">Marksheet</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 30px;">
            <h3>Active Classes</h3>
            <p class="text-secondary">Select a class to manage units and self-allocate.</p>
            <div class="grid-3" style="margin-top: 20px;">
                <?php if (!empty($all_classes)): ?>
                    <?php foreach ($all_classes as $c): ?>
                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                            <h4 style="font-size: 1.1rem; margin-bottom: 5px;"><?= htmlspecialchars($c['class_code']) ?></h4>
                            <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 15px;">
                                <?= htmlspecialchars($c['course_title']) ?>
                            </p>
                            <a href="<?= APP_URL ?>/academic/class/<?= $c['id'] ?>" class="btn btn-outline"
                                style="width: 100%; text-align: center;">View Class</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php elseif ($role === 'InternalVerifier'): ?>
        <!-- Quick Actions -->
        <div class="grid-2" style="margin-bottom: 30px;">
            <div
                style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; border-left: 4px solid #2563eb;">
                <h3 style="color: #1e3a8a; margin-top: 0;">Start Full Audit</h3>
                <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 15px;">
                    Begin a new audit cycle by selecting a Department and Course.
                </p>
                <div style="display: flex; gap: 10px;">
                    <a href="<?= APP_URL ?>/audit" class="btn btn-primary">🚀 Start New Audit</a>
                    <a href="<?= APP_URL ?>/marks/approvals" class="btn btn-outline">Check Approvals</a>
                </div>
            </div>

            <div
                style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; border-left: 4px solid #7c3aed;">
                <h3 style="color: #5b21b6; margin-top: 0;">QA Reports</h3>
                <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 15px;">
                    Generate detailed findings and consistency reports.
                </p>
                <a href="<?= APP_URL ?>/reports/iv_analytics" class="btn btn-outline"
                    style="color: #7c3aed; border-color: #7c3aed;">📊 View Reports</a>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <h3>Internal Verification</h3>
            <p class="text-secondary" style="margin-bottom: 20px;">Sample and verify approved assessments.</p>

            <?php if (empty($iv_allocations)): ?>
                <div style="background: #f8fafc; padding: 20px; border-radius: 8px; color: #64748b;">
                    No units assigned for verification.
                </div>
            <?php else: ?>
                <div class="grid-3">
                    <?php foreach ($iv_allocations as $a): ?>
                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                            <h4 style="font-size: 1.1rem; margin-bottom: 5px;"><?= htmlspecialchars($a['unit_title']) ?></h4>
                            <div style="font-size: 0.9rem; color: #64748b; margin-bottom: 10px;">
                                <?= htmlspecialchars($a['unit_code']) ?>
                            </div>

                            <div class="flex-between" style="font-size: 0.85rem; margin-bottom: 15px;">
                                <span style="background: #e0f2fe; color: #0284c7; padding: 2px 8px; border-radius: 4px;">Class:
                                    <?= htmlspecialchars($a['class_code']) ?></span>
                                <span style="color: #16a34a; font-weight: 600;"><?= $a['approved_count'] ?> Approved</span>
                            </div>

                            <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                <a href="<?= APP_URL ?>/verification/list/<?= $a['id'] ?>/class/<?= $a['class_id'] ?>"
                                    class="btn btn-primary" style="flex: 1; text-align: center; font-size: 0.8rem;">Verify
                                    Samples</a>

                                <a href="<?= APP_URL ?>/marks/marksheet/<?= $a['id'] ?>/<?= $a['class_id'] ?>"
                                    class="btn btn-outline" style="flex: 1; text-align: center; font-size: 0.8rem;">Marksheet</a>

                                <a href="<?= APP_URL ?>/audit" class="btn btn-outline"
                                    style="flex: 1; text-align: center; font-size: 0.8rem;">Audit Hub</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif ($role === 'HOD'): ?>
        <div style="margin-bottom: 30px;">
            <h3>Department Overview</h3>
            <p class="text-secondary">Managing: <?= htmlspecialchars($dept_name ?? 'Unassigned') ?></p>

            <?php if (isset($pending_docs) && count($pending_docs) > 0): ?>
                <div class="alert"
                    style="background: #fff1f2; color: #9f1239; padding: 15px; border: 1px solid #fecdd3; border-radius: 8px; margin-bottom: 20px;">
                    <strong>Action Required:</strong> You have <?= count($pending_docs) ?> pending professional documents to
                    review.
                    <a href="<?= APP_URL ?>/documents/review" style="text-decoration: underline; margin-left: 10px;">Review
                        Now</a>
                </div>
            <?php endif; ?>

            <div class="grid-3">
                <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h4>Classes</h4>
                    <div style="font-size: 2rem; font-weight: 700;"><?= count($dept_classes ?? []) ?></div>
                    <a href="<?= APP_URL ?>/academic" class="btn btn-outline"
                        style="margin-top: 10px; width: 100%; text-align: center;">Manage Classes</a>
                </div>
                <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h4>Courses</h4>
                    <div style="font-size: 2rem; font-weight: 700;"><?= count($my_courses ?? []) ?></div>
                    <a href="<?= APP_URL ?>/institution/department/<?= $dept_id ?>" class="btn btn-outline"
                        style="margin-top: 10px; width: 100%; text-align: center;">Manage Courses</a>
                </div>
                <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h4>Trainers</h4>
                    <div style="font-size: 2rem; font-weight: 700;"><?= count($trainers ?? []) ?></div>
                    <a href="<?= APP_URL ?>/users?dept=<?= $dept_id ?>" class="btn btn-outline"
                        style="margin-top: 10px; width: 100%; text-align: center;">View Team</a>
                </div>
                <!-- Reports Card -->
                <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h4>Reports & Approvals</h4>
                    <p style="font-size: 0.9rem; color: #64748b;">Dept Progress & Stats</p>
                    <div style="display: flex; gap: 5px; margin-top: 10px;">
                        <a href="<?= APP_URL ?>/reports/dept_overview" class="btn btn-outline"
                            style="flex: 1; text-align: center; font-size: 0.9rem;">Stats</a>
                        <a href="<?= APP_URL ?>/marks/approvals" class="btn btn-primary"
                            style="flex: 1; text-align: center; font-size: 0.9rem;">Approvals</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- HOD Teaching Allocations -->
    <?php if (!empty($allocations)): ?>
        <div style="margin-top: 30px; border-top: 1px dashed #cbd5e1; padding-top: 20px;">
            <h3>My Teaching Allocations</h3>
            <p class="text-secondary" style="margin-bottom: 20px;">Units you are directly assessing.</p>
            <div class="grid-3">
                <?php foreach ($allocations as $a): ?>
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                        <h4 style="font-size: 1.1rem; margin-bottom: 5px;"><?= htmlspecialchars($a['unit_title']) ?></h4>
                        <div style="font-size: 0.9rem; color: #64748b; margin-bottom: 5px;">
                            <?= htmlspecialchars($a['unit_code']) ?>
                        </div>
                        <div
                            style="font-size: 0.85rem; background: #e0f2fe; color: #0284c7; display: inline-block; padding: 2px 8px; border-radius: 4px; margin-bottom: 15px;">
                            Class: <?= htmlspecialchars($a['class_code']) ?>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div style="display: flex; gap: 8px;">
                                <a href="<?= APP_URL ?>/assessment/manage/<?= $a['id'] ?>" class="btn btn-outline"
                                    style="flex: 1; text-align: center; font-size: 0.8rem;">Assessments</a>
                                <a href="<?= APP_URL ?>/unit/topics/<?= $a['id'] ?>" class="btn btn-outline"
                                    style="flex: 1; text-align: center; font-size: 0.8rem;">Topics</a>
                            </div>

                            <a href="<?= APP_URL ?>/marks/grade/<?= $a['id'] ?>/<?= $a['class_id'] ?>/0" class="btn btn-primary"
                                style="text-align: center; font-size: 0.9rem;">Grade Class</a>

                            <div style="display: flex; gap: 8px;">
                                <a href="<?= APP_URL ?>/review/unit/<?= $a['id'] ?>/class/<?= $a['class_id'] ?>"
                                    class="btn btn-outline" style="flex: 1; text-align: center; font-size: 0.8rem;">Review</a>
                                <a href="<?= APP_URL ?>/marks/marksheet/<?= $a['id'] ?>/<?= $a['class_id'] ?>"
                                    class="btn btn-outline" style="flex: 1; text-align: center; font-size: 0.8rem;">Marksheet</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    </div>

<?php elseif ($role === 'Student'): ?>

    <!-- Student Stats -->
    <div class="grid-3" style="margin-bottom: 30px;">
        <div
            style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; border-left: 4px solid #2563eb;">
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Enrolled
                Classes</div>
            <div style="font-size: 2rem; font-weight: 700; color: #1e293b;"><?= count($classes) ?></div>
        </div>
        <div
            style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; border-left: 4px solid #f59e0b;">
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Pending
                Submissions</div>
            <div style="font-size: 2rem; font-weight: 700; color: #1e293b;"><?= $pending_count ?></div>
        </div>
        <div
            style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; border-left: 4px solid #dc2626;">
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Rejected POEs
            </div>
            <div style="font-size: 2rem; font-weight: 700; color: #dc2626;"><?= $rejected_count ?></div>
            <div style="font-size: 0.8rem; color: #991b1b;">Requires Attention</div>
        </div>
    </div>

    <div style="background: white; padding: 30px; border-radius: 8px; margin-bottom: 30px;">
        <h3>My POE</h3>
        <p>Access your enrolled classes and submit evidence.</p>
        <a href="<?= APP_URL ?>/poe/dashboard" class="btn btn-primary" style="margin-top: 15px;">Go to My POE</a>
    </div>

    <!-- My Marks Section -->
    <div style="background: white; padding: 30px; border-radius: 8px;">
        <h3>My Progress & Marks</h3>
        <p class="text-secondary" style="margin-bottom: 20px;">View your assessment modifications and final unit marks.</p>

        <div style="margin-bottom: 20px; display: flex; gap: 10px;">
            <a href="<?= APP_URL ?>/marks/transcript/<?= $_SESSION['user_id'] ?>?type=raw" target="_blank"
                class="btn btn-primary" style="background: #0f172a; border-color: #0f172a;">
                📜 Term Transcript (Raw)
            </a>
            <a href="<?= APP_URL ?>/marks/transcript/<?= $_SESSION['user_id'] ?>?type=weighted" target="_blank"
                class="btn btn-outline" style="color: #0f172a; border-color: #0f172a;">
                📜 Term Transcript (Weighted)
            </a>
        </div>

        <?php if (!empty($my_units)): ?>
            <div class="grid-3">
                <?php foreach ($my_units as $u): ?>
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                        <h4 style="margin: 0 0 5px 0;"><?= htmlspecialchars($u['unit_title']) ?></h4>
                        <div style="font-size: 0.9rem; color: #64748b; margin-bottom: 15px;">
                            <?= htmlspecialchars($u['unit_code']) ?>
                        </div>
                        <a href="<?= APP_URL ?>/marks/my_view/<?= $u['id'] ?>" class="btn btn-outline"
                            style="width: 100%; text-align: center;">View Marks</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p calss="text-muted">You are not enrolled in any units yet.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <p>Dashboard for <?= $role ?> is under construction.</p>
<?php endif; ?>
</div>

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
                timer.style.background = "#94a3b8";
            } else {
                // Simple visual calculation
                const diff = endDate - now;
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                timer.innerHTML = days + " days left";

                if (days < 7) timer.style.border = "1px solid #f59e0b"; // Warn if low
            }
        });
    });
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>