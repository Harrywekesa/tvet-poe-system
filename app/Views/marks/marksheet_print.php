<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Unit Marksheet</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            color: #333;
        }

        .sheet-container {
            max-width: 1100px;
            margin: 0 auto;
            border: 2px solid #444;
            padding: 20px;
            position: relative;
        }

        /* Header Layout */
        .sheet-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo-box {
            width: 100px;
            height: 100px;
            border: 2px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-weight: bold;
            background: #f9f9f9;
        }

        .institute-details {
            text-align: right;
        }

        .institute-name {
            font-size: 1.8rem;
            font-weight: bold;
            color: #1e3a8a;
            /* Navy Blue */
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .institute-sub {
            font-size: 0.9rem;
            color: #555;
        }

        /* Unit Info Box */
        .unit-info {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .unit-info div {
            margin-bottom: 5px;
        }

        .unit-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #0c4a6e;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: center;
        }

        thead tr:first-child th {
            background-color: #1e3a8a;
            /* Header Dark Blue */
            color: white;
            border-color: #1e3a8a;
        }

        thead tr:nth-child(2) th {
            background-color: #f1f5f9;
            /* Sub-header light gray */
            color: #333;
            font-weight: 600;
        }

        /* Alternating Rows */
        tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Section Specific Colors */
        .section-practical {
            background-color: #e0f2fe;
            /* Light Blue */
            color: #0369a1;
        }

        .section-written {
            background-color: #fef3c7;
            /* Light Yellow */
            color: #92400e;
        }

        /* View Mode Buttons */
        .view-controls {
            margin-bottom: 15px;
            text-align: right;
        }

        .btn {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.85rem;
            margin-left: 5px;
            border: 1px solid #ccc;
            background: #fff;
            color: #333;
        }

        .btn.active {
            background-color: #1e3a8a;
            color: white;
            border-color: #1e3a8a;
        }

        /* Signature Section */
        .stamp-box {
            border: 1px solid #ccc;
            padding: 10px;
            width: 30%;
            min-height: 100px;
            position: relative;
            background: #fff;
        }

        .stamp-box.approved {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .stamp-text {
            font-weight: bold;
            color: #999;
            text-transform: uppercase;
            font-size: 0.8rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .approved .stamp-text {
            color: #15803d;
            border: 2px solid #15803d;
            display: inline-block;
            padding: 2px 8px;
            transform: rotate(-5deg);
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 30px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            font-size: 0.7rem;
            padding-top: 2px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
                -webkit-print-color-adjust: exact;
            }

            .sheet-container {
                border: none;
                width: 100%;
                max-width: none;
                padding: 0;
            }
        }
    </style>
</head>

<body>

<div class="sheet-container">

    <!-- Actions Bar (No Print) -->
    <div class="no-print view-controls" style="background: #f8f9fa; padding: 10px; border-bottom: 1px solid #ddd; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <button onclick="window.print()" class="btn">🖨️ Print / PDF</button>
            <?php if (($_SESSION['role'] ?? '') === 'Trainer'): ?>
                <a href="<?= APP_URL ?>/dashboard" class="btn">Back</a>
            <?php else: ?>
                <a href="javascript:history.back()" class="btn">Back</a>
            <?php endif; ?>
            
            <!-- Submit Form -->
            <?php if ($status == 'Draft' || $status == 'HOD_Rejected' || $status == 'IQS_Rejected'): ?>
                <form action="<?= APP_URL ?>/marks/submit" method="POST" style="display:inline; margin-left: 10px;">
                    <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">
                    <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
                    <button type="submit" class="btn" style="color: #c2410c;" onclick="return confirm('Submit to HOD? You cannot edit marks after this.')">Submit to HOD</button>
                </form>
            <?php endif; ?>
        </div>
        
        <!-- View Toggle -->
        <div>
            <span style="margin-right: 5px; font-weight: 600;">View:</span>
            <a href="?type=raw" class="btn <?= $type == 'raw' ? 'active' : '' ?>">Raw</a>
            <a href="?type=weighted" class="btn <?= $type == 'weighted' ? 'active' : '' ?>">Weighted</a>
        </div>
    </div>
    
    <!-- Approval Panels (No Print) -->
    <?php if (!empty($_SESSION['user_id']) && ($status == 'Submitted_to_HOD' || $status == 'HOD_Approved')): ?>
        <div class="no-print" style="margin-bottom: 20px; padding: 15px; background: #fffbeb; border: 1px solid #fcd34d; border-radius: 6px;">
            <?php if ($status == 'Submitted_to_HOD'): ?>
                <strong>HOD Action:</strong>
                <form action="<?= APP_URL ?>/marks/status" method="POST" style="display:inline; margin-left: 10px;">
                    <input type="hidden" name="id" value="<?= $statusRecord['id'] ?>">
                    <input type="hidden" name="role" value="HOD">
                    <input type="text" name="comments" placeholder="Comments..." required style="padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                    <button type="submit" name="action" value="approve" class="btn" style="color: green; border-color: green;">Approve</button>
                    <button type="submit" name="action" value="reject" class="btn" style="color: red; border-color: red;">Reject</button>
                </form>
            <?php elseif ($status == 'HOD_Approved'): ?>
                 <strong>IQS Action:</strong>
                <form action="<?= APP_URL ?>/marks/status" method="POST" style="display:inline; margin-left: 10px;">
                    <input type="hidden" name="id" value="<?= $statusRecord['id'] ?>">
                    <input type="hidden" name="role" value="IQS">
                    <input type="text" name="comments" placeholder="Comments (Optional)..." style="padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                    <button type="submit" name="action" value="approve" class="btn" style="color: green; border-color: green;">Approve</button>
                    <button type="submit" name="action" value="reject" class="btn" style="color: red; border-color: red;">Reject</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Marksheet Header -->
    <div class="sheet-header">
        <div class="logo-box">
            LOGO
        </div>
        <div class="institute-details">
            <div class="institute-name">TVET INSTITUTE</div>
            <div class="institute-sub">Competence Based Education & Training</div>
            <div class="institute-sub">Consolidated Marksheet</div>
        </div>
    </div>

    <!-- Unit Details -->
    <div class="unit-info">
        <div>
            <div class="unit-title"><?= htmlspecialchars($unit['unit_title']) ?></div>
            <div style="font-size: 0.9rem; color: #666;"><?= htmlspecialchars($unit['unit_code']) ?></div>
        </div>
        <div style="text-align: right;">
            <div><strong>Class:</strong> <?= htmlspecialchars($class['class_name'] ?? $class['class_code']) ?></div>
            <div><strong>Level:</strong> <?= htmlspecialchars($unit['assessment_level']) ?></div>
            <div style="margin-top: 5px;">
                Status: 
                <span style="padding: 2px 6px; border-radius: 4px; background: #e2e8f0; font-size: 0.8rem;">
                    <?= str_replace('_', ' ', $status) ?>
                </span>
            </div>
        </div>
    </div>

    <table style="font-size: 0.8rem;">
        <thead>
            <tr>
                <th rowspan="2" style="width: 30px;">S/N</th>
                <th rowspan="2" style="width: 80px;">Reg No</th>
                <th rowspan="2">Candidate Name</th>

                <!-- Practical Header -->
                <th colspan="<?= count($practicalSlots) ?>" style="text-align: center; background: #e0f2fe;">
                    PRACTICAL</th>

                <!-- Written Header -->
                <th colspan="<?= count($writtenSlots) ?>" style="text-align: center; background: #fef3c7;">WRITTEN
                    (THEORY)</th>

                <?php if ($type !== 'raw'): ?>
                    <th rowspan="2" style="width: 60px;">Final %</th>
                    <th rowspan="2" style="width: 80px;">Grade</th>
                <?php endif; ?>
            </tr>
            <tr>
                <!-- Practical Sub-columns -->
                <?php // Assuming sequential order in $practicalSlots for numbering ?>
                <?php $p = 1;
                foreach ($practicalSlots as $slot): ?>
                    <th style="font-size: 0.7rem; height: auto; vertical-align: bottom; text-align: center;">
                        PRAC <?= $p++ ?>
                    </th>
                <?php endforeach; ?>

                <!-- Written Sub-columns -->
                <?php $w = 1;
                foreach ($writtenSlots as $slot): ?>
                    <th style="font-size: 0.7rem; height: auto; vertical-align: bottom; text-align: center;">
                        WASSM <?= $w++ ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($students as $s): ?>
                <?php
                $res = $results[$s['id']];
                // To get individual slot marks, we need to access $res['topics'] -> slots? 
                // Re-indexing results by slot_id would be faster, but let's loop for now.
                // Actually $res structure from calculator is organized by TOPICS.
                // We need a map of slot_id -> mark/weighted_score
            
                $slotMap = [];
                foreach ($res['topics'] as $t) {
                    foreach ($t['slots'] as $slotRes) {
                        $slotMap[$slotRes['id']] = $slotRes;
                    }
                }
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($s['identifier']) ?></td>
                    <td><?= htmlspecialchars($s['full_name']) ?></td>

                    <!-- Practical Data -->
                    <?php foreach ($practicalSlots as $slot): ?>
                        <?php
                        $data = $slotMap[$slot['id']] ?? null;
                        $val = '-';
                        if ($data) {
                            if ($type == 'raw') {
                                $val = ($data['mark'] !== '-') ? number_format($data['mark'], 0) : '-';
                            } else {
                                if ($data['mark'] !== '-') {
                                    // Find Topic Details
                                    $topic = null;
                                    foreach ($res['topics'] as $t) {
                                        if ($t['id'] == $slot['topic_id']) {
                                            $topic = $t;
                                            break;
                                        }
                                    }

                                    if ($topic) {
                                        // Formula: (Mark/100) * (1/Count) * TypeRatio * TopicWeight
                
                                        $ratio = $res['ratios']['p']; // Practical
                                        $count = $topic['p_count'] ?? 1;
                                        if ($count == 0)
                                            $count = 1;

                                        $weightedVal = ($data['mark'] / 100) * (1 / $count) * $ratio * $topic['weight'];
                                        $val = number_format($weightedVal, 2);
                                    }
                                }
                            }
                        }
                        ?>
                        <td><?= $val ?></td>
                    <?php endforeach; ?>

                    <!-- Written Data -->
                    <?php foreach ($writtenSlots as $slot): ?>
                        <?php
                        $data = $slotMap[$slot['id']] ?? null;
                        $val = '-';
                        if ($data) {
                            if ($type == 'raw') {
                                if ($data['mark'] !== '-') {
                                    $val = number_format($data['mark'], 0);
                                }
                            } else {
                                if ($data['mark'] !== '-') {
                                    $topic = null;
                                    foreach ($res['topics'] as $t) {
                                        if ($t['id'] == $slot['topic_id']) {
                                            $topic = $t;
                                            break;
                                        }
                                    }

                                    if ($topic) {
                                        $ratio = $res['ratios']['w'];
                                        $count = $topic['w_count'] ?? 1;
                                        if ($count == 0)
                                            $count = 1;

                                        $weightedVal = ($data['mark'] / 100) * (1 / $count) * $ratio * $topic['weight'];
                                        $val = number_format($weightedVal, 2);
                                    }
                                }
                            }
                        }
                        ?>
                        <td><?= $val ?></td>
                    <?php endforeach; ?>

                    <!-- Final -->
                    <?php if ($type !== 'raw'): ?>
                        <td><strong>
                                <?= number_format($res['final_mark'], 0) ?>
                            </strong></td>
                        <td>
                            <?= ($res['final_mark'] >= 50) ? 'Competent' : 'NYC' ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 50px; display: flex; justify-content: space-between;">
        <!-- Trainer Sig -->
        <div class="stamp-box">
            <div class="stamp-text">Trainer Submitted</div>
            <div>By:
                <?= $statusRecord['submitted_by'] ?? 'Pending' ?>
            </div>
            <div>Date:
                <?= $statusRecord['submitted_at'] ?? '-' ?>
            </div>
            <div class="signature-line">Signature</div>
        </div>

        <!-- HOD Stamp -->
        <div
            class="stamp-box <?= ($status == 'HOD_Approved' || $status == 'IQS_Approved' || $status == 'IQS_Rejected') ? 'approved' : '' ?>">
            <?php if ($status == 'HOD_Approved' || $status == 'IQS_Approved' || $status == 'IQS_Rejected'): ?>
                <div class="stamp-text">HOD APPROVED</div>
                <div>By:
                    <?= $statusRecord['hod_user_id'] ?? 'HOD' ?>
                </div>
                <div>Date:
                    <?= $statusRecord['hod_action_at'] ?>
                </div>
            <?php elseif ($status == 'HOD_Rejected'): ?>
                <div class="stamp-text" style="color:red;">HOD REJECTED</div>
                <div>Reason:
                    <?= htmlspecialchars($statusRecord['hod_comments']) ?>
                </div>
            <?php else: ?>
                <div class="stamp-text" style="color:#ccc;">HOD PENDING</div>
            <?php endif; ?>
            <div class="signature-line">Signature</div>
        </div>

        <!-- IQS Stamp -->
        <div class="stamp-box <?= ($status == 'IQS_Approved') ? 'approved' : '' ?>">
            <?php if ($status == 'IQS_Approved'): ?>
                <div class="stamp-text">IQS APPROVED</div>
                <div>By:
                    <?= $statusRecord['iqs_user_id'] ?? 'IQS' ?>
                </div>
                <div>Date:
                    <?= $statusRecord['iqs_action_at'] ?>
                </div>
            <?php elseif ($status == 'IQS_Rejected'): ?>
                <div class="stamp-text" style="color:red;">IQS REJECTED</div>
                <div>Reason:
                    <?= htmlspecialchars($statusRecord['iqs_comments']) ?>
                </div>
            <?php else: ?>
                <div class="stamp-text" style="color:#ccc;">IQS PENDING</div>
            <?php endif; ?>
            <div class="signature-line">Signature</div>
        </div>
    </div>

    </div>
    <!-- End Sheet Container -->

</body>

</html>