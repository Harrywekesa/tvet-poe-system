<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="margin-top: 40px; max-width: 1400px;">
    
    <div class="flex-between align-center mb-4">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.05); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <i data-feather="crosshair" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h1 class="page-title" style="margin-bottom: 2px; font-size: 1.5rem;">Audit Workspace</h1>
                <p class="text-muted" style="margin: 0; font-size: 0.9rem;">
                    <?= htmlspecialchars($unit['unit_title']) ?> <span class="badge" style="background:#f1f5f9; color:var(--text-secondary); margin-left: 6px;"><?= htmlspecialchars($class['class_code']) ?></span>
                </p>
            </div>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 6px 12px; display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
                <div class="pulsing-dot" style="width: 6px; height: 6px; border-radius: 50%; background: var(--success);"></div> IV Mode Active
            </span>
            <?= component('button', ['href' => APP_URL . '/dashboard', 'label' => 'Exit Audit', 'variant' => 'outline']) ?>
        </div>
    </div>

    <div class="grid-main-side" style="align-items: start; gap: 30px; grid-template-columns: 350px 1fr;">

        <!-- Left: Professional Docs & Reference -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div class="card" style="border-left: 4px solid var(--primary); padding: 24px;">
                <h3 style="margin-top: 0; font-size: 1.15rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                    <i data-feather="hard-drive" style="width: 18px; color: var(--primary);"></i> Professional Documents
                </h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">Verify these mapped trainer artifacts against the student sub-grades.</p>

                <?php if (empty($prof_docs)): ?>
                    <div style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.2); padding: 12px; border-radius: 6px; display: flex; align-items: center; gap: 10px; color: var(--danger);">
                        <i data-feather="alert-circle" style="width: 18px;"></i>
                        <span style="font-size: 0.85rem; font-weight: 500;">No trainer artifacts uploaded.</span>
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <?php foreach ($prof_docs as $pd): ?>
                            <div style="padding: 12px; background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-sm); display: flex; justify-content: space-between; align-items: center;">
                                <strong style="font-size: 0.9rem; color: var(--text-primary);"><?= htmlspecialchars($pd['type']) ?></strong>
                                <a href="<?= APP_URL ?>/preview/download?file=docs/<?= $pd['file_path'] ?>" target="_blank" style="font-size: 0.85rem; color: var(--primary); display: inline-flex; align-items: center; gap: 4px; text-decoration: none; font-weight: 600;">
                                    View <i data-feather="external-link" style="width: 14px;"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card" style="padding: 24px; background: #f8fafc; border: 1px solid var(--border-color);">
                <h4 style="margin-top: 0; font-size: 1rem; color: var(--text-secondary); display: flex; align-items: center; gap: 8px;">
                    <i data-feather="check-square" style="width: 16px;"></i> Audit Checklist
                </h4>
                <ul style="font-size: 0.9rem; padding-left: 20px; color: var(--text-muted); margin-bottom: 0;">
                    <li style="margin-bottom: 8px;">Check Marksheet vs POE Evidence</li>
                    <li style="margin-bottom: 8px;">Verify Attendance meets threshold</li>
                    <li>Ensure Course Outline followed</li>
                </ul>
            </div>
        </div>

        <!-- Right: Student Evidence -->
        <div class="card p-0" style="overflow: hidden; border-radius: var(--radius-lg);">
            <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid var(--border-color);">
                <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary);">Student Validation Matrix</h3>
            </div>
            
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table" style="margin: 0; min-width: 600px;">
                    <thead style="background: rgba(248, 250, 252, 1); border-bottom: 2px solid var(--border-color);">
                        <tr>
                            <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; width: 25%;">Student Details</th>
                            <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">Assessment Evidence</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $s):
                            $subs = $poe_data[$s['id']] ?? [];
                        ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 20px; vertical-align: top; background: #f8fafc;">
                                    <div style="font-weight: 600; color: var(--text-primary); font-size: 1.05rem; margin-bottom: 4px;"><?= htmlspecialchars($s['full_name']) ?></div>
                                    <div style="font-size: 0.85rem; color: var(--primary); font-family: monospace; font-weight: 600; margin-bottom: 4px;">
                                        <?= htmlspecialchars($s['identifier']) ?>
                                    </div>
                                    <div style="font-size: 0.85rem; color: var(--text-muted);">
                                        <?= htmlspecialchars($s['email']) ?>
                                    </div>
                                </td>

                                <td style="padding: 0;">
                                    <?php if (empty($subs)): ?>
                                        <div style="padding: 30px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--text-muted);">
                                            <i data-feather="folder-minus" style="width: 32px; height: 32px; color: #cbd5e1; margin-bottom: 10px;"></i>
                                            <span style="font-size: 0.9rem;">No submission artifacts found for verification.</span>
                                        </div>
                                    <?php else: ?>
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <?php foreach ($subs as $sub):
                                                $subId = $sub['id'];
                                                $status = $sub['status'];
                                                $verification = $sub['verification_status'] ?? 'Pending';

                                                $verColor = match ($verification) {
                                                    'Accepted', 'Verified' => 'var(--success)',
                                                    'Rejected', 'Flagged', 'IV_Rejected' => 'var(--danger)',
                                                    default => 'var(--warning)'
                                                };
                                                
                                                $displayTitle = !empty($sub['topic_title']) 
                                                    ? '<span style="color:var(--text-muted); font-size:0.8rem; font-weight:600; text-transform:uppercase;">' . htmlspecialchars($sub['topic_title']) . '</span> <div style="margin-top:2px;">' . htmlspecialchars($sub['slot_title'] ?? 'Assessment ' . $sub['assessment_slot_id']) . '</div>'
                                                    : htmlspecialchars($sub['slot_title'] ?? 'Assessment ' . $sub['assessment_slot_id']);
                                                    
                                                $type = $sub['slot_type'] ?? 'Assessment';
                                            ?>
                                                <tr style="border-bottom: 1px dashed var(--border-color);">
                                                    <td style="padding: 16px; width: 45%;">
                                                        <div style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary); line-height: 1.4;">
                                                            <?= $displayTitle ?>
                                                        </div>
                                                        <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 6px; text-transform: uppercase; display: flex; align-items: center; gap: 8px;">
                                                            <span class="badge" style="background:#f1f5f9; color:var(--text-muted); border:1px solid #e2e8f0;"><?= htmlspecialchars($type) ?></span>
                                                            <strong style="color: var(--text-primary);"><i data-feather="corner-down-right" style="width: 12px;"></i> Trainer: <?= htmlspecialchars($status) ?></strong>
                                                        </div>
                                                        
                                                        <div style="margin-top: 12px;">
                                                            <a href="<?= APP_URL ?>/preview/submission/<?= $subId ?>" target="_blank"
                                                                class="btn btn-outline" style="font-size: 0.75rem; padding: 4px 10px; display: inline-flex; align-items: center; gap: 4px;">
                                                                <i data-feather="search" style="width: 12px;"></i> View Evidence
                                                            </a>
                                                        </div>
                                                    </td>
                                                    
                                                    <td style="padding: 16px; background: rgba(248, 250, 252, 0.5);">
                                                        <form action="<?= APP_URL ?>/review/verification_update" method="POST"
                                                            style="background: white; padding: 12px; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="submission_id" value="<?= $subId ?>">
                                                            <input type="hidden" name="redirect_url"
                                                                value="<?= $_SERVER['REQUEST_URI'] ?>">

                                                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                                                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">QA Status:</span>
                                                                <span class="badge" style="background: rgba(0,0,0,0.03); color: <?= $verColor ?>; border: 1px solid rgba(0,0,0,0.05);">
                                                                    <div class="pulsing-dot" style="width: 6px; height: 6px; border-radius: 50%; background: <?= $verColor ?>; margin-right: 4px; display: inline-block;"></div> <?= htmlspecialchars($verification) ?>
                                                                </span>
                                                            </div>

                                                            <?php
                                                            $verCheck = trim(strtolower($verification));
                                                            $isVerified = in_array($verCheck, ['verified', 'completed', 'iv_rejected']);
                                                            ?>

                                                            <?php if (!$isVerified): ?>
                                                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                                                    <button type="submit" name="status" value="Verified" title="Standard Met" class="btn btn-primary btn-sm" style="flex: 1; padding: 6px; background: var(--success); border-color: var(--success);">
                                                                        <i data-feather="check" style="width: 14px;"></i> Pass
                                                                    </button>
                                                                    <button type="submit" name="status" value="IV_Rejected" title="Standard Failed" class="btn btn-primary btn-sm" style="flex: 1; padding: 6px; background: var(--danger); border-color: var(--danger);">
                                                                        <i data-feather="x" style="width: 14px;"></i> Reject
                                                                    </button>
                                                                    <input type="text" name="cv_reason" placeholder="Add QC comment if rejected..." class="form-control"
                                                                        style="font-size: 0.8rem; height: 32px; padding: 4px 8px; width: 100%; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
                                                                </div>
                                                            <?php endif; ?>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>