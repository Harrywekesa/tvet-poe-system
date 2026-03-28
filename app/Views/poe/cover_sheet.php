<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Verification Certificate') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #008975;
            --brand-dark: #006f5e;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --bg: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .certificate-container {
            background: white;
            width: 100%;
            max-width: 850px;
            padding: 50px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        /* Decorative Header Line */
        .certificate-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--brand);
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #cbd5e1;
            padding-bottom: 30px;
            margin-bottom: 40px;
        }

        .logo {
            max-height: 90px;
            margin-bottom: 15px;
        }

        .inst-name {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.5px;
            margin-bottom: 5px;
        }

        .inst-sub {
            color: var(--text-secondary);
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .cert-title {
            font-size: 1.4rem;
            margin-top: 15px;
            font-weight: 800;
            color: var(--brand);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .content {
            margin-bottom: 40px;
            background: #f8fafc;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .row {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
        }
        
        .row:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .label {
            font-weight: 600;
            width: 200px;
            color: var(--text-secondary);
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .value {
            flex: 1;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 1.05rem;
        }

        .stamps {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
            margin-bottom: 40px;
        }

        .stamp-box {
            border: 4px double var(--brand);
            color: var(--brand);
            padding: 20px 15px;
            width: 220px;
            text-align: center;
            border-radius: 8px;
            transform: rotate(-2deg);
            background: rgba(255,255,255,0.9);
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            position: relative;
        }

        .stamp-title {
            font-weight: 800;
            font-size: 1.2rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stamp-detail {
            font-size: 0.9rem;
            margin: 5px 0;
            font-weight: 500;
        }

        .signature {
            margin-top: 25px;
            border-top: 2px dashed var(--brand);
            font-size: 0.8rem;
            font-style: italic;
            padding-top: 10px;
            opacity: 0.8;
        }

        .footer-note {
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-top: 50px;
            line-height: 1.5;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }

        .actions {
            text-align: center;
            margin-top: 40px;
            width: 100%;
            max-width: 850px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .btn {
            padding: 12px 24px;
            background: var(--brand);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 137, 117, 0.2);
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: var(--brand-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid #cbd5e1;
            box-shadow: none;
        }

        .btn-outline:hover {
            background: #f1f5f9;
            color: var(--text-primary);
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            .certificate-container {
                box-shadow: none;
                border: none;
                padding: 20px;
            }
            .content {
                border: 1px solid #000;
            }
            .actions, .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="no-print" style="width: 100%; max-width: 850px; margin-bottom: 20px;">
        <a href="javascript:history.back()" style="color: var(--text-secondary); text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 5px;">
            &larr; Go Back
        </a>
    </div>

    <div class="certificate-container">
        <!-- Header -->
        <div class="header">
            <?php if (!empty($inst['logo_path'])): ?>
                <img src="<?= APP_URL . htmlspecialchars($inst['logo_path']) ?>" alt="Logo" class="logo">
            <?php else: ?>
                <div style="width: 80px; height: 80px; margin: 0 auto 15px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold;">LOGO</div>
            <?php endif; ?>
            
            <div class="inst-name">
                <?= htmlspecialchars($inst['name'] ?? 'TVET INSTITUTE') ?>
            </div>
            <div class="inst-sub">Competence Based Education & Training (CBET)</div>
            <div class="cert-title">Evidence Verification Certificate</div>
        </div>

        <!-- Details -->
        <div class="content">
            <div class="row">
                <div class="label">Candidate Name</div>
                <div class="value"><?= htmlspecialchars($submission['student_name']) ?></div>
            </div>
            <div class="row">
                <div class="label">Unit of Competency</div>
                <div class="value" style="font-family: monospace; font-size: 1rem;">
                    <?= htmlspecialchars($submission['unit_code']) ?><br>
                    <span style="font-family: 'Inter', sans-serif; color: var(--text-secondary); font-size: 0.9rem;"><?= htmlspecialchars($submission['unit_title']) ?></span>
                </div>
            </div>
            <div class="row">
                <div class="label">Assessment Task</div>
                <div class="value"><?= htmlspecialchars($submission['slot_title']) ?></div>
            </div>
            <div class="row">
                <div class="label">Submission Date</div>
                <div class="value"><?= date('F j, Y, g:i a', strtotime($submission['submitted_at'])) ?></div>
            </div>
            <div class="row">
                <div class="label">Verification Status</div>
                <div class="value">
                    <span style="display: inline-block; padding: 4px 10px; background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; border-radius: 4px; font-weight: 600; font-size: 0.85rem;">
                        <?= strtoupper($submission['status']) ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Stamps -->
        <div class="stamps">
            <?php
            $approver = 'Unknown';
            $approveDate = '-';
            foreach ($reviews as $r) {
                if ($r['decision'] === 'Approved') {
                    $approver = $r['reviewer_name'];
                    $approveDate = isset($r['reviewed_at']) ? date('d M Y', strtotime($r['reviewed_at'])) : '-';
                }
            }
            ?>
            <div class="stamp-box">
                <div class="stamp-title">ASSESSOR APPROVED</div>
                <div class="stamp-detail">By: <?= htmlspecialchars($approver) ?></div>
                <div class="stamp-detail">Date: <?= $approveDate ?></div>
                <div class="signature">Electronically Signed</div>
            </div>

            <?php
            $verifier = null;
            $verifyDate = '-';
            if ($submission['status'] === 'Verified') {
                foreach ($reviews as $r) {
                    if ($r['decision'] === 'Verified') {
                        $verifier = $r['reviewer_name'];
                        $verifyDate = isset($r['reviewed_at']) ? date('d M Y', strtotime($r['reviewed_at'])) : '-';
                    }
                }
            }
            ?>
            <?php if ($verifier): ?>
                <div class="stamp-box" style="transform: rotate(2deg);">
                    <div class="stamp-title">IV VERIFIED</div>
                    <div class="stamp-detail">By: <?= htmlspecialchars($verifier) ?></div>
                    <div class="stamp-detail">Date: <?= $verifyDate ?></div>
                    <div class="signature">Electronically Signed</div>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer-note">
            This document certifies that the attached evidence has been formally assessed and approved according to the CBET internal verification standards. Valid only when accompanied by the original digital submission.<br>
            <strong>System Generated: <?= date('Y-m-d H:i:s') ?></strong>
        </div>
    </div>

    <!-- Actions Box -->
    <div class="actions no-print">
        <p style="margin: 0 0 20px 0; color: var(--text-secondary); font-size: 0.95rem;">Review the certificate above. Use the options below to download or print.</p>
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="<?= APP_URL ?>/uploads/<?= htmlspecialchars($submission['file_path']) ?>" download class="btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download Original Evidence
            </a>
            <button onclick="window.print()" class="btn btn-outline">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                Print Certificate
            </button>
        </div>
    </div>

</body>
</html>