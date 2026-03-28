<?php require_once __DIR__ . '/../partials/header.php'; ?>
<style>
    @media print {
        header, nav, .btn, .no-print, .sidebar-brand, .sidebar {
            display: none !important;
        }

        body {
            background: white !important;
            color: black !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .container {
            max-width: 100% !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            box-shadow: none !important;
        }
        
        .card {
            border: none !important;
            box-shadow: none !important;
        }

        .section-break {
            page-break-inside: avoid;
            margin-bottom: 20px;
        }
    }
</style>

<div class="container" style="max-width: 1400px; margin-top: 40px;">
    
    <div class="card" style="padding: 40px;">
        <div class="no-print flex-between align-center" style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.05); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                    <i data-feather="file-text" style="width: 24px; height: 24px;"></i>
                </div>
                <div>
                    <h1 class="page-title" style="margin-bottom: 2px; font-size: 1.5rem;">Internal Verification Report</h1>
                    <p class="text-muted" style="margin: 0; font-size: 0.9rem;">
                        Generated on: <?= date('d M Y H:i') ?>
                    </p>
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <?= component('button', ['href' => APP_URL . '/dashboard', 'label' => 'Back to Matrix', 'variant' => 'outline']) ?>
                <button onclick="window.print()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
                    <i data-feather="printer" style="width: 16px;"></i> Print Report
                </button>
            </div>
        </div>

        <!-- Executive Summary -->
        <div style="margin-bottom: 40px; border-left: 4px solid var(--primary); padding: 20px; background: rgba(248, 250, 252, 1); border-radius: 0 var(--radius-md) var(--radius-md) 0;">
            <h4 style="margin-top: 0; font-size: 1.15rem; color: var(--text-primary); margin-bottom: 8px;">Executive Summary</h4>
            <p style="margin: 0; color: var(--text-muted); font-size: 1rem;">
                <strong>Scope:</strong> Evaluated <span style="font-weight: 800; color: var(--primary);"><?= $summary['sampled_units'] ?> units</span> out of a total possible <span style="font-weight: 800; color: var(--primary);"><?= $summary['total_units'] ?> units</span> operating securely within this department jurisdiction.
            </p>
        </div>

        <?php
        // Group rows by Course -> Level
        $grouped = [];
        foreach ($rows as $r) {
            $grouped[$r['course_title']]['Level ' . $r['level']][] = $r;
        }
        ?>

        <?php foreach ($grouped as $courseTitle => $levels): ?>
            <div class="section-break" style="margin-bottom: 50px;">
                <h2 style="color: var(--text-primary); border-bottom: 2px solid var(--border-color); padding-bottom: 15px; margin-bottom: 20px; font-size: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i data-feather="bookmark" style="color: var(--secondary); width: 20px;"></i> <?= htmlspecialchars($courseTitle) ?>
                </h2>

                <?php foreach ($levels as $levelName => $units): ?>
                    <div style="margin-bottom: 30px; margin-left: 10px;">
                        <h3 style="color: var(--text-secondary); font-size: 1.1rem; margin-bottom: 15px; border-left: 3px solid var(--border-color); padding-left: 10px;">
                            <?= htmlspecialchars($levelName) ?>
                        </h3>

                        <div class="table-responsive" style="border: 1px solid var(--border-color); border-radius: var(--radius-sm); overflow-x: auto;">
                            <table class="table" style="margin: 0; min-width: 800px;">
                                <thead style="background: rgba(248, 250, 252, 1);">
                                    <tr>
                                        <th style="padding: 12px 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; width: 30%;">Unit Module</th>
                                        <th style="padding: 12px 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; width: 20%;">Trainer Details</th>
                                        <th style="padding: 12px 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; text-align: center; width: 10%;">Sampled</th>
                                        <th style="padding: 12px 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; text-align: center; width: 10%;">Accepted</th>
                                        <th style="padding: 12px 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; text-align: center; width: 10%;">Rejected</th>
                                        <th style="padding: 12px 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; width: 20%;">Reasons / Findings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($units as $u): ?>
                                        <tr style="border-top: 1px solid var(--border-color);">
                                            <td style="padding: 16px;">
                                                <div style="font-weight: 700; color: var(--text-primary); font-size: 0.95rem; margin-bottom: 2px;">
                                                    <?= htmlspecialchars($u['unit_code']) ?>
                                                </div>
                                                <div style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.3;">
                                                    <?= htmlspecialchars($u['unit_title']) ?>
                                                </div>
                                            </td>
                                            <td style="padding: 16px; color: var(--text-secondary); font-size: 0.95rem;">
                                                <div style="display: flex; align-items: center; gap: 6px;">
                                                    <i data-feather="user" style="width: 14px;"></i> <?= htmlspecialchars($u['trainer_name']) ?>
                                                </div>
                                            </td>
                                            <td style="padding: 16px; text-align: center; font-family: monospace; font-size: 1rem; color: var(--text-primary); font-weight: 600;">
                                                <?= $u['verification_count'] ?>
                                            </td>
                                            <td style="padding: 16px; text-align: center; color: var(--success); font-weight: 800; font-size: 1.1rem;">
                                                <?= $u['accepted_count'] ?>
                                            </td>
                                            <td style="padding: 16px; text-align: center; color: var(--danger); font-weight: 800; font-size: 1.1rem;">
                                                <?= $u['rejected_count'] ?>
                                            </td>
                                            <td style="padding: 16px;">
                                                <?php if ($u['rejected_count'] > 0 && !empty($u['rejection_reasons'])): ?>
                                                    <div style="background: rgba(239, 68, 68, 0.05); padding: 8px; border-radius: 4px; font-size: 0.8rem; color: var(--danger); display: flex; align-items: flex-start; gap: 6px; border: 1px solid rgba(239, 68, 68, 0.2);">
                                                        <i data-feather="alert-triangle" style="width: 14px; flex-shrink: 0; margin-top: 2px;"></i>
                                                        <span><?= htmlspecialchars($u['rejection_reasons']) ?></span>
                                                    </div>
                                                <?php elseif ($u['accepted_count'] > 0): ?>
                                                    <div style="display: flex; align-items: center; gap: 6px; color: var(--success); font-size: 0.85rem; font-weight: 600;">
                                                        <i data-feather="check" style="width: 14px;"></i> Standards Met
                                                    </div>
                                                <?php else: ?>
                                                    <span style="color: var(--text-muted);">No Action Base</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        
        <?php if(empty($grouped)): ?>
            <div style="padding: 60px 20px; text-align: center; color: var(--text-muted);">
                <i data-feather="slash" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                <div style="font-size: 1.1rem;">No department evidence data found.</div>
            </div>
        <?php endif; ?>

        <!-- Official Signature Block (Forces Print Media Display) -->
        <div style="margin-top: 80px; padding-top: 30px; border-top: 2px dashed #000; display: flex; justify-content: space-between; align-items: flex-end; max-width: 800px; padding-right: 40px;" class="print-signature">
            <div style="flex: 1; text-align: center;">
                <p style="font-size: 0.9rem; color: #666; font-weight: bold; text-transform: uppercase;">IQA Verification</p>
                <div style="height: 60px; border-bottom: 1px solid #000; margin: 0 auto 10px auto; width: 80%;"></div>
                <p style="font-size: 0.85rem; color: #333;">Official Signature</p>
            </div>
            <div style="flex: 1; text-align: center;">
                <div style="height: 80px; width: 80px; margin: 0 auto 10px auto; border: 2px dashed #000; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 0.65rem; color: #000; text-transform: uppercase; text-align: center; line-height: 1.2;">Official<br>Stamp</span>
                </div>
            </div>
            <div style="flex: 1; text-align: center;">
                <p style="font-size: 0.9rem; color: #666; font-weight: bold; text-transform: uppercase;">Date Signed</p>
                <div style="height: 60px; border-bottom: 1px solid #000; margin: 0 auto 10px auto; width: 60%;"></div>
                <p style="font-size: 0.85rem; color: #333; font-family: monospace;"><?= date('d M Y') ?></p>
            </div>
        </div>
        
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>