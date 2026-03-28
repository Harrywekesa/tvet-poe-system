<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1000px;">
    
    <!-- Breadcrumb Nav -->
    <div style="margin-bottom: 20px;">
        <?php $backLink = isset($class_id) ? APP_URL . "/academic/class/$class_id" : APP_URL . "/dashboard"; ?>
        <a href="<?= $backLink ?>" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i data-feather="arrow-left" style="width: 16px;"></i> Back to Class / Roster
        </a>
    </div>

    <!-- Header Block -->
    <div style="margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <span class="badge badge-primary">Assessment Grading</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;"><?= htmlspecialchars($unit['unit_code']) ?></span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;">Candidate: <?= htmlspecialchars($studentName) ?></h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;"><?= htmlspecialchars($unit['unit_title']) ?></p>
    </div>

    <!-- Strategy Banner -->
    <div style="background: var(--bg-card); padding: 15px 20px; border-radius: var(--radius-md); border-left: 4px solid var(--info); border-right: 1px solid var(--border-color); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); box-shadow: var(--shadow-sm); margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
        <i data-feather="info" style="color: var(--info);"></i>
        <div>
            <strong style="color: var(--text-primary);">Grading Engine: <?= htmlspecialchars($unit['assessment_level']) ?></strong>
            <span style="color: var(--text-muted); margin-left: 0px; font-size: 0.9rem; display: block; @media(min-width: 480px) { display: inline-block; margin-left: 10px; }">
                &mdash; Computes as (<?= $unit['assessment_level'] == 'Level 6' ? '40% Written / 60% Practical' : ($unit['assessment_level'] == 'Level 5' ? '30% Written / 70% Practical' : '10% Written / 90% Practical') ?>)
            </span>
        </div>
    </div>

    <form action="<?= APP_URL ?>/marks/save" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="unit_id" value="<?= htmlspecialchars($unit['id']) ?>">
        <input type="hidden" name="class_id" value="<?= htmlspecialchars($class['id'] ?? '') ?>">
        <input type="hidden" name="student_id" value="<?= htmlspecialchars($studentId) ?>">

        <?php foreach ($matrix as $topicId => $group): ?>
            <?php if (empty($group['slots'])) continue; ?>

            <div class="card" style="margin-bottom: 24px; padding: 0; overflow: hidden;">
                <!-- Topic Header -->
                <div style="background: #f8fafc; padding: 20px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary);">
                            <?php if ($topicId == 0): ?>
                                General Competency Assessments
                            <?php else: ?>
                                <?= htmlspecialchars($group['topic']['title']) ?>
                            <?php endif; ?>
                        </h3>
                    </div>
                    <?php if ($topicId != 0): ?>
                        <span class="badge" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">Weight: <?= number_format($group['topic']['weight_percentage'], 0) ?>%</span>
                    <?php endif; ?>
                </div>

                <!-- Slots List (Mobile Friendly Grid) -->
                <div>
                    <?php foreach ($group['slots'] as $i => $slot): ?>
                        <div style="padding: 24px 20px; border-bottom: <?= $i === count($group['slots']) - 1 ? 'none' : '1px solid var(--border-color)' ?>; display: grid; grid-template-columns: 1fr; gap: 20px; @media(min-width: 768px) { grid-template-columns: 2fr 1fr; }">
                            
                            <!-- Slot Details -->
                            <div>
                                <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 8px; flex-wrap: wrap;">
                                    <h4 style="margin: 0; font-size: 1.05rem; color: var(--text-primary);"><?= htmlspecialchars($slot['title']) ?></h4>
                                    <span class="badge" style="background: #f1f5f9; color: var(--text-muted); border: 1px solid #e2e8f0; font-size: 0.70rem; padding: 2px 6px;"><?= htmlspecialchars($slot['type']) ?></span>
                                </div>
                                <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 15px; line-height: 1.5;">
                                    <?= htmlspecialchars($slot['instructions'] ?? 'No specific instructions provided.') ?>
                                </p>

                                <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: #94a3b8;">POE Status:</span>
                                        <?php if ($slot['status'] == 'Submitted'): ?>
                                            <span class="badge badge-success"><div class="pulsing-dot" style="width: 6px; height: 6px; border-radius: 50%; background: #10B981; margin-right: 4px; display: inline-block;"></div> Submitted</span>
                                        <?php elseif ($slot['status'] == 'Graded'): ?>
                                            <span class="badge badge-info"><i data-feather="check-circle" style="width: 12px; margin-right: 4px;"></i> Graded</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a;">Pending</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($slot['status'] == 'Submitted' && !empty($slot['submission_id'])): ?>
                                        <a href="<?= APP_URL ?>/preview/submission/<?= $slot['submission_id'] ?>" target="_blank" style="font-size: 0.85rem; display: inline-flex; align-items: center; gap: 4px; color: var(--primary); font-weight: 500; text-decoration: none; padding: 4px 8px; border: 1px solid rgba(37,99,235,0.2); border-radius: 4px; background: rgba(37,99,235,0.05);">
                                            <i data-feather="external-link" style="width: 14px;"></i> View Candidate File
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Grading Controls -->
                            <div style="background: #f8fafc; padding: 15px; border-radius: var(--radius-md); border: 1px solid var(--border-color); display: flex; flex-direction: column; justify-content: flex-start;">
                                <div style="margin-bottom: 12px;">
                                    <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px;">Awarded Mark (0-100)</label>
                                    <div style="position: relative; max-width: 180px;">
                                        <input type="number" name="marks[<?= htmlspecialchars($slot['id']) ?>]" value="<?= htmlspecialchars($slot['mark']) ?>"
                                            class="form-control" style="width: 100%; font-weight: 700; font-size: 1.1rem; text-align: right; padding-right: 30px; border-color: <?= !empty($slot['mark']) ? 'var(--primary)' : 'var(--border-color)' ?>;" min="0" max="100" step="0.01" placeholder="---">
                                        <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-weight: 700; color: var(--text-muted);">%</span>
                                    </div>
                                </div>
                                
                                <div>
                                    <label style="display: block; font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Assessor Evidence Override</label>
                                    <div style="position: relative;">
                                        <input type="file" name="evidence[<?= htmlspecialchars($slot['id']) ?>]" accept=".pdf,.png,.jpg,.jpeg" class="custom-file-input" style="font-size: 0.75rem; width: 100%; background: white; padding: 6px; border-radius: 4px; border: 1px dashed #cbd5e1; cursor: pointer;">
                                    </div>
                                    <small style="color: #94a3b8; font-size: 0.7rem; margin-top: 4px; display: block; line-height: 1.2;">Upload physical photos or rubric files if student upload is missing.</small>
                                </div>
                            </div>
                            
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Sticky Footer Action -->
        <div style="position: sticky; bottom: 20px; background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); padding: 15px 20px; border-radius: var(--radius-lg); border: 1px solid rgba(0,0,0,0.08); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); display: flex; justify-content: space-between; align-items: center; z-index: 100; flex-wrap: wrap; gap: 15px;">
            <div style="font-size: 0.9rem; color: var(--text-primary); font-weight: 500; display: flex; align-items: center; gap: 8px;">
                <i data-feather="check-circle" style="width: 18px; color: var(--success);"></i> Ensure all inputs are correct.
            </div>
            <?= component('button', ['type' => 'submit', 'label' => 'Submit Marks Securely', 'class' => 'btn-primary shadow-primary-glowing', 'style' => 'font-size: 1rem; padding: 12px 24px;']) ?>
        </div>
    </form>
</div>

<script>
    // Injection for the pulsing dot animation if not present globally
    if (!document.getElementById('pulseDotStyles')) {
        const style = document.createElement('style');
        style.id = 'pulseDotStyles';
        style.innerHTML = `
            @keyframes pulseDot {
                0% { transform: scale(0.95); opacity: 0.7; }
                50% { transform: scale(1.2); opacity: 1; }
                100% { transform: scale(0.95); opacity: 0.7; }
            }
            .pulsing-dot { animation: pulseDot 1.5s infinite ease-in-out; }
            
            /* Responsive Grid Override for Grading form */
            @media (min-width: 768px) {
                .grade-grid { grid-template-columns: 2fr 1fr; }
            }
        `;
        document.head.appendChild(style);
    }
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>