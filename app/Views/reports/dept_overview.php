<?php require_once __DIR__ . '/../partials/header.php'; ?>
<style>
    @media print {
        header,
        nav,
        .btn,
        .no-print,
        .sidebar-brand,
        .sidebar {
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
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
        
        .page-title {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
    }
</style>

<div class="container" style="max-width: 1400px; margin-top: 40px;">
    
    <div class="flex-between align-center no-print" style="margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.05); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <i data-feather="bar-chart-2" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h1 class="page-title" style="margin-bottom: 2px; font-size: 1.5rem;">
                    <?= $title ?>
                </h1>
                <p class="text-muted" style="margin: 0; font-size: 0.9rem;">
                    Report Generated on: <?= date('d M Y H:i') ?>
                </p>
            </div>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <?= component('button', ['href' => APP_URL . '/dashboard', 'label' => 'Back to Dashboard', 'variant' => 'outline']) ?>
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
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">Class / Cohort</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">Unit Code</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">Unit Title</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">Assigned Trainer</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: center;">Verified Docs</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: center;">Rejected</th>
                        <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: center;">Pending Review</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.1s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 16px; font-weight: 700; color: var(--text-primary);">
                                <?= htmlspecialchars($row['class_code']) ?>
                            </td>
                            <td style="padding: 16px;">
                                <span style="font-family: monospace; font-size: 0.85rem; background: var(--bg-app); padding: 4px 8px; border-radius: 4px; border: 1px solid var(--border-color); color: var(--text-muted);">
                                    <?= htmlspecialchars($row['unit_code']) ?>
                                </span>
                            </td>
                            <td style="padding: 16px; font-weight: 500; color: var(--text-primary);">
                                <?= htmlspecialchars($row['unit_title']) ?>
                            </td>
                            <td style="padding: 16px; color: var(--text-secondary);">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <i data-feather="user" style="width: 14px;"></i> <?= htmlspecialchars($row['trainer_name']) ?>
                                </div>
                            </td>
                            <td style="padding: 16px; text-align: center; color: #10b981; font-weight: 800; font-size: 1.1rem;">
                                <?= $row['approved_count'] ?>
                            </td>
                            <td style="padding: 16px; text-align: center; color: #ef4444; font-weight: 800; font-size: 1.1rem;">
                                <?= $row['rejected_count'] ?>
                            </td>
                            <td style="padding: 16px; text-align: center; color: #f59e0b; font-weight: 800; font-size: 1.1rem;">
                                <?= $row['pending_count'] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="7" style="padding: 60px 20px; text-align: center; color: var(--text-muted);">
                                <i data-feather="slash" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                                <div style="font-size: 1.1rem;">No classes or units found for this department.</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Official Signature Block (Forces Print Media Display) -->
    <div style="margin-top: 60px; padding-top: 30px; border-top: 2px dashed #000; display: flex; justify-content: space-between; max-width: 800px; padding-right: 40px;" class="print-signature">
        <div style="flex: 1;">
            <p style="font-size: 0.9rem; color: #666; font-weight: bold; text-transform: uppercase;">Head of Department Approval</p>
            <div style="height: 60px; border-bottom: 1px solid #000; margin-bottom: 10px; width: 80%;"></div>
            <p style="font-size: 0.85rem; color: #333;">Signature & Stamp</p>
        </div>
        <div style="flex: 1;">
            <p style="font-size: 0.9rem; color: #666; font-weight: bold; text-transform: uppercase;">Date Signed</p>
            <div style="height: 60px; border-bottom: 1px solid #000; margin-bottom: 10px; width: 60%;"></div>
            <p style="font-size: 0.85rem; color: #333;">Official Date</p>
        </div>
    </div>
    
    <style>
        @media screen {
            .print-only { display: none !important; }
            .print-signature { opacity: 0.5; }
        }
        @media print {
            .print-only { display: block !important; }
            .print-signature { opacity: 1; margin-top: 100px; page-break-inside: avoid;}
        }
    </style>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>