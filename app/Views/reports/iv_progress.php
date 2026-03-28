<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="max-width: 1400px; margin-top: 40px;">
    
    <div class="flex-between align-center mb-4">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.05); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <i data-feather="trending-up" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h1 class="page-title" style="margin-bottom: 2px; font-size: 1.5rem;">
                    <?= $title ?>
                </h1>
                <p class="text-muted" style="margin: 0; font-size: 0.9rem;">
                    Student Class & Unit Progression Pipelines
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

    <!-- Print Headers -->
    <div style="display: none;" class="print-only">
        <h1 class="page-title"><?= $title ?></h1>
        <p><strong>Generated Report:</strong> <?= date('d M Y H:i') ?></p>
        <br>
    </div>

    <div class="card p-0" style="overflow: hidden; border-radius: var(--radius-lg);">
        <div class="table-responsive">
            <table class="table" style="margin: 0; border: none;">
                <thead style="background: rgba(248, 250, 252, 1); border-bottom: 2px solid var(--border-color);">
                    <tr>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; width: 35%;">Unit Details</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">Student Class</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: center;">Total Submissions</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: center;">IQA Verified</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: center;">Audit Coverage</th>
                        <th class="no-print" style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row):
                        $cov = $row['total_submitted'] > 0 ? round(($row['total_verified'] / $row['total_submitted']) * 100) : 0;
                        ?>
                        <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.1s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 16px;">
                                <div style="font-weight: 700; color: var(--text-primary); font-size: 1rem; margin-bottom: 2px;">
                                    <?= htmlspecialchars($row['unit_code']) ?>
                                </div>
                                <div style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.3;">
                                    <?= htmlspecialchars($row['unit_title']) ?>
                                </div>
                            </td>
                            <td style="padding: 16px; font-family: monospace; font-size: 0.95rem; font-weight: 600; color: var(--primary);">
                                <?= htmlspecialchars($row['class_code']) ?>
                            </td>
                            <td style="padding: 16px; text-align: center; color: var(--text-secondary); font-weight: 600;">
                                <?= $row['total_submitted'] ?>
                            </td>
                            <td style="padding: 16px; text-align: center; color: var(--success); font-weight: 800; font-size: 1.1rem;">
                                <?= $row['total_verified'] ?>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <span class="badge" style="background: <?= $cov >= 20 ? 'rgba(16,185,129,0.1)' : 'rgba(245,158,11,0.1)' ?>; color: <?= $cov >= 20 ? 'var(--success)' : 'var(--warning)' ?>; padding: 6px 14px; font-size: 0.9rem; font-weight: 700; min-width: 65px; display: inline-block;">
                                    <?= $cov ?>%
                                </span>
                            </td>
                            <td class="no-print" style="padding: 16px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="<?= APP_URL ?>/marks/marksheet/<?= $row['unit_id'] ?>/<?= $row['class_id'] ?>"
                                        title="View System Marksheet" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; height: 32px;">
                                        <i data-feather="grid" style="width: 14px;"></i>
                                    </a>
                                    <a href="<?= APP_URL ?>/audit/workspace?class_id=<?= $row['class_id'] ?>&unit_id=<?= $row['unit_id'] ?>"
                                        title="Enter Audit Workspace" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; height: 32px;">
                                        <i data-feather="search" style="width: 14px;"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="6" style="padding: 60px 20px; text-align: center; color: var(--text-muted);">
                                <i data-feather="slash" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                                <div style="font-size: 1.1rem;">No enrolled students found pending verification.</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Official Signature Block (Forces Print Media Display) -->
    <div style="display: none; margin-top: 80px; padding-top: 30px; border-top: 2px dashed #000; justify-content: space-between; align-items: flex-end; max-width: 800px; padding-right: 40px;" class="print-only print-signature">
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
    
    <style>
        @media screen {
            .print-only { display: none !important; }
        }
        @media print {
            .print-only { display: block !important; }
            .print-only.print-signature { display: flex !important; margin-top: 50px !important; margin-left: auto; margin-right: auto; }
            header, nav, .btn, .no-print, .sidebar-brand, .sidebar { display: none !important; }
            body { background: white !important; color: black !important; margin: 0 !important; padding: 0 !important; }
            .container { max-width: 100% !important; margin: 0 !important; padding: 0 !important; border: none !important; }
            .card { border: none !important; box-shadow: none !important; padding: 0 !important; }
            .page-title { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        }
    </style>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>