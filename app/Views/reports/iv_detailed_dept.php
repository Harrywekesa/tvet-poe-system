<?php require_once __DIR__ . '/../partials/header.php'; ?>
<style>
    @media print {

        header,
        nav,
        .btn,
        .no-print {
            display: none !important;
        }

        body {
            background: white;
            color: black;
        }

        .container {
            max-width: 100%;
            border: none;
            padding: 0;
        }

        .section-break {
            page-break-inside: avoid;
            margin-bottom: 20px;
        }
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        font-size: 0.9rem;
    }

    th {
        background: #f1f5f9;
        text-align: left;
    }
</style>

<div class="container" style="margin-top: 40px; background: white; padding: 40px; border: 1px solid #e2e8f0;">
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Print Report</button>
        <a href="<?= APP_URL ?>/reports/iv_analytics" class="btn btn-outline" style="margin-left: 10px;">Back</a>
    </div>

    <h1>Internal Verification Report</h1>
    <h3 class="text-secondary">Departmental Findings</h3>
    <p>Generated:
        <?= date('d M Y') ?>
    </p>

    <!-- Executive Summary -->
    <div style="margin-top: 30px; border: 2px solid #000; padding: 15px;">
        <h4>Executive Summary</h4>
        <p>
            <strong>Scope:</strong> Sampled
            <strong>
                <?= $summary['sampled_units'] ?> units
            </strong> out of
            <strong>
                <?= $summary['total_units'] ?> total units
            </strong> in the department.
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
        <div class="section-break" style="margin-top: 40px;">
            <h2 style="color: #1e3a8a; border-bottom: 2px solid #1e3a8a; padding-bottom: 5px;">
                <?= htmlspecialchars($courseTitle) ?>
            </h2>

            <?php foreach ($levels as $levelName => $units): ?>
                <div style="margin-top: 20px; margin-left: 20px;">
                    <h3 style="color: #475569;">
                        <?= htmlspecialchars($levelName) ?>
                    </h3>

                    <table>
                        <thead>
                            <tr>
                                <th style="width: 30%;">Unit</th>
                                <th style="width: 20%;">Trainer</th>
                                <th style="width: 10%;">Sampled</th>
                                <th style="width: 10%;">Accepted</th>
                                <th style="width: 10%;">Rejected</th>
                                <th>Reasons / Findings</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($units as $u): ?>
                                <tr>
                                    <td>
                                        <strong>
                                            <?= htmlspecialchars($u['unit_code']) ?>
                                        </strong><br>
                                        <?= htmlspecialchars($u['unit_title']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($u['trainer_name']) ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?= $u['verification_count'] ?>
                                    </td>
                                    <td style="text-align: center; color: green; font-weight: bold;">
                                        <?= $u['accepted_count'] ?>
                                    </td>
                                    <td style="text-align: center; color: red; font-weight: bold;">
                                        <?= $u['rejected_count'] ?>
                                    </td>
                                    <td style="font-style: italic; font-size: 0.85rem;">
                                        <?php if ($u['rejected_count'] > 0 && !empty($u['rejection_reasons'])): ?>
                                            ⚠
                                            <?= htmlspecialchars($u['rejection_reasons']) ?>
                                        <?php elseif ($u['accepted_count'] > 0): ?>
                                            <span style="color: green;">✔ Standards Met</span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

    <div style="margin-top: 60px; display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
        <div style="border-top: 1px solid #000; padding-top: 10px;">
            <strong>Internal Verifier Name & Signature</strong>
        </div>
        <div style="border-top: 1px solid #000; padding-top: 10px;">
            <strong>Date</strong>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>