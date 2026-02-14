<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Transcript</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px; color: #333; max-width: 900px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .logo { max-height: 80px; margin-bottom: 10px; }
        .inst-name { font-size: 1.8rem; font-weight: bold; text-transform: uppercase; margin: 0; }
        .doc-title { font-size: 1.6rem; margin-top: 5px; font-weight: 600; color: #1e3a8a; text-transform: uppercase; }
        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .info-item { margin-bottom: 10px; }
        .label { font-weight: bold; color: #666; display: block; font-size: 0.9rem; }
        .value { font-size: 1.1rem; }

        .marks-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .marks-table th, .marks-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .marks-table th { background-color: #f8f9fa; font-weight: 600; border-bottom: 2px solid #ccc; }
        .marks-table tr:nth-child(even) { background-color: #f9fafb; }

        .footer { margin-top: 50px; display: flex; justify-content: space-between; gap: 20px; }
        .stamp-box { border: 2px solid #333; color: #333; padding: 10px; border-radius: 4px; display: inline-block; width: 45%; text-align: center; min-height: 100px; }
        .stamp-title { font-weight: bold; text-transform: uppercase; border-bottom: 1px solid #333; margin-bottom: 20px; padding-bottom: 5px; font-size: 0.8rem; }
        .signature-line { border-top: 1px solid #333; margin-top: 40px; width: 80%; margin-left: auto; margin-right: auto; font-size: 0.7rem; }
        
        .print-controls { margin-bottom: 20px; text-align: right; background: #f8f9fa; padding: 10px; border-bottom: 1px solid #ddd; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print print-controls">
        <span style="font-weight: bold; margin-right: 10px;">View Mode:</span>
        <a href="?type=raw" style="margin-right: 10px; text-decoration: underline; color: <?= $type == 'raw' ? 'black' : 'blue' ?>">Raw Marks</a>
        <a href="?type=weighted" style="margin-right: 20px; text-decoration: underline; color: <?= $type == 'weighted' ? 'black' : 'blue' ?>">Weighted Scores</a>
        <button onclick="window.print()" style="padding: 5px 15px; cursor: pointer;">🖨️ Print Transcript</button>
    </div>

    <div class="header">
        <?php if (!empty($inst['logo_path'])): ?>
            <img src="<?= APP_URL . $inst['logo_path'] ?>" alt="Logo" class="logo">
        <?php endif; ?>
        <div class="inst-name"><?= htmlspecialchars($inst['name'] ?? 'Training Institute') ?></div>
        <div class="doc-title">Statement of Results</div>
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
        </div>
        <div>
            <div class="info-item">
                <span class="label">Course</span>
                <span class="value"><?= htmlspecialchars($course['title'] ?? 'N/A') ?></span>
            </div>
            <div class="info-item">
                <span class="label">Date Issued</span>
                <span class="value"><?= date('d M Y') ?></span>
            </div>
        </div>
    </div>

    <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px;">Academic Performance</h3>
    <table class="marks-table">
        <thead>
            <tr>
                <th style="width: 15%;">Unit Code</th>
                <th>Unit Title</th>
                <th style="width: 15%; text-align: center;"><?= $type == 'weighted' ? 'Score' : 'Mark' ?></th>
                <th style="width: 15%; text-align: center;">Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($results)): ?>
                <tr><td colspan="4" style="text-align: center; padding: 20px;">No units found.</td></tr>
            <?php else: ?>
                <?php foreach ($results as $r): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($r['unit_code']) ?></strong></td>
                        <td><?= htmlspecialchars($r['unit_title']) ?></td>
                        <td style="text-align: center; font-weight: bold; font-size: 1.1rem;">
                            <?= $r['mark'] ?>
                        </td>
                        <td style="text-align: center;">
                            <?php 
                                // Simple Grading based on 50% pass
                                $val = floatval(str_replace('%', '', $r['mark']));
                                echo ($val >= 50) ? 'Competent' : 'NYC';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="stamp-box">
            <div class="stamp-title">Registrar</div>
            <div class="signature-line">Signature & Date</div>
        </div>
        <div class="stamp-box">
            <div class="stamp-title">Principal / Head of Institution</div>
            <div class="signature-line">Signature & Date</div>
        </div>
    </div>

    <div style="margin-top: 50px; text-align: center; font-size: 0.8rem; color: #888;">
        This document is electronically generated by the <?= htmlspecialchars($inst['system_name'] ?? 'CBET System') ?>. 
        It is not valid without the official institution stamp.
    </div>

</body>
</html>
