<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unit Marksheet</title>
    <!-- We inject some of the main CSS system to modernize the wrapper while keeping the print fidelity -->
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css?v=<?= time() ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-app);
            color: var(--text-primary);
            margin: 0;
            padding: 20px;
        }

        .sheet-container {
            max-width: 1100px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            border-radius: var(--radius-lg);
            padding: 40px;
            position: relative;
        }

        /* Header Layout */
        .sheet-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid var(--primary);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo-box {
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .institute-details {
            text-align: right;
        }

        .institute-name {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .institute-sub {
            font-size: 1rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Unit Info Box */
        .unit-info {
            background: #f8fafc;
            border: 1px dashed var(--border-color);
            padding: 20px;
            border-radius: var(--radius-md);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }

        .unit-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 5px;
        }

        /* Table Styling */
        .print-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            margin-bottom: 30px;
        }

        .print-table th,
        .print-table td {
            border: 1px solid var(--border-color);
            padding: 10px;
            text-align: center;
        }

        .print-table thead tr:first-child th {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .print-table thead tr:nth-child(2) th {
            background-color: #f1f5f9;
            color: var(--text-primary);
            font-weight: 600;
        }

        .print-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Section Specific Colors */
        .section-practical { background-color: #e0f2fe; color: #0369a1; }
        .section-written { background-color: #fef3c7; color: #92400e; }

        /* Signature Section */
        .stamp-box {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 15px;
            width: 30%;
            min-height: 120px;
            position: relative;
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .stamp-box.approved {
            border-color: var(--success);
            background: #f0fdf4;
            color: #166534;
        }

        .stamp-text {
            font-weight: 800;
            color: var(--border-color);
            text-transform: uppercase;
            font-size: 0.85rem;
            margin-bottom: 20px;
            text-align: center;
            letter-spacing: 1px;
        }

        .approved .stamp-text {
            color: var(--success);
            border: 2px solid var(--success);
            display: inline-block;
            padding: 4px 10px;
            transform: rotate(-5deg);
            background: rgba(255,255,255,0.8);
        }

        .signature-line {
            border-top: 1px solid var(--text-muted);
            margin-top: 30px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            font-size: 0.75rem;
            padding-top: 4px;
        }

        /* Print Media Overrides */
        @media print {
            .no-print { display: none !important; }
            body { 
                margin: 0; 
                padding: 0; 
                background: white; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
            }
            .sheet-container {
                border: none;
                box-shadow: none;
                width: 100%;
                max-width: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Audit Debug (Temporary) -->
    <div class="no-print text-center text-muted" style="font-size: 11px; margin-bottom: 10px;">
        System Debug: Role=[<?= htmlspecialchars($_SESSION['role'] ?? 'Null') ?>], Current Status=[<?= htmlspecialchars($status) ?>]
    </div>

    <div class="sheet-container">
        
        <!-- Actions Bar (No Print) -->
        <div class="no-print" style="background: var(--bg-app); padding: 15px 20px; border-radius: var(--radius-md); border: 1px solid var(--border-color); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; gap: 10px; align-items: center;">
                <button onclick="window.print()" class="btn btn-outline" style="border-color: var(--primary); color: var(--primary); font-weight: 600;">
                    🖨️ Print / Save PDF
                </button>
                
                <?php if (($_SESSION['role'] ?? '') === 'Trainer'): ?>
                    <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">Back to Dashboard</a>
                <?php else: ?>
                    <a href="javascript:history.back()" class="btn btn-outline">Go Back</a>
                <?php endif; ?>

                <!-- Submit Form for Trainers/Admins -->
                <?php
                $role = $_SESSION['role'] ?? '';
                $canSubmit = (
                    (strcasecmp($role, 'Trainer') === 0 || strcasecmp($role, 'Admin') === 0)
                    &&
                    ($status == 'Draft' || $status == 'HOD_Rejected' || $status == 'IQS_Rejected')
                );
                ?>
                <?php if ($canSubmit): ?>
                    <form action="<?= APP_URL ?>/marks/submit" method="POST" style="margin: 0;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="unit_id" value="<?= htmlspecialchars($unit['id']) ?>">
                        <input type="hidden" name="class_id" value="<?= htmlspecialchars($class['id']) ?>">
                        <button type="submit" class="btn btn-primary" style="background: var(--danger); border-color: var(--danger);" onclick="return confirm('Submit to HOD? You cannot edit marks after this.')">
                            Submit Marks to HOD
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- View Toggle -->
            <div style="display: flex; gap: 5px; background: #fff; padding: 4px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
                <a href="?type=raw" class="btn <?= $type == 'raw' ? 'btn-primary' : 'btn-outline' ?>" style="<?= $type == 'raw' ? '' : 'border:none;' ?> padding: 6px 15px;">Raw Data</a>
                <a href="?type=weighted" class="btn <?= $type == 'weighted' ? 'btn-primary' : 'btn-outline' ?>" style="<?= $type == 'weighted' ? '' : 'border:none;' ?> padding: 6px 15px;">Weighted Scores</a>
            </div>
        </div>

        <!-- Approval Action Panels (No Print) -->
        <?php if (!empty($_SESSION['user_id']) && ($status == 'Submitted_to_HOD' || $status == 'HOD_Approved')): ?>
            <div class="no-print" style="margin-bottom: 30px; padding: 20px; background: #fffbeb; border: 1px solid #fcd34d; border-radius: var(--radius-md);">
                <?php if ($status == 'Submitted_to_HOD'): ?>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <strong style="color: #92400e; font-size: 1.1rem;">HOD Verification Required</strong>
                        <?php if (($_SESSION['role'] ?? '') === 'HOD' || ($_SESSION['role'] ?? '') === 'Admin'): ?>
                            <form action="<?= APP_URL ?>/marks/status" method="POST" style="display: flex; gap: 10px; align-items: center; margin: 0;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= htmlspecialchars($statusRecord['id']) ?>">
                                <input type="hidden" name="role" value="HOD">
                                <input type="text" name="comments" class="form-control" placeholder="Optional comments..." style="width: 250px;">
                                <button type="submit" name="action" value="approve" class="btn btn-primary" style="background: var(--success); border-color: var(--success);">Approve</button>
                                <button type="submit" name="action" value="reject" class="btn btn-primary" style="background: var(--danger); border-color: var(--danger);">Reject</button>
                            </form>
                        <?php else: ?>
                            <span style="color: var(--warning); font-weight: 600; background: #fff; padding: 6px 12px; border-radius: 4px;">Pending HOD Review</span>
                        <?php endif; ?>
                    </div>

                <?php elseif ($status == 'HOD_Approved'): ?>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <strong style="color: #92400e; font-size: 1.1rem;">IQS Verification Required</strong>
                        <?php if (($_SESSION['role'] ?? '') === 'InternalVerifier' || ($_SESSION['role'] ?? '') === 'Admin'): ?>
                            <form action="<?= APP_URL ?>/marks/status" method="POST" style="display: flex; gap: 10px; align-items: center; margin: 0;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= htmlspecialchars($statusRecord['id']) ?>">
                                <input type="hidden" name="role" value="IQS">
                                <input type="text" name="comments" class="form-control" placeholder="Notes for Trainer..." style="width: 250px;">
                                <button type="submit" name="action" value="approve" class="btn btn-primary" style="background: var(--success); border-color: var(--success);">Final Approve</button>
                                <button type="submit" name="action" value="reject" class="btn btn-primary" style="background: var(--danger); border-color: var(--danger);">Reject Back</button>
                            </form>
                        <?php else: ?>
                            <span style="color: var(--warning); font-weight: 600; background: #fff; padding: 6px 12px; border-radius: 4px;">Pending IQS Verification</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Marksheet Header -->
        <div class="sheet-header">
            <div class="logo-box">
                <?php if (!empty($inst['logo_path'])): ?>
                    <img src="<?= APP_URL . htmlspecialchars($inst['logo_path']) ?>" alt="Logo" style="max-width:100%; max-height:100px; object-fit:contain;">
                <?php else: ?>
                    <div style="width:100px; height:100px; border:2px dashed #cbd5e1; border-radius: 50%; display:flex; align-items:center; justify-content:center; color: #cbd5e1; font-weight: 600; font-size: 0.8rem;">
                        NO LOGO
                    </div>
                <?php endif; ?>
            </div>
            <div class="institute-details">
                <div class="institute-name"><?= htmlspecialchars($inst['name'] ?? 'TVET INSTITUTE') ?></div>
                <div class="institute-sub"><?= htmlspecialchars($inst['system_name'] ?? 'Competency Based Education & Training') ?></div>
                <div class="institute-sub" style="margin-top: 10px; font-weight: 700; color: var(--text-primary);">OFFICIAL CONSOLIDATED MARKSHEET</div>
            </div>
        </div>

        <!-- Unit Details -->
        <div class="unit-info">
            <div>
                <div class="unit-title"><?= htmlspecialchars($unit['unit_title']) ?></div>
                <div style="font-size: 1.05rem; color: var(--text-muted); font-family: monospace;"><?= htmlspecialchars($unit['unit_code']) ?></div>
            </div>
            <div style="text-align: right; font-size: 0.95rem;">
                <div style="margin-bottom: 5px;"><strong>Class Code:</strong> <?= htmlspecialchars($class['class_name'] ?? $class['class_code']) ?></div>
                <div style="margin-bottom: 5px;"><strong>Assessment Level:</strong> <?= htmlspecialchars($unit['assessment_level']) ?></div>
                <div style="margin-top: 8px;">
                    <span style="background: #e2e8f0; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; color: var(--text-primary); border: 1px solid #cbd5e1;">
                        RCRD_STATUS: <?= str_replace('_', ' ', $status) ?>
                    </span>
                </div>
            </div>
        </div>

        <table class="print-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 40px;">S/N</th>
                    <th rowspan="2" style="width: 100px;">Identifier</th>
                    <th rowspan="2" style="text-align: left;">Candidate Name</th>

                    <!-- Practical Header -->
                    <th colspan="<?= count($practicalSlots) ?>" class="section-practical">PRACTICAL ASSESSMENTS</th>

                    <!-- Written Header -->
                    <th colspan="<?= count($writtenSlots) ?>" class="section-written">WRITTEN (THEORY) ASSESSMENTS</th>

                    <?php if ($type !== 'raw'): ?>
                        <th rowspan="2" style="width: 80px;">FINAL %</th>
                        <th rowspan="2" style="width: 100px;">GRADE</th>
                    <?php endif; ?>
                </tr>
                <tr>
                    <?php $p = 1; foreach ($practicalSlots as $slot): ?>
                        <th style="font-size: 0.75rem;">PRAC <?= $p++ ?></th>
                    <?php endforeach; ?>
                    
                    <?php $w = 1; foreach ($writtenSlots as $slot): ?>
                        <th style="font-size: 0.75rem;">WASSM <?= $w++ ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($students as $s): ?>
                    <?php
                    $res = $results[$s['id']];
                    $slotMap = [];
                    foreach ($res['topics'] as $t) {
                        foreach ($t['slots'] as $slotRes) {
                            $slotMap[$slotRes['id']] = $slotRes;
                        }
                    }
                    ?>
                    <tr>
                        <td style="color: var(--text-muted);"><?= $i++ ?></td>
                        <td style="font-family: monospace; font-size: 0.9rem;"><?= htmlspecialchars($s['identifier']) ?></td>
                        <td style="text-align: left; font-weight: 500; font-size: 0.95rem;"><?= htmlspecialchars($s['full_name']) ?></td>

                        <!-- Practical Data -->
                        <?php foreach ($practicalSlots as $slot): ?>
                            <?php
                            $data = $slotMap[$slot['id']] ?? null;
                            $val = '-';
                            if ($data && $data['mark'] !== '-') {
                                if ($type == 'raw') {
                                    $val = number_format($data['mark'], 0);
                                } else {
                                    $topic = null;
                                    foreach ($res['topics'] as $t) {
                                        if ($t['id'] == $slot['topic_id']) { $topic = $t; break; }
                                    }
                                    if ($topic) {
                                        $ratio = $res['ratios']['p'];
                                        $count = $topic['p_count'] ?? 1; if ($count == 0) $count = 1;
                                        $weightedVal = ($data['mark'] / 100) * (1 / $count) * $ratio * $topic['weight'];
                                        $val = number_format($weightedVal, 2);
                                    }
                                }
                            }
                            ?>
                            <td <?= $val == '-' ? 'style="color: #ccc;"' : '' ?>><?= $val ?></td>
                        <?php endforeach; ?>

                        <!-- Written Data -->
                        <?php foreach ($writtenSlots as $slot): ?>
                            <?php
                            $data = $slotMap[$slot['id']] ?? null;
                            $val = '-';
                            if ($data && $data['mark'] !== '-') {
                                if ($type == 'raw') {
                                    $val = number_format($data['mark'], 0);
                                } else {
                                    $topic = null;
                                    foreach ($res['topics'] as $t) {
                                        if ($t['id'] == $slot['topic_id']) { $topic = $t; break; }
                                    }
                                    if ($topic) {
                                        $ratio = $res['ratios']['w'];
                                        $count = $topic['w_count'] ?? 1; if ($count == 0) $count = 1;
                                        $weightedVal = ($data['mark'] / 100) * (1 / $count) * $ratio * $topic['weight'];
                                        $val = number_format($weightedVal, 2);
                                    }
                                }
                            }
                            ?>
                            <td <?= $val == '-' ? 'style="color: #ccc;"' : '' ?>><?= $val ?></td>
                        <?php endforeach; ?>

                        <!-- Final Output -->
                        <?php if ($type !== 'raw'): ?>
                            <td style="font-weight: 700; font-size: 1.05rem; background: #f8fafc;"><?= number_format($res['final_mark'], 0) ?></td>
                            <td style="font-weight: 700; font-size: 0.95rem; color: <?= ($res['final_mark'] >= 50) ? '#166534' : '#991b1b' ?>; background: <?= ($res['final_mark'] >= 50) ? '#f0fdf4' : '#fef2f2' ?>;">
                                <?= ($res['final_mark'] >= 50) ? 'Competent' : 'NYC' ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                
                <?php if (empty($students)): ?>
                    <tr>
                        <td colspan="<?= 3 + count($practicalSlots) + count($writtenSlots) + ($type !== 'raw' ? 2 : 0) ?>" style="padding: 40px; color: var(--text-muted);">
                            No students enrolled in this class.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Signature Boxes -->
        <div style="margin-top: 60px; display: flex; justify-content: space-between; gap: 20px;">
            <!-- Trainer -->
            <div class="stamp-box <?= ($status != 'Draft' && $status != 'HOD_Rejected' && $status != 'IQS_Rejected') ? 'approved' : '' ?>">
                <div class="stamp-text">Trainer Submitted</div>
                <div style="margin-bottom: 5px;"><strong>By:</strong> <?= htmlspecialchars($statusRecord['submitted_by_name'] ?? ($statusRecord['submitted_by'] ?? 'Pending')) ?></div>
                <div style="margin-bottom: 5px;"><strong>Dept:</strong> <?= htmlspecialchars($statusRecord['submitted_dept'] ?? '-') ?></div>
                <div style="margin-bottom: 5px;"><strong>Date:</strong> <?= $statusRecord['submitted_at'] ? date('d M Y, H:i', strtotime($statusRecord['submitted_at'])) : '-' ?></div>
                <div class="signature-line">Official Signature (Trainer)</div>
            </div>

            <!-- HOD -->
            <div class="stamp-box <?= ($status == 'HOD_Approved' || $status == 'IQS_Approved' || $status == 'IQS_Rejected') ? 'approved' : '' ?>">
                <?php if ($status == 'HOD_Approved' || $status == 'IQS_Approved' || $status == 'IQS_Rejected'): ?>
                    <div class="stamp-text">HOD APPROVED</div>
                    <div style="margin-bottom: 5px;"><strong>By:</strong> <?= htmlspecialchars($statusRecord['hod_name'] ?? 'HOD') ?></div>
                    <div style="margin-bottom: 5px;"><strong>Dept:</strong> <?= htmlspecialchars($statusRecord['hod_dept'] ?? '-') ?></div>
                    <div style="margin-bottom: 5px;"><strong>Date:</strong> <?= date('d M Y, H:i', strtotime($statusRecord['hod_action_at'])) ?></div>
                <?php elseif ($status == 'HOD_Rejected'): ?>
                    <div class="stamp-text" style="color: var(--danger); border-color: var(--danger);">HOD REJECTED</div>
                    <div style="font-size: 0.8rem;">Reason: <?= htmlspecialchars($statusRecord['hod_comments']) ?></div>
                <?php else: ?>
                    <div class="stamp-text" style="color:#cbd5e1; border-color:#f1f5f9;">HOD PENDING</div>
                <?php endif; ?>
                <div class="signature-line">Official Signature (HOD)</div>
            </div>

            <!-- IQS -->
            <div class="stamp-box <?= ($status == 'IQS_Approved') ? 'approved' : '' ?>">
                <?php if ($status == 'IQS_Approved'): ?>
                    <div class="stamp-text">IQS APPROVED</div>
                    <div style="margin-bottom: 5px;"><strong>By:</strong> <?= htmlspecialchars($statusRecord['iqs_name'] ?? 'IQS') ?></div>
                    <div style="margin-bottom: 5px;"><strong>Date:</strong> <?= date('d M Y, H:i', strtotime($statusRecord['iqs_action_at'])) ?></div>
                <?php elseif ($status == 'IQS_Rejected'): ?>
                    <div class="stamp-text" style="color: var(--danger); border-color: var(--danger);">IQS REJECTED</div>
                    <div style="font-size: 0.8rem;">Reason: <?= htmlspecialchars($statusRecord['iqs_comments']) ?></div>
                <?php else: ?>
                    <div class="stamp-text" style="color:#cbd5e1; border-color:#f1f5f9;">IQS PENDING</div>
                <?php endif; ?>
                <div class="signature-line">Official Signature (IQS/Verifier)</div>
            </div>
        </div>

    </div>
</body>
</html>