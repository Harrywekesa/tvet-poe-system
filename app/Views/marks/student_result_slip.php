<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Slip - <?= htmlspecialchars($unit['unit_code']) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px;
            color: #333;
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .logo {
            max-height: 80px;
            margin-bottom: 10px;
        }

        .inst-name {
            font-size: 1.8rem;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .doc-title {
            font-size: 1.4rem;
            margin-top: 5px;
            font-weight: 600;
            color: #555;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
            color: #666;
            display: block;
            font-size: 0.9rem;
        }

        .value {
            font-size: 1.1rem;
        }

        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .marks-table th,
        .marks-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .marks-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .marks-table .total-row {
            font-weight: bold;
            background-color: #f0fdf4;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .stamp-box {
            border: 2px solid #166534;
            color: #166534;
            padding: 10px;
            border-radius: 4px;
            display: inline-block;
            transform: rotate(-2deg);
            width: 30%;
            text-align: center;
        }

        .stamp-title {
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #166534;
            margin-bottom: 5px;
            padding-bottom: 2px;
            font-size: 0.8rem;
        }

        .signature-line {
            border-top: 1px solid #166534;
            margin-top: 25px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            font-size: 0.7rem;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-left: 5px;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid #ccc;
            background: #fff;
            color: #333;
            font-size: 0.9rem;
            font-family: inherit;
            cursor: pointer;
        }

        .btn:hover {
            background: #f0f0f0;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="no-print"
        style="margin-bottom: 20px; text-align: right; background: #f8f9fa; padding: 10px; border-bottom: 1px solid #ddd;">
        <span style="font-weight: bold; margin-right: 10px;">View Mode:</span>
        <a href="?type=raw" class="btn" style="background: <?= $type == 'raw' ? '#e2e8f0' : '#fff' ?>">Raw Marks</a>
        <a href="?type=weighted" class="btn"
            style="background: <?= $type == 'weighted' ? '#e2e8f0' : '#fff' ?>">Weighted Scores</a>
        <button onclick="window.print()" class="btn" style="margin-left: 20px;">🖨️ Print Result</button>
    </div>

    <div class="header">
        <?php if (!empty($inst['logo_path'])): ?>
            <img src="<?= APP_URL . $inst['logo_path'] ?>" alt="Logo" class="logo">
        <?php endif; ?>
        <div class="inst-name"><?= htmlspecialchars($inst['name'] ?? 'Training Institute') ?></div>
        <div class="doc-title">Official Student Result Slip</div>
        <div style="font-size: 0.9rem; color: #666; font-weight: bold; margin-top: 5px; text-transform: uppercase;">
            <?= $type == 'weighted' ? '(Weighted Scores)' : '(Raw Marks)' ?>
        </div>
    </div>

    <div class="info-grid">
        <div>
            <div class="info-item">
                <span class="label">Student Name</span>
                <span class="value"><?= htmlspecialchars($student['full_name']) ?></span>
            </div>
            <div class="info-item">
                <span class="label">Student ID / Reg No</span>
                <span class="value"><?= htmlspecialchars($student['identifier']) ?></span>
            </div>
            <div class="info-item">
                <span class="label">Class</span>
                <span class="value"><?= htmlspecialchars($class['class_code']) ?></span>
            </div>
        </div>
        <div>
            <div class="info-item">
                <span class="label">Unit Code</span>
                <span class="value"><?= htmlspecialchars($unit['unit_code']) ?></span>
            </div>
            <div class="info-item">
                <span class="label">Unit Title</span>
                <span class="value"><?= htmlspecialchars($unit['unit_title']) ?></span>
            </div>
            <div class="info-item">
                <span class="label">Date Issued</span>
                <span class="value"><?= date('d M Y') ?></span>
            </div>
        </div>
    </div>

    <h3>Performance Breakdown</h3>
    <table class="marks-table">
        <thead>
            <tr>
                <th>Assessment</th>
                <th>Type</th>
                <th><?= $type == 'weighted' ? 'Score' : 'Mark' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($unit['assessments'] as $slot): ?>
                <?php
                $displayVal = '-';
                if ($slot['mark'] !== '-') {
                    if ($type == 'raw') {
                        $displayVal = number_format($slot['mark'], 1) . '%';
                    } else {
                        // Weighted Calculation
                        // Formula: (Mark/100) * (1/Count) * TypeRatio * TopicWeight
            
                        // Find Topic
                        $startTopic = null;
                        foreach ($totals['topics'] as $t) {
                            if ($t['id'] == ($slot['topic_id'] ?? 0)) {
                                $startTopic = $t;
                                break;
                            }
                        }

                        // Fallback to General if not found (or id 0)
                        if (!$startTopic && isset($totals['topics'][0])) {
                            $startTopic = $totals['topics'][0];
                        }

                        if ($startTopic) {
                            $isWritten = ($slot['type'] === 'Written');
                            $ratio = $isWritten ? $totals['ratios']['w'] : $totals['ratios']['p'];
                            $count = $isWritten ? ($startTopic['w_count'] ?? 1) : ($startTopic['p_count'] ?? 1);
                            if ($count == 0)
                                $count = 1;

                            $weight = $startTopic['weight'] ?? 0;

                            $weightedVal = ($slot['mark'] / 100) * (1 / $count) * $ratio * $weight;
                            $displayVal = number_format($weightedVal, 2);
                        }
                    }
                }
                ?>
                <tr>
                    <td><?= htmlspecialchars($slot['title']) ?></td>
                    <td><?= htmlspecialchars($slot['type']) ?></td>
                    <td><?= $displayVal ?></td>
                </tr>
            <?php endforeach; ?>

            <?php if ($type == 'weighted'): ?>
                <tr class="total-row">
                    <td colspan="2" style="text-align: right;">Final Grade (<?= $totals['level'] ?> Weighting)</td>
                    <td><?= number_format($totals['final_mark'], 0) ?>%</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">

        <!-- Trainer -->
        <div class="stamp-box">
            <div class="stamp-title">Trainer Submitted</div>
            <div style="font-size: 0.8rem; font-weight: bold;">
                <?= htmlspecialchars($statusRecord['submitted_by_name'] ?? 'Trainer') ?></div>
            <div style="font-size: 0.8rem;">Date: <?= date('d M Y', strtotime($statusRecord['submitted_at'])) ?></div>
            <div class="signature-line">Signature</div>
        </div>

        <!-- HOD -->
        <div class="stamp-box">
            <div class="stamp-title">HOD APPROVED</div>
            <div style="font-size: 0.8rem; font-weight: bold;">
                <?= htmlspecialchars($statusRecord['hod_name'] ?? 'HOD') ?></div>
            <div style="font-size: 0.8rem;">Date: <?= date('d M Y', strtotime($statusRecord['hod_action_at'])) ?></div>
            <div class="signature-line">Signature</div>
        </div>

        <!-- IQS -->
        <div class="stamp-box">
            <div class="stamp-title">IQS APPROVED</div>
            <div style="font-size: 0.8rem; font-weight: bold;">
                <?= htmlspecialchars($statusRecord['iqs_name'] ?? 'IQS') ?></div>
            <div style="font-size: 0.8rem;">Date: <?= date('d M Y', strtotime($statusRecord['iqs_action_at'])) ?></div>
            <div class="signature-line">Signature</div>
        </div>

    </div>

    <div style="margin-top: 50px; text-align: center; font-size: 0.8rem; color: #888;">
        This document is electronically generated and verified by the
        <?= htmlspecialchars($inst['system_name'] ?? 'CBET System') ?>.
    </div>

</body>

</html>