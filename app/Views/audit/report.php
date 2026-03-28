<?php require_once __DIR__ . '/../partials/header.php'; ?>
<style>
    @media print {
        header, nav, .btn, .no-print, .sidebar-brand, .sidebar { display: none !important; }
        body { background: white !important; color: black !important; margin: 0 !important; padding: 0 !important; }
        .container { max-width: 100% !important; border: none !important; padding: 0 !important; margin: 0 !important; box-shadow: none !important; }
        .card { border: none !important; box-shadow: none !important; padding: 0 !important; }
        .page-title { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        /* Force CSS Background rendering for printed charts/badges */
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
</style>

<div class="container" style="max-width: 1200px; margin-top: 40px;">
    
    <!-- Action Bar -->
    <div class="no-print flex-between align-center mb-4">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.05); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <i data-feather="file-text" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h1 class="page-title" style="margin-bottom: 2px; font-size: 1.5rem;">Audit Report Verification</h1>
                <p class="text-muted" style="margin: 0; font-size: 0.9rem;">
                    Finalized internal verification compliance record.
                </p>
            </div>
        </div>
        <div style="display: flex; gap: 10px;">
            <?= component('button', ['href' => APP_URL . '/audit', 'label' => 'Back to Workspace', 'variant' => 'outline']) ?>
            <button onclick="window.print()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
                <i data-feather="printer" style="width: 16px;"></i> Print Report
            </button>
        </div>
    </div>

    <!-- Official Report Document Container -->
    <div class="card p-0" style="background: white; border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md);">
        
        <!-- Document Header (Print Specific) -->
        <div style="padding: 40px 40px 30px; border-bottom: 4px solid var(--primary); text-align: center; background: #f8fafc;">
            <h1 style="text-transform: uppercase; font-size: 1.8rem; font-weight: 800; color: var(--text-primary); letter-spacing: 1px; margin-bottom: 8px;">Internal Verification Audit Report</h1>
            <p style="color: var(--text-secondary); margin: 0; text-transform: uppercase; font-size: 0.9rem; font-weight: 600; letter-spacing: 0.5px;">Competence Based Education & Training (CBET)</p>
        </div>

        <div style="padding: 40px;">
            
            <!-- Target Meta Data Grid -->
            <div class="card" style="background: rgba(248, 250, 252, 1); border: 1px solid var(--border-color); padding: 24px; margin-bottom: 40px;">
                <div class="grid-2" style="gap: 30px;">
                    <div>
                        <div style="margin-bottom: 20px;">
                            <span style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Unit of Competency</span>
                            <strong style="display: block; font-size: 1.25rem; color: var(--text-primary); line-height: 1.2;"><?= htmlspecialchars($unit['unit_code']) ?></strong>
                            <span style="color: var(--text-secondary); font-size: 0.95rem;"><?= htmlspecialchars($unit['unit_title']) ?></span>
                        </div>
                        <div>
                            <span style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Class / Cohort</span>
                            <strong style="display: block; font-size: 1.15rem; color: var(--text-primary); line-height: 1.2;"><?= htmlspecialchars($class['class_code']) ?></strong>
                            <span style="color: var(--text-secondary); font-size: 0.9rem;"><?= htmlspecialchars($class['course_title']) ?></span>
                        </div>
                    </div>
                    <div style="text-align: right; border-left: 1px solid #e2e8f0; padding-left: 30px;">
                        <div style="margin-bottom: 15px;">
                            <span style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Audit Execution Date</span>
                            <strong style="display: block; font-size: 1.1rem; color: var(--text-primary);"><?= date('d F Y', strtotime($session['created_at'])) ?></strong>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <span style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Internal Quality Assurer</span>
                            <strong style="display: block; font-size: 1.1rem; color: var(--primary);"><?= htmlspecialchars($_SESSION['name']) ?></strong>
                        </div>
                        <div>
                            <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 6px 14px; font-size: 0.85rem; border: 1px solid rgba(16, 185, 129, 0.2);">
                                <i data-feather="check-circle" style="width: 14px; margin-right: 4px; display: inline-block; vertical-align: middle;"></i> COMPLETED
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistical Overview -->
            <h3 style="font-size: 1.15rem; color: var(--text-secondary); text-transform: uppercase; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i data-feather="bar-chart-2" style="color: var(--primary); width: 20px;"></i> 1. Audit Summary Matrix
            </h3>
            
            <div class="grid-3" style="gap: 20px; margin-bottom: 40px; text-align: center;">
                <div class="card" style="padding: 24px;">
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--text-primary); margin-bottom: 8px; line-height: 1;"><?= $stats['total'] ?></div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Samples Audited</div>
                </div>
                <div class="card" style="padding: 24px; background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2);">
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--success); margin-bottom: 8px; line-height: 1;"><?= $stats['compliant'] ?></div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; color: var(--success);">Compliant Samples found</div>
                </div>
                <div class="card" style="padding: 24px; background: <?= $stats['percentage'] >= 80 ? 'rgba(16, 185, 129, 0.05)' : 'rgba(245, 158, 11, 0.05)' ?>;">
                    <div style="font-size: 2.5rem; font-weight: 800; color: <?= $stats['percentage'] >= 80 ? 'var(--success)' : 'var(--warning)' ?>; margin-bottom: 8px; line-height: 1;"><?= $stats['percentage'] ?>%</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Compliance Integrity Rate</div>
                </div>
            </div>

            <!-- Specific Findings Table -->
            <h3 style="font-size: 1.15rem; color: var(--text-secondary); text-transform: uppercase; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i data-feather="list" style="color: var(--primary); width: 20px;"></i> 2. Detailed Findings
            </h3>
            
            <div class="table-responsive" style="border: 1px solid var(--border-color); border-radius: var(--radius-sm); margin-bottom: 40px; overflow-x: auto;">
                <table class="table" style="margin: 0; border: none; min-width: 600px;">
                    <thead style="background: rgba(248, 250, 252, 1); border-bottom: 2px solid var(--border-color);">
                        <tr>
                            <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; width: 35%;">Student Sample</th>
                            <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; width: 20%;">Compliance Status</th>
                            <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">Remarks / Observations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($samples as $s): 
                            $isCompliant = ($s['status'] === 'Compliant');
                        ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 16px; vertical-align: top;">
                                    <strong style="display: block; color: var(--text-primary); font-size: 0.95rem; margin-bottom: 4px;"><?= htmlspecialchars($s['full_name']) ?></strong>
                                    <span style="font-size: 0.8rem; color: var(--text-muted); font-family: monospace; display: block; border: 1px solid #e2e8f0; background: #f8fafc; padding: 2px 6px; border-radius: 4px; width: fit-content;"><?= htmlspecialchars($s['identifier']) ?></span>
                                </td>
                                <td style="padding: 16px; vertical-align: top;">
                                    <span class="badge" style="background: <?= $isCompliant ? 'rgba(16,185,129,0.1)' : 'rgba(239,68,68,0.1)' ?>; color: <?= $isCompliant ? 'var(--success)' : 'var(--danger)' ?>; border: 1px solid <?= $isCompliant ? 'rgba(16,185,129,0.2)' : 'rgba(239,68,68,0.2)' ?>;">
                                        <?= htmlspecialchars($s['status']) ?>
                                    </span>
                                </td>
                                <td style="padding: 16px; vertical-align: top; font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5;">
                                    <?= nl2br(htmlspecialchars($s['comments'] ?? '-')) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($samples)): ?>
                            <tr>
                                <td colspan="3" style="padding: 40px; text-align: center; color: var(--text-muted);">
                                    <i data-feather="slash" style="width: 32px; height: 32px; color: #cbd5e1; margin-bottom: 15px;"></i>
                                    <div>No specific samples recorded in this audit session.</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Global Validation Rules -->
            <h3 style="font-size: 1.15rem; color: var(--text-secondary); text-transform: uppercase; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i data-feather="check-square" style="color: var(--primary); width: 20px;"></i> 3. Macro Observations
            </h3>
            
            <div class="card" style="padding: 24px; background: rgba(248, 250, 252, 0.5); border: 1px solid var(--border-color); margin-bottom: 50px;">
                <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px;">
                    <i data-feather="check-circle" style="color: var(--success); width: 18px; flex-shrink: 0; margin-top: 2px;"></i>
                    <span style="font-size: 0.95rem; color: var(--text-primary);">Trainer Professional Documents are active, versioned, and approved.</span>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px;">
                    <i data-feather="check-circle" style="color: var(--success); width: 18px; flex-shrink: 0; margin-top: 2px;"></i>
                    <span style="font-size: 0.95rem; color: var(--text-primary);">Assessment Tools align flawlessly with the registered Unit Curriculum.</span>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <i data-feather="<?= $stats['percentage'] >= 80 ? 'check-circle' : 'x-circle' ?>" style="color: <?= $stats['percentage'] >= 80 ? 'var(--success)' : 'var(--danger)' ?>; width: 18px; flex-shrink: 0; margin-top: 2px;"></i>
                    <span style="font-size: 0.95rem; color: var(--text-primary);">Student Evidence meets the required institutional threshold (Compliance &ge; 80%).</span>
                </div>
            </div>

            <!-- Final Documentation Block -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px dashed var(--border-color); padding-top: 40px; margin-top: auto; max-width: 800px; padding-right: 40px;" class="print-signature">
                <div style="flex: 1; text-align: center; max-width: 250px;">
                    <div style="height: 60px; border-bottom: 1px solid #94a3b8; margin-bottom: 10px;"></div>
                    <strong style="display: block; font-size: 0.95rem; color: var(--text-primary); text-transform: uppercase;">Internal Quality Assurer</strong>
                    <span style="font-size: 0.8rem; color: var(--text-muted); font-style: italic;">Official Signature</span>
                </div>
                <div style="flex: 1; text-align: center; max-width: 150px;">
                    <div style="height: 80px; width: 80px; margin: 0 auto 10px auto; border: 2px dashed #94a3b8; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; text-align: center; line-height: 1.2;">Official<br>Stamp</span>
                    </div>
                </div>
                <div style="flex: 1; text-align: center; max-width: 200px;">
                    <div style="height: 60px; border-bottom: 1px solid #94a3b8; margin-bottom: 10px;"></div>
                    <strong style="display: block; font-size: 0.95rem; color: var(--text-primary); text-transform: uppercase;">Date Signed</strong>
                    <span style="font-size: 0.85rem; color: var(--text-muted); font-family: monospace;"><?= date('d M Y') ?></span>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 50px; font-size: 0.75rem; color: #cbd5e1; text-transform: uppercase; font-family: monospace; letter-spacing: 1px;">
                System Generated Report &bull; CBET POE System &bull; <?= date('Y-m-d H:i:s') ?>
            </div>

        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>