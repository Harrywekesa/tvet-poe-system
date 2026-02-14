<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Document Approval</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
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
            justify-content: center;
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
        }

        .btn:hover {
            background: #006f5e;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .certificate-container {
                box-shadow: none;
            }

            .actions,
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="width: 100%; max-width: 800px; margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/documents/review" style="color: #666; text-decoration: none;">&larr; Back to Review</a>
    </div>

    <div class="certificate-container">
        <div class="header">
            <?php if (!empty($inst['logo_path'])): ?>
                <img src="<?= APP_URL . htmlspecialchars($inst['logo_path']) ?>" alt="Logo" class="logo">
            <?php else: ?>
                <div style="font-size: 2rem; font-weight: bold; color: #ccc;">LOGO</div>
            <?php endif; ?>
            <div class="inst-name">
                <?= htmlspecialchars($inst['name'] ?? 'TVET INSTITUTE') ?>
            </div>
            <div class="inst-sub">Quality Assurance & Professional Documents</div>
            <div style="font-size: 1.2rem; margin-top: 10px; font-weight: bold;">DOCUMENT APPROVAL CERTIFICATE</div>
        </div>

        <div class="content">
            <div class="row">
                <div class="label">Trainer Name:</div>
                <div class="value">
                    <?= htmlspecialchars($doc['trainer_name']) ?>
                </div>
            </div>
            <div class="row">
                <div class="label">Document Type:</div>
                <div class="value">
                    <?= htmlspecialchars($doc['type']) ?>
                </div>
            </div>
            <div class="row">
                <div class="label">Unit / Class:</div>
                <div class="value">
                    <?= htmlspecialchars($doc['unit_code'] . ' (' . $doc['class_code'] . ')') ?>
                </div>
            </div>
            <div class="row">
                <div class="label">Unit Name:</div>
                <div class="value"><?= htmlspecialchars($doc['unit_title']) ?></div>
            </div>
            <div class="row">
                <div class="label">Submission Date:</div>
                <div class="value">
                    <?= $doc['created_at'] ?>
                </div>
            </div>
            <div class="row">
                <div class="label">Status:</div>
                <div class="value" style="font-weight: bold; color: green;">
                    <?= strtoupper($doc['status']) ?>
                </div>
            </div>
        </div>

        <div class="stamps">
            <div class="stamp-box">
                <div class="stamp-title">HOD APPROVED</div>
                <div class="stamp-detail">By:
                    <?= htmlspecialchars($doc['approver_name'] ?? 'HOD Authorized') ?>
                </div>
                <div class="stamp-detail">Date:
                    <?= isset($doc['updated_at']) && $doc['updated_at'] ? date('Y-m-d', strtotime($doc['updated_at'])) : date('Y-m-d') ?>
                </div>
                <div class="signature">Electronically Signed</div>
            </div>
        </div>

        <div style="text-align: center; font-size: 0.8rem; color: #888; margin-top: 50px;">
            This document certifies that the attached professional document has been formally reviewed and approved.<br>
            System Generated:
            <?= date('Y-m-d H:i:s') ?>
        </div>
    </div>

    <div class="actions">
        <p style="margin-bottom: 15px; color: #555;">Access the original file:</p>
        <a href="<?= APP_URL ?>/uploads/docs/<?= htmlspecialchars($doc['file_path']) ?>" download class="btn">📂
            Download Original Document</a>
        <br><br>
        <button onclick="window.print()" class="btn" style="background:#555;">🖨️ Print Certificate</button>
    </div>
</body>

</html>