<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="max-width: 1400px; margin-top: 40px;">
    
    <div class="flex-between align-center mb-4">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(139,92,246,0.05); display: flex; align-items: center; justify-content: center; color: #8b5cf6;">
                <i data-feather="users" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h1 class="page-title" style="margin-bottom: 2px; font-size: 1.5rem;">
                    <?= $title ?>
                </h1>
                <p class="text-muted" style="margin: 0; font-size: 0.9rem;">
                    Trainer Grading Calibration and Validation Matrices
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

    <div class="grid-3">
        <?php foreach ($data as $d):
            $agreeRate = $d['total_checked'] > 0 ? round(($d['agreed'] / $d['total_checked']) * 100) : 0;
            ?>
            <div class="card popup-card" style="transition: transform 0.2s, box-shadow 0.2s; padding: 24px;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                <div class="flex-between align-start" style="margin-bottom: 20px;">
                    <div>
                        <h3 style="margin:0; font-size: 1.15rem; color: var(--text-primary);">
                            <?= htmlspecialchars($d['trainer_name']) ?>
                        </h3>
                        <p style="color: var(--text-muted); margin: 6px 0 0 0; font-size: 0.85rem; display: flex; align-items: center; gap: 4px;">
                            <i data-feather="file" style="width: 12px;"></i> Sampled: <?= $d['total_checked'] ?> evidence records
                        </p>
                    </div>
                    <div style="text-align: right; background: rgba(248, 250, 252, 1); padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border-color);">
                        <div style="font-size: 1.5rem; font-weight: 800; color: <?= $agreeRate >= 90 ? 'var(--success)' : ($agreeRate >= 70 ? 'var(--warning)' : 'var(--danger)') ?>;">
                            <?= $agreeRate ?>%
                        </div>
                        <small style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Agreement Rate</small>
                    </div>
                </div>
                
                <div style="margin-top: auto; display: flex; gap: 10px; border-top: 1px dashed var(--border-color); padding-top: 20px;">
                    <div style="flex: 1; background: rgba(16,185,129,0.05); border: 1px solid rgba(16,185,129,0.2); color: var(--success); padding: 10px; border-radius: var(--radius-sm); text-align: center;">
                        <i data-feather="check-circle" style="width: 16px; margin-bottom: 4px;"></i>
                        <div style="font-weight: 700; font-size: 1.1rem;"><?= $d['agreed'] ?></div>
                        <div style="font-size: 0.75rem; text-transform: uppercase;">Agreed</div>
                    </div>
                    
                    <div style="flex: 1; background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.2); color: var(--danger); padding: 10px; border-radius: var(--radius-sm); text-align: center;">
                        <i data-feather="x-circle" style="width: 16px; margin-bottom: 4px;"></i>
                        <div style="font-weight: 700; font-size: 1.1rem;"><?= $d['disagreed'] ?></div>
                        <div style="font-size: 0.75rem; text-transform: uppercase;">Disagreed</div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($data)): ?>
            <div style="grid-column: 1 / -1;">
                <div class="card" style="padding: 60px 20px; text-align: center; color: var(--text-muted);">
                    <i data-feather="slash" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                    <div style="font-size: 1.1rem;">No trainer verification data available yet.</div>
                </div>
            </div>
        <?php endif; ?>
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
            .card { border: 1px solid #e2e8f0 !important; box-shadow: none !important; page-break-inside: avoid; }
            .page-title { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        }
    </style>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>