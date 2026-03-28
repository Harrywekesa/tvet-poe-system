<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="max-width: 1400px; margin-top: 40px;">
    
    <!-- Header -->
    <div class="card p-0" style="margin-bottom: 30px; border-radius: var(--radius-lg); overflow: hidden; position: sticky; top: 0; z-index: 50; box-shadow: var(--shadow-sm);">
        <div class="flex-between align-center" style="padding: 20px 24px; background: white; border-bottom: 1px solid var(--border-color);">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.05); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                    <i data-feather="crosshair" style="width: 24px; height: 24px;"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <span class="badge" style="background: var(--bg-app); color: var(--text-primary); border: 1px solid var(--border-color); font-family: monospace;">
                            <?= htmlspecialchars($unit['unit_code']) ?>
                        </span>
                        <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Live Audit Session</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <h2 style="margin: 0; font-size: 1.25rem; color: var(--text-primary);">Audit Session #<?= $session['id'] ?></h2>
                        <span style="color: var(--border-color);">|</span>
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">
                            Processing <strong style="color: var(--text-primary);"><?= count($samples) ?></strong> targeted parameters
                        </span>
                    </div>
                </div>
            </div>
            
            <form action="<?= APP_URL ?>/audit/complete" method="POST"
                onsubmit="return confirm('CRITICAL: Finalizing this audit will freeze all evaluations and generate the official PDF report. Proceed?');" style="margin: 0;">
                <?= csrf_field() ?>
                <input type="hidden" name="session_id" value="<?= $session['id'] ?>">
                <button type="submit" class="btn btn-success" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 700; height: 42px;">
                    <i data-feather="check-circle" style="width: 16px;"></i> Finalize QA Audit
                </button>
            </form>
        </div>
        
        <!-- Progress Indication -->
        <div style="background: rgba(248, 250, 252, 1); padding: 12px 24px; display: flex; align-items: center; gap: 15px;">
            <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; width: 120px;">
                <span id="completedCount" style="color: var(--primary);">0</span> / <?= count($samples) ?> Audited
            </div>
            <div style="flex: 1; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                <div id="liveProgress" style="height: 100%; width: 0%; background: var(--primary); transition: width 0.3s ease;"></div>
            </div>
        </div>
    </div>

    <div class="grid-main-side" style="align-items: start; gap: 30px; grid-template-columns: 1fr 350px;">
        
        <!-- Main Area: Audit Target Models -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php foreach ($samples as $id => $data):
                $s = $data['student'];
                $subs = $data['submissions'];
                
                $initialGroup = substr(explode(' ', $s['full_name'])[0], 0, 1);
                $isPending = $s['status'] === 'Pending';
                $isCompliant = $s['status'] === 'Compliant';
                
                $cardColor = $isPending ? 'var(--border-color)' : ($isCompliant ? 'var(--success)' : 'var(--danger)');
                $badgeBg = $isPending ? '#f1f5f9' : ($isCompliant ? 'rgba(16,185,129,0.1)' : 'rgba(239,68,68,0.1)');
                $badgeText = $isPending ? 'var(--text-muted)' : ($isCompliant ? 'var(--success)' : 'var(--danger)');
            ?>
                <div class="card sample-card p-0" id="sample-<?= $id ?>" style="border-left: 4px solid <?= $cardColor ?>; overflow: hidden; transition: all 0.3s ease;">
                    
                    <!-- Header Target Bar -->
                    <div style="padding: 16px 20px; background: white; cursor: pointer; display: flex; justify-content: space-between; align-items: center;" onclick="toggleCard(<?= $id ?>)">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--bg-app); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--primary);">
                                <?= strtoupper($initialGroup) ?>
                            </div>
                            <div>
                                <h4 style="margin: 0; font-size: 1.05rem; color: var(--text-primary);"><?= htmlspecialchars($s['full_name']) ?></h4>
                                <span style="font-size: 0.8rem; color: var(--text-muted); font-family: monospace;"><?= htmlspecialchars($s['identifier'] ?? 'SysID-Null') ?></span>
                            </div>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span class="badge" id="badge-<?= $id ?>" style="background: <?= $badgeBg ?>; color: <?= $badgeText ?>; border: 1px solid <?= $cardColor ?>; padding: 6px 12px; font-weight: 600;">
                                <?= $s['status'] ?>
                            </span>
                            <i data-feather="chevron-down" id="toggle-icon-<?= $id ?>" style="color: var(--text-muted); transition: transform 0.3s ease; <?= $isPending ? 'transform: rotate(180deg);' : '' ?>"></i>
                        </div>
                    </div>

                    <!-- Evaluation Rig body -->
                    <div id="body-<?= $id ?>" style="display: <?= $isPending ? 'block' : 'none' ?>; background: rgba(248,250,252,1); border-top: 1px solid var(--border-color);">
                        <div class="grid-2" style="gap: 20px; padding: 20px;">
                            
                            <!-- Evidence Vector Column -->
                            <div class="card p-0" style="background: white; border: 1px solid var(--border-color);">
                                <div style="padding: 12px 16px; border-bottom: 1px solid var(--border-color); background: rgba(248,250,252,0.5);">
                                    <h5 style="margin: 0; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); font-weight: 700; display: flex; align-items: center; gap: 6px;">
                                        <i data-feather="file" style="width: 14px;"></i> Student Submissions
                                    </h5>
                                </div>
                                
                                <?php if (empty($subs)): ?>
                                    <div style="padding: 30px 20px; text-align: center; color: var(--text-muted);">
                                        <i data-feather="inbox" style="width: 32px; height: 32px; color: #cbd5e1; margin-bottom: 10px;"></i>
                                        <div style="font-size: 0.85rem;">No target artifacts isolated for this record.</div>
                                    </div>
                                <?php else: ?>
                                    <div style="display: flex; flex-direction: column;">
                                        <?php foreach ($subs as $sub): ?>
                                            <div style="padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9;">
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <div style="width: 8px; height: 8px; border-radius: 50%; background: <?= $sub['status'] === 'Approved' ? 'var(--success)' : 'var(--warning)' ?>;"></div>
                                                    <span style="font-size: 0.85rem; color: var(--text-primary); font-weight: 500;"><?= htmlspecialchars($sub['slot_title']) ?></span>
                                                </div>
                                                
                                                <?php if ($sub['status'] === 'Approved'): ?>
                                                    <a href="<?= APP_URL ?>/preview/submission/<?= $sub['id'] ?>" target="_blank" style="color: var(--primary); display: inline-flex; align-items: center; justify-content: center; padding: 4px; border-radius: 4px; transition: background 0.2s;" onmouseover="this.style.background='rgba(37,99,235,0.1)';" onmouseout="this.style.background='transparent';">
                                                        <i data-feather="external-link" style="width: 14px;"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- QA Console Column -->
                            <div style="display: flex; flex-direction: column;">
                                
                                <h5 style="margin: 0 0 12px 0; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); font-weight: 700; display: flex; align-items: center; gap: 6px;">
                                    <i data-feather="check-square" style="width: 14px;"></i> Conformance Matrix
                                </h5>
                                
                                <!-- Segmented Status Toggles -->
                                <div style="display: flex; background: #e2e8f0; padding: 4px; border-radius: var(--radius-md); margin-bottom: 15px;">
                                    <input type="radio" name="status-<?= $id ?>" value="Pending" id="status-<?= $id ?>-pending" <?= $s['status'] === 'Pending' ? 'checked' : '' ?> onchange="updateSample(<?= $id ?>, 'Pending')" style="display: none;">
                                    <label for="status-<?= $id ?>-pending" id="lbl-<?= $id ?>-pending" style="flex: 1; text-align: center; padding: 8px; font-size: 0.85rem; border-radius: 4px; cursor: pointer; font-weight: 600; margin: 0; transition: all 0.2s; color: var(--text-muted);">
                                        Review
                                    </label>
                                    
                                    <input type="radio" name="status-<?= $id ?>" value="Compliant" id="status-<?= $id ?>-compliant" <?= $s['status'] === 'Compliant' ? 'checked' : '' ?> onchange="updateSample(<?= $id ?>, 'Compliant')" style="display: none;">
                                    <label for="status-<?= $id ?>-compliant" id="lbl-<?= $id ?>-compliant" style="flex: 1; text-align: center; padding: 8px; font-size: 0.85rem; border-radius: 4px; cursor: pointer; font-weight: 600; margin: 0; transition: all 0.2s; color: var(--text-muted);">
                                        Pass
                                    </label>
                                    
                                    <input type="radio" name="status-<?= $id ?>" value="Non-Compliant" id="status-<?= $id ?>-noncompliant" <?= $s['status'] === 'Non-Compliant' ? 'checked' : '' ?> onchange="updateSample(<?= $id ?>, 'Non-Compliant')" style="display: none;">
                                    <label for="status-<?= $id ?>-noncompliant" id="lbl-<?= $id ?>-noncompliant" style="flex: 1; text-align: center; padding: 8px; font-size: 0.85rem; border-radius: 4px; cursor: pointer; font-weight: 600; margin: 0; transition: all 0.2s; color: var(--text-muted);">
                                        Reject
                                    </label>
                                </div>
                                
                                <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); font-weight: 700; margin-bottom: 8px;">
                                    IQA Telemetry Notes
                                </label>
                                <textarea id="comments-<?= $id ?>" class="form-control" rows="3" style="font-size: 0.85rem; background: white; resize: vertical;" placeholder="Add specific QA directives if rejecting..." onblur="triggerUpdate(<?= $id ?>)"><?= htmlspecialchars($s['comments'] ?? '') ?></textarea>
                                
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- System Reference Side Panel -->
        <div style="position: sticky; top: 120px;">
            <div class="card p-4" style="border: 1px solid var(--border-color); box-shadow: var(--shadow-md);">
                <h3 style="margin-top: 0; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="hard-drive" style="width: 16px;"></i> Trainer Archives
                </h3>
                
                <?php if (empty($prof_docs)): ?>
                    <div style="padding: 15px; background: rgba(245, 158, 11, 0.05); border: 1px dashed rgba(245, 158, 11, 0.4); border-radius: var(--radius-sm); text-align: center; color: var(--warning); font-size: 0.85rem;">
                        No baseline documents allocated by the Trainer.
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <?php foreach ($prof_docs as $doc): ?>
                            <div style="padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 10px; overflow: hidden;">
                                    <div style="width: 32px; height: 32px; border-radius: 6px; background: white; display: flex; align-items: center; justify-content: center; color: var(--primary); border: 1px solid var(--border-color); flex-shrink: 0;">
                                        <i data-feather="file-text" style="width: 14px;"></i>
                                    </div>
                                    <div style="overflow: hidden;">
                                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($doc['type']) ?></div>
                                        <div style="font-size: 0.7rem; text-transform: uppercase; color: <?= $doc['status'] === 'Approved' ? 'var(--success)' : 'var(--warning)' ?>; font-weight: 700;">
                                            <?= $doc['status'] ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($doc['status'] === 'Approved'): ?>
                                    <a href="<?= APP_URL ?>/preview/download?file=docs/<?= $doc['file_path'] ?>" target="_blank" class="btn btn-outline btn-sm" style="padding: 4px 8px; height: auto;">
                                        <i data-feather="external-link" style="width: 12px;"></i> View
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: 20px; font-size: 0.75rem; color: var(--text-muted); text-align: center;">
                Institutional Audit Layer &bull; <?= date('Y') ?>
            </div>
        </div>
        
    </div>
</div>

<script>
    // Initialize Toggle Logics
    function toggleCard(id) {
        const body = document.getElementById('body-' + id);
        const icon = document.getElementById('toggle-icon-' + id);
        const isHidden = body.style.display === 'none';
        
        body.style.display = isHidden ? 'block' : 'none';
        icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    }

    // Initialize Segment Styling on Load
    document.addEventListener("DOMContentLoaded", () => {
        const sampleIds = <?= json_encode(array_keys($samples)) ?>;
        sampleIds.forEach(id => {
            refreshSegmentVisuals(id);
        });
        recalculateProgress();
    });

    function refreshSegmentVisuals(id) {
        // Reset all labels for this ID
        document.getElementById('lbl-' + id + '-pending').style.background = 'transparent';
        document.getElementById('lbl-' + id + '-pending').style.color = 'var(--text-muted)';
        document.getElementById('lbl-' + id + '-pending').style.boxShadow = 'none';
        
        document.getElementById('lbl-' + id + '-compliant').style.background = 'transparent';
        document.getElementById('lbl-' + id + '-compliant').style.color = 'var(--text-muted)';
        document.getElementById('lbl-' + id + '-compliant').style.boxShadow = 'none';
        
        document.getElementById('lbl-' + id + '-noncompliant').style.background = 'transparent';
        document.getElementById('lbl-' + id + '-noncompliant').style.color = 'var(--text-muted)';
        document.getElementById('lbl-' + id + '-noncompliant').style.boxShadow = 'none';

        // Find active radio
        const activeRadio = document.querySelector(`input[name="status-${id}"]:checked`);
        if (activeRadio) {
            const val = activeRadio.value;
            const lbl = document.getElementById('lbl-' + id + '-' + val.toLowerCase().replace(/[^a-z]/g, ''));
            
            lbl.style.background = 'white';
            lbl.style.boxShadow = 'var(--shadow-sm)';
            
            if (val === 'Compliant') lbl.style.color = 'var(--success)';
            else if (val === 'Non-Compliant') lbl.style.color = 'var(--danger)';
            else lbl.style.color = 'var(--text-primary)';
        }
    }

    function recalculateProgress() {
        const sampleIds = <?= json_encode(array_keys($samples)) ?>;
        let completed = 0;
        
        sampleIds.forEach(id => {
            const val = document.querySelector(`input[name="status-${id}"]:checked`).value;
            if (val !== 'Pending') completed++;
        });
        
        document.getElementById('completedCount').innerText = completed;
        const total = sampleIds.length;
        const calc = total > 0 ? (completed / total) * 100 : 0;
        document.getElementById('liveProgress').style.width = calc + '%';
        
        if (calc === 100) {
            document.getElementById('liveProgress').style.background = 'var(--success)';
        } else {
            document.getElementById('liveProgress').style.background = 'var(--primary)';
        }
    }

    function updateSample(id, status) {
        refreshSegmentVisuals(id);
        
        const comments = document.getElementById('comments-' + id).value;
        const badge = document.getElementById('badge-' + id);
        const card = document.getElementById('sample-' + id);

        // Update Global Card UI
        badge.innerText = status;
        
        if (status === 'Compliant') {
            badge.style.background = 'rgba(16,185,129,0.1)';
            badge.style.color = 'var(--success)';
            badge.style.borderColor = 'rgba(16,185,129,0.2)';
            card.style.borderLeftColor = 'var(--success)';
        } else if (status === 'Non-Compliant') {
            badge.style.background = 'rgba(239,68,68,0.1)';
            badge.style.color = 'var(--danger)';
            badge.style.borderColor = 'rgba(239,68,68,0.2)';
            card.style.borderLeftColor = 'var(--danger)';
        } else {
            badge.style.background = '#f1f5f9';
            badge.style.color = 'var(--text-muted)';
            badge.style.borderColor = 'var(--border-color)';
            card.style.borderLeftColor = 'var(--border-color)';
        }

        recalculateProgress();
        saveData(id, status, comments);
    }
    
    function triggerUpdate(id) {
        const activeRadio = document.querySelector(`input[name="status-${id}"]:checked`);
        if (activeRadio) {
            const comments = document.getElementById('comments-' + id).value;
            saveData(id, activeRadio.value, comments);
        }
    }

    function saveData(id, status, comments) {
        fetch('<?= APP_URL ?>/audit/update_sample', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `csrf_token=<?= $_SESSION['csrf_token'] ?>&sample_id=${id}&status=${status}&comments=${encodeURIComponent(comments)}`
        }).then(res => res.json()).then(data => {
            if (!data.success) alert('Network error storing QA metrics.');
        });
    }
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>