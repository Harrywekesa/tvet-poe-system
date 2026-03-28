<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="max-width: 1200px; margin-top: 40px;">
    <div style="margin-bottom: 24px;">
        <a href="<?= APP_URL ?>/dashboard" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i data-feather="arrow-left" style="width: 16px;"></i> Return to Dashboard
        </a>
    </div>

    <div style="margin-bottom: 30px;">
        <h1 class="page-title" style="margin-bottom: 5px;">Review Professional Documents</h1>
        <p class="text-secondary" style="font-size: 1.05rem;">Ensure regulatory compliance by aggressively screening and executing dispositions on documentation payloads submitted by pedagogical staff.</p>
    </div>

    <div class="grid-main-side" style="align-items: start; gap: 30px;">
        
        <!-- Left Pane: Pending Queue -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div style="display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 5px;">
                <i data-feather="clock" style="color: var(--warning);"></i>
                <h3 style="margin: 0; font-size: 1.25rem;">Pending Validation Actions</h3>
            </div>

            <?php if (empty($pending)): ?>
                <div class="text-center text-muted" style="padding: 40px; background: white; border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
                    <i data-feather="check-circle" style="width: 48px; height: 48px; color: var(--success); margin-bottom: 15px;"></i>
                    <p style="margin: 0; font-size: 1.05rem;">The processing queue requires zero intervention.</p>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 5px;">All regulatory documentation frameworks are fully resolved.</p>
                </div>
            <?php else: ?>
                <?php foreach ($pending as $d): ?>
                    <div class="card" style="border-left: 4px solid var(--warning); display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px; transition: transform 0.2s; border-radius: var(--radius-md);">
                        <div style="flex: 1; min-width: 250px;">
                            <h3 style="margin: 0; font-size: 1.2rem; color: var(--text-primary); margin-bottom: 8px;">
                                <?= htmlspecialchars($d['type']) ?>
                            </h3>
                            <div style="display: flex; align-items: center; gap: 6px; color: var(--text-muted); font-size: 0.85rem; margin-bottom: 15px;">
                                <i data-feather="calendar" style="width: 12px;"></i> Transmission Logged: <strong style="color: var(--text-primary);"><?= $d['created_at'] ?></strong>
                            </div>
                            
                            <div style="background: var(--bg-app); padding: 12px 15px; border-radius: var(--radius-sm); font-size: 0.9rem; border: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 6px;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span class="text-muted">Target Operator:</span>
                                    <strong style="color: var(--primary);"><?= htmlspecialchars($d['trainer_name']) ?></strong>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span class="text-muted">Linked Module Node:</span>
                                    <strong style="font-family: monospace;"><?= htmlspecialchars($d['unit_code']) ?></strong>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span class="text-muted">Target Cohort Vector:</span>
                                    <strong><?= htmlspecialchars($d['class_code']) ?></strong>
                                </div>
                            </div>
                        </div>

                        <div style="min-width: 320px; display: flex; flex-direction: column; gap: 15px; background: #f8fafc; padding: 20px; border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
                            <?= component('button', [
                                'href' => APP_URL . '/preview/download?file=docs/' . $d['file_path'], 
                                'label' => 'Inspect Native Document Payload', 
                                'variant' => 'outline',
                                'icon' => 'file-text',
                                'class' => 'w-100',
                                'attrs' => 'target="_blank"'
                            ]) ?>

                            <form action="<?= APP_URL ?>/documents/status" method="POST" style="margin: 0; display: flex; flex-direction: column; gap: 10px;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="doc_id" value="<?= $d['id'] ?>">
                                
                                <div>
                                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px; display: block;">Verification Output Commentary</label>
                                    <textarea name="comments" placeholder="Required strictly if executing rejection disposition..." style="width: 100%; border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 10px; font-size: 0.85rem; resize: vertical; min-height: 80px;"></textarea>
                                </div>
                                
                                <div style="display: flex; gap: 10px;">
                                    <button type="submit" name="status" value="Approved" class="btn" style="background: #10b981; color: white; border: none; flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                                        <i data-feather="check" style="width: 16px;"></i> Approve
                                    </button>
                                    <button type="submit" name="status" value="Rejected" class="btn" style="background: #ef4444; color: white; border: none; flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                                        <i data-feather="x" style="width: 16px;"></i> Reject
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Right Pane: Immutable History -->
        <div>
            <div class="card" style="position: sticky; top: 20px;">
                <h4 style="margin-top: 0; margin-bottom: 15px; font-size: 1.15rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="archive" style="color: var(--secondary);"></i> Validation Archival Records
                </h4>
                
                <?php if (empty($history)): ?>
                    <div style="font-size: 0.9rem; color: var(--text-muted); font-style: italic; padding: 15px 0;">
                        No historical validation events detected for this administrative branch.
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 15px; max-height: 500px; overflow-y: auto; padding-right: 5px;">
                        <?php foreach ($history as $h): ?>
                            <div style="border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                                    <strong style="font-size: 0.95rem; color: var(--text-primary);"><?= htmlspecialchars($h['type']) ?></strong>
                                    <?php
                                        $variant = strpos($h['status'], 'Approved') !== false ? 'success' : 'danger';
                                    ?>
                                    <?= component('badge', ['label' => htmlspecialchars($h['status']), 'variant' => $variant]) ?>
                                </div>
                                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 8px; display: flex; align-items: center; gap: 4px;">
                                    <i data-feather="user" style="width: 12px;"></i> Operator: <?= htmlspecialchars($h['trainer_name']) ?>
                                </div>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem;">
                                    <span style="color: var(--text-muted);"><?= date('M d, Y', strtotime($h['created_at'])) ?></span>
                                    
                                    <?php if ($h['status'] === 'Approved'): ?>
                                        <a href="<?= APP_URL ?>/documents/certificate/<?= $h['id'] ?>" target="_blank" style="color: #10b981; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                            Fetch Cert <i data-feather="external-link" style="width: 12px;"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= APP_URL ?>/preview/download?file=docs/<?= $h['file_path'] ?>" target="_blank" style="color: var(--primary); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                            Extract File <i data-feather="download" style="width: 12px;"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>