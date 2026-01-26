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
            margin: 0;
            max-width: 100%;
            border: none;
        }

        .page-break {
            page-break-after: always;
        }
    }

    .watermark {
        position: fixed;
        top: 30%;
        left: 30%;
        opacity: 0.1;
        font-size: 5rem;
        transform: rotate(-45deg);
        pointer-events: none;
    }
</style>

<div class="container" style="margin-top: 40px; background: white; padding: 40px; border: 1px solid #e2e8f0;">
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Print / Save as PDF</button>
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline" style="margin-left: 10px;">Close</a>
    </div>

    <div class="watermark">OFFICIAL RECORD</div>

    <div style="margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 15px;">
        <h2 style="margin: 0;">Evaluation & Progress Report</h2>
        <h2 style="margin: 0;"><?= htmlspecialchars($studentName) ?></h2>
        <p class="text-secondary" style="margin: 5px 0 0 0;">
            Registration No: <strong><?= htmlspecialchars($report['student']['identifier'] ?? 'N/A') ?></strong> |
            Date: <?= date('d M Y') ?>
        </p>
    </div>

    <?php foreach ($report as $classData): ?>
        <div class="page-break">
            <h4>Course:
                <?= htmlspecialchars($classData['course_title']) ?> (
                <?= htmlspecialchars($classData['class_code']) ?>)
            </h4>

            <?php foreach ($classData['units'] as $unit): ?>
                <div style="margin-top: 30px; border: 1px solid #000; padding: 0;">
                    <div
                        style="background: #f1f5f9; padding: 10px; border-bottom: 1px solid #000; font-weight: bold; display: flex; justify-content: space-between;">
                        <span>
                            <?= htmlspecialchars($unit['unit_code']) ?>:
                            <?= htmlspecialchars($unit['unit_title']) ?>
                        </span>
                        <span>
                            <?= $unit['category'] ?>
                        </span>
                    </div>

                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid #000;">
                                <th style="text-align: left; padding: 8px; width: 30%; border-right: 1px solid #000;">Assessment
                                </th>
                                <th style="text-align: left; padding: 8px; width: 15%; border-right: 1px solid #000;">Status
                                </th>
                                <th style="text-align: left; padding: 8px; border-right: 1px solid #000;">Trainer Comments</th>
                                <th style="text-align: left; padding: 8px; width: 15%;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($unit['assessments'] as $ass): ?>
                                <tr style="border-bottom: 1px solid #ccc;">
                                    <td style="padding: 8px; border-right: 1px solid #000;">
                                        <?= htmlspecialchars($ass['title']) ?>
                                    </td>
                                    <td style="padding: 8px; border-right: 1px solid #000;">
                                        <?php if ($ass['status'] == 'Approved'): ?>
                                            <span style="color: green; font-weight: bold;">PASS</span>
                                        <?php elseif ($ass['status'] == 'Rejected'): ?>
                                            <span style="color: red; font-weight: bold;">NYC (Refer)</span>
                                        <?php else: ?>
                                            <?= $ass['status'] ?? 'Not Attempted' ?>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 8px; border-right: 1px solid #000; font-style: italic; font-size: 0.9rem;">
                                        <?= htmlspecialchars($ass['latest_comment'] ?? '-') ?>
                                    </td>
                                    <td style="padding: 8px;">
                                        <!-- Date placeholder or actual date if we fetched it -->
                                        ____/____/____
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>

            <div style="margin-top: 50px; display: flex; justify-content: space-between;">
                <div style="width: 45%; border-top: 1px solid #000; padding-top: 10px;">
                    <strong>Student Signature</strong><br>
                    I confirm that this is a true reflection of my progress.
                </div>
                <div style="width: 45%; border-top: 1px solid #000; padding-top: 10px;">
                    <strong>Trainer / HOD Signature</strong><br>
                    Verified Record.
                </div>
            </div>
        </div>
        <hr style="margin: 40px 0; border: none; border-top: 2px dashed #ccc;">
    <?php endforeach; ?>
</div>