<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1200px;">
    
    <!-- Breadcrumb -->
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/poe/dashboard" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i data-feather="arrow-left" style="width: 16px;"></i> Return to Unit Selector
        </a>
    </div>

    <div style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <span class="badge badge-primary">Atomic Evidence Target</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;"><?= htmlspecialchars($unit['unit_code']) ?></span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;"><?= htmlspecialchars($unit['unit_title']) ?></h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;">Fulfill the required assessment logic below by securely transmitting your validated credentials into the grading pipeline.</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 24px;">
        <?php foreach ($slots as $s): ?>
            <?php
            $mySub = null;
            if (isset($submissions[$s['id']])) {
                $mySub = end($submissions[$s['id']]);
            }
            $isSubmitted = !empty($mySub);
            $status = $isSubmitted ? $mySub['status'] : 'Not Submitted';
            
            $variant = match ($status) {
                'Approved' => 'success',
                'Verified' => 'success',
                'Rejected' => 'danger',
                'Submitted' => 'primary',
                default => 'warning'
            };
            
            $borderColor = match($status) {
                'Approved', 'Verified' => 'var(--success)',
                'Rejected' => 'var(--danger)',
                'Submitted' => 'var(--primary)',
                default => 'var(--border-color)'
            };
            ?>

            <div class="card" style="border-left: 4px solid <?= $borderColor ?>; display: flex; flex-direction: column; gap: 20px;">
                
                <div class="flex-between align-start" style="flex-wrap: wrap; gap: 15px;">
                    <div style="flex: 1; min-width: 250px;">
                        <h3 style="margin-top: 0; margin-bottom: 8px; font-size: 1.25rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                            <?php if ($status === 'Approved' || $status === 'Verified'): ?>
                                <i data-feather="check-circle" style="color: var(--success); width: 18px;"></i>
                            <?php elseif ($status === 'Rejected'): ?>
                                <i data-feather="alert-triangle" style="color: var(--danger); width: 18px;"></i>
                            <?php else: ?>
                                <i data-feather="target" style="color: var(--text-muted); width: 18px;"></i>
                            <?php endif; ?>
                            <?= htmlspecialchars($s['title']) ?>
                        </h3>
                        <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; margin: 0; padding-left: 26px;">
                            <?= htmlspecialchars($s['instructions']) ?>
                        </p>
                    </div>
                    <div>
                        <?= component('badge', ['label' => $status, 'variant' => $variant]) ?>
                    </div>
                </div>

                <?php if ($isSubmitted && !empty($mySub['latest_comment'])): ?>
                    <div style="margin-left: 26px; padding: 15px; background: rgba(239, 68, 68, 0.05); border: 1px dashed rgba(239, 68, 68, 0.4); border-radius: 6px; color: #b91c1c; font-size: 0.95rem;">
                        <strong style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; color: #991b1b;">
                            <i data-feather="alert-circle" style="width: 14px;"></i> Assessor Feedback
                        </strong> 
                        <?= htmlspecialchars($mySub['latest_comment']) ?>
                    </div>
                <?php endif; ?>

                <div style="margin-left: 26px;">
                    <?php if ($status === 'Approved' || $status === 'Verified'): ?>
                        <div style="padding: 20px; background: rgba(16, 185, 129, 0.03); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px; color: #065f46; font-weight: 500;">
                                <i data-feather="lock" style="width: 20px;"></i> 
                                <div>
                                    <span style="display:block;">Evidence Locked</span>
                                    <span style="font-size: 0.8rem; font-weight: 400; opacity: 0.8;">Verification threshold met. Further modifications blocked.</span>
                                </div>
                            </div>
                            <?= component('button', [
                                'href' => APP_URL . "/poe/view/{$mySub['id']}", 
                                'label' => 'View Certificate', 
                                'icon' => 'maximize-2',
                                'attrs' => 'target="_blank" style="background: white; border-color: rgba(16, 185, 129, 0.5); color: #065f46;"'
                            ]) ?>
                        </div>
                    <?php else: ?>
                        <div style="background: #f8fafc; padding: 20px; border-radius: var(--radius-md); border: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 15px;">
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; border-bottom: 1px dashed var(--border-color); padding-bottom: 15px;">
                                <?php if ($isSubmitted): ?>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 36px; height: 36px; border-radius: 8px; background: white; border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                            <i data-feather="file-text" style="width: 16px;"></i>
                                        </div>
                                        <div>
                                            <a href="<?= APP_URL ?>/preview/submission/<?= $mySub['id'] ?>" target="_blank" style="color: var(--primary); font-weight: 600; text-decoration: none; font-size: 0.95rem;">
                                                Preview Current Document
                                            </a>
                                            <div style="font-size: 0.8rem; color: var(--text-muted); display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                                                <i data-feather="clock" style="width: 12px;"></i> Uploaded: <?= htmlspecialchars($mySub['submitted_at']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div style="display: flex; align-items: center; gap: 10px; color: var(--text-muted);">
                                        <i data-feather="file-minus" style="width: 18px;"></i>
                                        <span style="font-size: 0.95rem;">No evidence uploaded yet...</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if (isset($s['allow_student_uploads']) && $s['allow_student_uploads'] == 0): ?>
                                <div style="display: flex; align-items: center; gap: 8px; color: var(--text-muted); font-size: 0.9rem; font-weight: 500; background: white; padding: 12px; border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
                                    <i data-feather="shield" style="width: 16px;"></i> Controlled Endpoint: Assessor manages uploads for this slot natively.
                                </div>
                            <?php else: ?>
                                <form action="<?= APP_URL ?>/poe/upload" method="POST" enctype="multipart/form-data" style="margin: 0; display: flex; flex-direction: column; gap: 15px;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="slot_id" value="<?= htmlspecialchars($s['id']) ?>">
                                    <input type="hidden" name="unit_id" value="<?= htmlspecialchars($unit['id']) ?>">
                                    
                                    <div>
                                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-secondary);">Select Evidence File</label>
                                        <input type="file" name="evidence_file" class="form-control" required style="font-size: 0.85rem; padding: 8px; background: white; width: 100%; max-width: 400px;">
                                    </div>
                                    
                                    <div>
                                        <?= component('button', [
                                            'type' => 'submit', 
                                            'label' => $isSubmitted ? 'Re-Upload Evidence' : 'Upload Evidence',
                                            'variant' => 'primary',
                                            'icon' => 'upload-cloud'
                                        ]) ?>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($slots)): ?>
            <div class="text-center text-muted" style="padding: 60px 20px; background: var(--bg-app); border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
                <i data-feather="clipboard" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                <p style="margin: 0; font-size: 1.1rem; color: var(--text-primary);">No assessment architecture deployed for this specific unit.</p>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 5px;">Submit a query to your localized trainer for diagnostic checks.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>