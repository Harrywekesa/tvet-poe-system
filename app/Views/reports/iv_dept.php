<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="max-width: 1400px; margin-top: 40px;">
    
    <div class="flex-between align-center mb-4">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.05); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <i data-feather="pie-chart" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h1 class="page-title" style="margin-bottom: 2px; font-size: 1.5rem;">
                    <?= $title ?>
                </h1>
                <p class="text-muted" style="margin: 0; font-size: 0.9rem;">
                    Departmental Verification Coverage Reports
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

    <!-- For Print Mode only -->
    <div style="display: none;" class="print-only">
        <h1 class="page-title"><?= $title ?></h1>
        <p><strong>Generation Timestamp:</strong> <?= date('d M Y H:i') ?></p>
        <br>
    </div>

    <div class="card p-0" style="overflow: hidden; border-radius: var(--radius-lg);">
        <div class="table-responsive">
            <table class="table" style="margin: 0; border: none;">
                <thead style="background: rgba(248, 250, 252, 1); border-bottom: 2px solid var(--border-color);">
                    <tr>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">Department</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: center;">Active Courses</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: center;">Total Submissions</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: center;">Trainer Pass Rate</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: center;">IQA Verified Coverage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row):
                        $passRate = $row['total_evidence'] > 0 ? round(($row['passed_evidence'] / $row['total_evidence']) * 100) : 0;
                        $ivRate = $row['total_evidence'] > 0 ? round(($row['verified_evidence'] / $row['total_evidence']) * 100) : 0;
                        ?>
                        <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.1s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 16px; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                                <i data-feather="briefcase" style="width: 14px; color: var(--text-muted);"></i>
                                <?= htmlspecialchars($row['dept_name']) ?>
                            </td>
                            <td style="padding: 16px; text-align: center; color: var(--text-secondary); font-weight: 600;">
                                <?= $row['active_courses'] ?>
                            </td>
                            <td style="padding: 16px; text-align: center; font-family: monospace; font-size: 1.1rem; color: var(--primary);">
                                <?= $row['total_evidence'] ?>
                            </td>
                            <td style="padding: 16px; text-align: center; font-weight: 800; font-size: 1.1rem; color: <?= $passRate >= 80 ? '#10b981' : ($passRate >= 50 ? '#f59e0b' : '#ef4444') ?>;">
                                <?= $passRate ?>%
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <div style="background: rgba(37,99,235,0.1); border-radius: 4px; height: 8px; width: 100px; display: inline-block; overflow: hidden; vertical-align: middle;">
                                    <div style="background: var(--primary); width: <?= $ivRate ?>%; height: 100%; border-radius: 4px;"></div>
                                </div>
                                <strong style="margin-left: 8px; font-size: 0.95rem; color: var(--text-secondary);">
                                    <?= $ivRate ?>%
                                </strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="5" style="padding: 60px 20px; text-align: center; color: var(--text-muted);">
                                <i data-feather="slash" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                                <div style="font-size: 1.1rem;">No department evidence data found.</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <style>
        @media screen {
            .print-only { display: none !important; }
        }
        @media print {
            .print-only { display: block !important; }
            header, nav, .btn, .no-print, .sidebar-brand, .sidebar { display: none !important; }
            body { background: white !important; color: black !important; margin: 0 !important; padding: 0 !important; }
            .container { max-width: 100% !important; margin: 0 !important; padding: 0 !important; border: none !important; }
            .card { border: none !important; box-shadow: none !important; padding: 0 !important; }
            .page-title { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        }
    </style>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>