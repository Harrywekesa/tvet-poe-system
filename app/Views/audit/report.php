<?php
$title = 'Audit Report';
ob_start();
?>

<div class="card p-4 mb-4 no-print border-0 shadow-sm">
    <div class="flex-between align-center">
        <div>
            <h2 class="m-0 text-base">Audit Report Preview</h2>
            <p class="text-sm text-gray m-0">Finalized internal verification report.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()" class="btn btn-primary d-flex align-center gap-2">
                <span>🖨️</span> Print Report
            </button>
            <a href="<?= APP_URL ?>/audit" class="btn btn-outline">Dashboard</a>
        </div>
    </div>
</div>

<div class="report-container shadow-lg">
    <!-- Header -->
    <div class="report-header text-center mb-5 pb-4 border-bottom-thick">
        <h1 class="uppercase text-xl font-bold tracking-wide m-0 text-dark">Internal Verification Audit Report</h1>
        <p class="text-gray m-0 mt-1 uppercase text-sm">Competence Based Education & Training (CBET)</p>
    </div>

    <!-- Meta Grid -->
    <div class="report-meta mb-5 border rounded p-4 bg-light">
        <div class="grid-2 gap-5">
            <div>
                <div class="meta-item mb-3">
                    <span class="meta-label">Unit of Competency</span>
                    <strong class="meta-value d-block text-lg"><?= htmlspecialchars($unit['unit_code']) ?></strong>
                    <span class="text-gray text-sm"><?= htmlspecialchars($unit['unit_title']) ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Class / Cohort</span>
                    <strong class="meta-value d-block"><?= htmlspecialchars($class['class_code']) ?></strong>
                    <span class="text-gray text-sm"><?= htmlspecialchars($class['course_title']) ?></span>
                </div>
            </div>
            <div class="text-right-md">
                <div class="meta-item mb-3">
                    <span class="meta-label">Audit Date</span>
                    <strong class="meta-value d-block"><?= date('d F Y', strtotime($session['created_at'])) ?></strong>
                </div>
                <div class="meta-item mb-3">
                    <span class="meta-label">Internal Verifier</span>
                    <strong class="meta-value d-block"><?= $_SESSION['name'] ?></strong>
                    <span class="text-xs text-gray">ID: <?= $_SESSION['user_id'] ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Status</span>
                    <span class="badge bg-success text-white px-3 py-1 rounded-pill">COMPLETED</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <h3 class="section-title">1. Audit Summary</h3>
    <div class="grid-3 gap-4 mb-5 text-center">
        <div class="stat-card">
            <div class="stat-value"><?= $stats['total'] ?></div>
            <div class="stat-label">Samples Audited</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-success"><?= $stats['compliant'] ?></div>
            <div class="stat-label">Compliant Samples</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $stats['percentage'] ?>%</div>
            <div class="stat-label">Compliance Rate</div>
        </div>
    </div>

    <!-- Findings Table -->
    <h3 class="section-title">2. Detailed Findings</h3>
    <table class="table w-100 mb-5 report-table">
        <thead>
            <tr class="bg-gray-100">
                <th width="35%">Student Sample</th>
                <th width="15%">Status</th>
                <th>Remarks / Observations</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($samples as $s): ?>
                <tr>
                    <td class="align-top">
                        <strong class="d-block text-dark"><?= htmlspecialchars($s['full_name']) ?></strong>
                        <span class="text-sm text-gray"><?= htmlspecialchars($s['identifier']) ?></span>
                    </td>
                    <td class="align-top">
                        <span
                            class="status-indicator <?= $s['status'] === 'Compliant' ? 'status-success' : ($s['status'] === 'Non-Compliant' ? 'status-danger' : 'status-gray') ?>">
                            <?= $s['status'] ?>
                        </span>
                    </td>
                    <td class="align-top text-sm">
                        <?= nl2br(htmlspecialchars($s['comments'] ?? '-')) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- General Observations -->
    <h3 class="section-title">3. General Observations</h3>
    <div class="mb-5 p-4 border rounded bg-light">
        <ul class="checklist text-sm">
            <li class="checked">Trainer Professional Documents are available and approved.</li>
            <li class="checked">Assessment Tools align with the Unit of Competency.</li>
            <li class="<?= $stats['percentage'] >= 80 ? 'checked' : 'unchecked' ?>">
                Student Evidence meets the required standard (Sample Compliance > 80%).
            </li>
        </ul>
    </div>

    <!-- Footer / Signatures -->
    <div class="report-footer mt-5 pt-5">
        <div class="grid-2 gap-5">
            <div class="signature-box">
                <div class="signature-line"></div>
                <strong class="d-block mb-1">Internal Verifier Signature</strong>
                <span class="text-xs text-gray">Digitally Verified</span>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <strong class="d-block mb-1">Date</strong>
                <span class="text-xs text-gray"><?= date('d/m/Y') ?></span>
            </div>
        </div>
        <div class="text-center mt-5 text-xs text-gray-light uppercase">
            System Generated Report &bull; CBET POE System &bull; <?= date('Y-m-d H:i:s') ?>
        </div>
    </div>
</div>

<style>
    /* Report Container */
    .report-container {
        max-width: 850px;
        margin: 0 auto;
        padding: 40px;
        background: #fff;
        font-family: 'Inter', sans-serif;
    }

    .shadow-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .border-bottom-thick {
        border-bottom: 3px solid #008975;
    }

    /* Typography */
    .text-xl {
        font-size: 1.5rem;
    }

    .text-lg {
        font-size: 1.125rem;
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .text-xs {
        font-size: 0.75rem;
    }

    .uppercase {
        text-transform: uppercase;
    }

    .tracking-wide {
        letter-spacing: 0.05em;
    }

    .text-gray {
        color: #64748b;
    }

    .text-gray-light {
        color: #94a3b8;
    }

    .text-dark {
        color: #0f172a;
    }

    /* Meta Box */
    .meta-label {
        display: block;
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 2px;
    }

    .meta-value {
        color: #0f172a;
    }

    /* Stats */
    .stat-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 15px;
        background: #f8fafc;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
    }

    .text-success {
        color: #16a34a;
    }

    /* Section Headers */
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #008975;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 8px;
        margin-bottom: 20px;
    }

    /* Tables */
    .report-table th {
        background: #f1f5f9;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        color: #475569;
        padding: 12px;
    }

    .report-table td {
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
    }

    .report-table tr:last-child td {
        border-bottom: none;
    }

    /* Status Indicators */
    .status-indicator {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .status-success {
        background: #dcfce7;
        color: #166534;
    }

    .status-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-gray {
        background: #f1f5f9;
        color: #475569;
    }

    /* Checklist */
    .checklist {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .checklist li {
        padding-left: 25px;
        position: relative;
        margin-bottom: 8px;
        color: #334155;
    }

    .checklist li::before {
        content: '◻';
        position: absolute;
        left: 0;
        color: #cbd5e1;
        font-weight: bold;
    }

    .checklist li.checked::before {
        content: '✔';
        color: #008975;
    }

    .checklist li.unchecked::before {
        content: '✖';
        color: #ef4444;
    }

    /* Signature */
    .signature-box {
        text-align: center;
    }

    .signature-line {
        border-bottom: 1px solid #94a3b8;
        width: 80%;
        margin: 0 auto 10px;
    }

    /* Utilities */
    .text-right-md {
        text-align: right;
    }

    .bg-light {
        background-color: #f8fafc;
    }

    .d-block {
        display: block;
    }

    .gap-5 {
        gap: 2rem;
    }

    @media print {
        @page {
            size: A4;
            margin: 1.5cm;
        }

        .no-print,
        .sidebar,
        .top-bar,
        .sidebar-overlay,
        .nav-toggle,
        .btn {
            display: none !important;
        }

        /* Layout & Container Reset */
        body, html, .main-content, .container, .report-container {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
            box-shadow: none !important;
            border: none !important;
            overflow: visible !important;
        }

        .main-content {
            display: block !important;
        }

        /* Typography Scaling */
        body {
            font-size: 11px; /* Slightly smaller for print */
            color: #000;
        }

        h1 { font-size: 18px !important; }
        h2 { font-size: 16px !important; }
        h3 { font-size: 14px !important; margin-top: 15px !important; margin-bottom: 10px !important; }

        /* Grid System Adaptation */
        .grid-2, .grid-3 {
            display: grid !important;
            gap: 15px !important;
        }
        
        /* 2 Columns usually fit A4, 3 might be tight */
        .grid-3 {
            grid-template-columns: 1fr 1fr 1fr !important;
        }

        /* Table Constraints */
        table {
            width: 100% !important;
            table-layout: fixed; /* Prevents overflow */
            border-collapse: collapse;
        }

        th, td {
            word-wrap: break-word; /* Force wrap */
            padding: 6px !important;
            font-size: 10px !important;
        }

        /* Specific Overrides */
        .badge {
            border: 1px solid #000;
            color: #000 !important;
        }
        
        .bg-light {
            background-color: transparent !important;
            border: 1px solid #ddd;
        }
    }
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layout.php';
?>