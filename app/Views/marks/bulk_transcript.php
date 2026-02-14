<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bulk Class Transcript</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background: #f0f2f5;
        }

        .page-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .controls {
            max-width: 900px;
            margin: 0 auto 20px;
            text-align: right;
        }

        .btn {
            background: #1e3a8a;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
        }

        /* Transcript Styles (Copied from transcript.php) */
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo-box {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
            /* Placeholder for logo */
        }

        .inst-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
        }

        .inst-sub {
            color: #555;
            font-size: 0.9rem;
        }

        .student-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            background: #f8fafc;
            padding: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }

        .info-group div {
            margin-bottom: 5px;
        }

        .label {
            font-weight: 600;
            color: #64748b;
            width: 100px;
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f1f5f9;
            font-weight: 600;
        }

        td.center {
            text-align: center;
        }

        .footer-stamps {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .stamp-box {
            width: 30%;
            border-top: 1px solid #333;
            padding-top: 5px;
            text-align: center;
            font-size: 0.8rem;
        }

        .stamp-title {
            font-weight: bold;
            margin-bottom: 40px;
            /* Space for signature */
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .page-container {
                box-shadow: none;
                margin: 0;
                padding: 20px;
                /* Reduced padding for print */
                page-break-after: always;
                height: 100vh;
                /* Force height */
                box-sizing: border-box;
            }

            .controls {
                display: none;
            }

            /* Clean page break */
            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>

<body>

    <div class="controls">
        <button onclick="window.print()" class="btn">🖨️ Print All to PDF</button>
        <a href="<?= APP_URL ?>/marks/class_transcripts/<?= $class['id'] ?>" class="btn"
            style="background:#64748b;">Back to Class</a>
    </div>

    <?php foreach ($allData as $index => $data): ?>
        <div class="page-container">
            <!-- Header -->
            <div class="header">
                <div class="logo-box">
                    <?php if (!empty($inst['logo_path'])): ?>
                        <img src="<?= APP_URL . htmlspecialchars($inst['logo_path']) ?>" alt="Logo"
                            style="max-width:100%; max-height:100px;">
                    <?php else: ?>
                        <div
                            style="border:1px dashed #ccc; width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                            LOGO</div>
                    <?php endif; ?>
                </div>
                <div class="inst-name">
                    <?= htmlspecialchars($inst['name'] ?? 'TVET Institute') ?>
                </div>
                <div class="inst-sub">
                    <?= htmlspecialchars($inst['system_name'] ?? 'Competence Based Education & Training') ?>
                </div>
                <h3 style="margin-top:10px; border-top:1px solid #ccc; display:inline-block; padding-top:5px;">Term
                    Transcript</h3>
            </div>

            <!-- Student Info -->
            <div class="student-info">
                <div class="info-group">
                    <div><span class="label">Name:</span>
                        <?= htmlspecialchars($data['student']['full_name']) ?>
                    </div>
                    <div><span class="label">Reg No:</span>
                        <?= htmlspecialchars($data['student']['identifier']) ?>
                    </div>
                    <div><span class="label">Department:</span>
                        <?= htmlspecialchars($data['student']['department_name'] ?? 'N/A') ?>
                    </div>
                </div>
                <div class="info-group" style="text-align:Right;">
                    <div><span class="label">Course:</span>
                        <?= htmlspecialchars($data['course']['title'] ?? 'N/A') ?>
                    </div>
                    <div><span class="label">Class:</span>
                        <?= htmlspecialchars($class['class_code']) ?>
                    </div>
                    <div><span class="label">Date:</span>
                        <?= date('d M Y') ?>
                    </div>
                </div>
            </div>

            <!-- Marks Table -->
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">Unit Code</th>
                        <th>Unit Title</th>
                        <th style="width: 15%; text-align:center;">
                            <?= $type === 'raw' ? 'Result (Raw)' : 'Final Score (W)' ?>
                        </th>
                        <th style="width: 15%; text-align:center;">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['results'])): ?>
                        <tr>
                            <td colspan="4" class="center">No units found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data['results'] as $res): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($res['unit_code']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($res['unit_title']) ?>
                                </td>
                                <td class="center" style="font-weight:bold;">
                                    <?= $res['mark'] ?>
                                </td>
                                <td class="center">
                                    <?php
                                    $val = floatval($res['mark']);
                                    echo ($val >= 50) ? '<span style="color:green;">C</span>' : '<span style="color:red;">NYC</span>';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Footer Stamps -->
            <div class="footer-stamps">
                <div class="stamp-box">
                    <div class="stamp-title">Class Trainer</div>
                    (Signature & Date)
                </div>
                <div class="stamp-box">
                    <div class="stamp-title">Head of Department</div>
                    (Signature & Date)
                </div>
                <div class="stamp-box">
                    <div class="stamp-title">Registrar / Principal</div>
                    (Signature & Date)
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (empty($allData)): ?>
        <div class="page-container" style="text-align:center;">No students found in this class.</div>
    <?php endif; ?>

</body>

</html>