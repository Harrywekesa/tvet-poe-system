<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?? 'Verification Certificate' ?>
    </title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .certificate-container {
            background: white;
            width: 100%;
            max-width: 800px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #008975;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            max-height: 80px;
            margin-bottom: 10px;
        }

        .inst-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .inst-sub {
            color: #666;
        }

        .content {
            margin-bottom: 30px;
        }

        .row {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }

        .value {
            flex: 1;
            color: #000;
        }

        .stamps {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .stamp-box {
            border: 3px double #008975;
            color: #008975;
            padding: 15px;
            width: 200px;
            text-align: center;
            border-radius: 4px;
            transform: rotate(-2deg);
        }

        .stamp-title {
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .stamp-detail {
            font-size: 0.9rem;
            margin: 3px 0;
        }

        .signature {
            margin-top: 15px;
            border-top: 1px solid #008975;
            font-size: 0.8rem;
            font-style: italic;
        }

        .actions {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 24px;
            background: #008975;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: background 0.2s;
        }

        .btn:hover {
            background: #006f5e;
        }

        .btn-secondary {
            background: #6c757d;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .certificate-container {
                box-shadow: none;
                border: none;
            }

            .actions {
                display: none;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="no-print" style="width: 100%; max-width: 800px; margin-bottom: 20px;">
        <a href="javascript:history.back()" style="color: #666; text-decoration: none;">&larr; Back to POE</a>
    </div>

    <div class="certificate-container">
        <!-- Header -->
        <div class="header">
            <?php if (!empty($inst['logo_path'])): ?>
                <img src="<?= APP_URL . htmlspecialchars($inst['logo_path']) ?>" alt="Logo" class="logo">
            <?php else: ?>
                <div style="font-size: 2rem; font-weight: bold; color: #ccc;">LOGO</div>
            <?php endif; ?>
            <div class="inst-name">
                <?= htmlspecialchars($inst['name'] ?? 'TVET INSTITUTE') ?>
            </div>
            <div class="inst-sub">Competence Based Education & Training (CBET)</div>
            <div style="font-size: 1.2rem; margin-top: 10px; font-weight: bold;">EVIDENCE VERIFICATION CERTIFICATE</div>
        </div>

        <!-- Details -->
        <div class="content">
            <div class="row">
                <div class="label">Candidate Name:</div>
                <div class="value">
                    <?= htmlspecialchars($submission['student_name']) ?>
                </div>
            </div>
            <div class="row">
                <div class="label">Unit of Competency:</div>
                <div class="value">
                    <?= htmlspecialchars($submission['unit_code'] . ' - ' . $submission['unit_title']) ?>
                </div>
            </div>
            <div class="row">
                <div class="label">Assessment Task:</div>
                <div class="value">
                    <?= htmlspecialchars($submission['slot_title']) ?>
                </div>
            </div>
            <div class="row">
                <div class="label">Submission Date:</div>
                <div class="value">
                    <?= $submission['submitted_at'] ?>
                </div>
            </div>
            <div class="row">
                <div class="label">Status:</div>
                <div class="value" style="font-weight: bold; color: green;">
                    <?= strtoupper($submission['status']) ?>
                </div>
            </div>
        </div>

        <!-- Stamps -->
        <div class="stamps">
            <!-- Find Approver -->
            <?php
            $approver = 'Unknown';
            $approveDate = '-';
            foreach ($reviews as $r) {
                if ($r['decision'] === 'Approved') {
                    $approver = $r['reviewer_name'];
                    $approveDate = isset($r['reviewed_at']) ? date('Y-m-d', strtotime($r['reviewed_at'])) : '-';
                }
            }
            ?>
            <div class="stamp-box">
                <div class="stamp-title">ASSESSOR APPROVED</div>
                <div class="stamp-detail">By:
                    <?= htmlspecialchars($approver) ?>
                </div>
                <div class="stamp-detail">Date:
                    <?= $approveDate ?>
                </div>
                <div class="signature">Electronically Signed</div>
            </div>

            <!-- IV Stamp only if Verified -->
            <?php
            $verifier = null;
            $verifyDate = '-';
            if ($submission['status'] === 'Verified') {
                foreach ($reviews as $r) {
                    if ($r['decision'] === 'Verified') {
                        $verifier = $r['reviewer_name'];
                        $verifyDate = isset($r['reviewed_at']) ? date('Y-m-d', strtotime($r['reviewed_at'])) : '-';
                    }
                }
            }
            ?>
            <?php if ($verifier): ?>
                <div class="stamp-box">
                    <div class="stamp-title">IV VERIFIED</div>
                    <div class="stamp-detail">By:
                        <?= htmlspecialchars($verifier) ?>
                    </div>
                    <div class="stamp-detail">Date:
                        <?= $verifyDate ?>
                    </div>
                    <div class="signature">Electronically Signed</div>
                </div>
            <?php endif; ?>
        </div>

        <div style="text-align: center; font-size: 0.8rem; color: #888; margin-top: 50px;">
            This document certifies that the attached evidence has been formally assessed and approved.<br>
            System Generated:
            <?= date('Y-m-d H:i:s') ?>
        </div>
    </div>

    <!-- Actions -->
    <div class="actions">
        <p style="margin-bottom: 15px; color: #555;">Review the certificate above. To access the original evidence file,
            click below.</p>
        <a href="<?= APP_URL ?>/uploads/<?= htmlspecialchars($submission['file_path']) ?>" download class="btn">
            📂 Download Original Evidence
        </a>
        <br><br>
        <button onclick="window.print()" class="btn btn-secondary">🖨️ Print Certificate</button>
    </div>

</body>

</html>