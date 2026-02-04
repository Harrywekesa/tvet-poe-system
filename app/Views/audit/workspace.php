<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container" style="margin-top: 20px; max-width: 1400px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <a href="<?= APP_URL ?>/audit/workspace?class_id=<?= $class['id'] ?>" class="btn btn-outline"
                style="font-size: 0.8rem;">&larr; Switch Unit</a>
            <h1 style="margin: 10px 0 0 0; font-size: 1.5rem;">Audit Workspace</h1>
            <p class="text-secondary">
                <?= htmlspecialchars($unit['unit_title']) ?> (
                <?= htmlspecialchars($class['class_code']) ?>)
            </p>
        </div>
        <div>
            <span
                style="background: #e0f2fe; color: #0284c7; padding: 5px 10px; border-radius: 4px; font-size: 0.9rem;">IV
                Mode Active</span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 350px 1fr; gap: 20px;">

        <!-- Left: Professional Docs & Reference -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div
                style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; border-left: 4px solid #2563eb;">
                <h3 style="margin-top: 0;">Professional Documents</h3>
                <p style="font-size: 0.85rem; color: #64748b;">Verify these matched student grades.</p>

                <?php foreach ($prof_docs as $pd): ?>
                    <div style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                        <strong>
                            <?= htmlspecialchars($pd['type']) ?>
                        </strong>
                        <div style="margin-top: 5px;">
                            <a href="<?= APP_URL ?>/preview/download?file=docs/<?= $pd['file_path'] ?>" target="_blank"
                                style="font-size: 0.85rem; color: #2563eb;">View Document</a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($prof_docs)): ?>
                    <p style="color: red; font-size: 0.9rem;">⚠️ No professional documents found.</p>
                <?php endif; ?>
            </div>

            <div style="background: #f8fafc; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <h4>Audit Checklist</h4>
                <ul style="font-size: 0.9rem; padding-left: 20px;">
                    <li>Check Marksheet vs POE Grades</li>
                    <li>Verify Attendance meets threshold</li>
                    <li>Ensure Course Outline followed</li>
                </ul>
            </div>
        </div>

        <!-- Right: Student Evidence -->
        <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <h3>Student Portfolios</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc; text-align: left;">
                        <th style="padding: 10px;">Student</th>
                        <th style="padding: 10px;">Submissions</th>
                        <th style="padding: 10px;">Trainer Grade</th>
                        <th style="padding: 10px;">IV Decision</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $s):
                        $subs = $poe_data[$s['id']] ?? [];
                        ?>
                        <tr style="border-bottom: 2px solid #e2e8f0; background: #fff;">
                            <td style="padding: 15px; font-weight: 500; vertical-align: top;">
                                <div><?= htmlspecialchars($s['full_name']) ?></div>
                                <div style="font-size: 0.8rem; color: #1e40af; font-weight: 600;">
                                    <?= htmlspecialchars($s['identifier']) ?>
                                </div>
                                <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">
                                    <?= htmlspecialchars($s['email']) ?>
                                </div>
                            </td>

                            <td colspan="3" style="padding: 0;">
                                <?php if (empty($subs)): ?>
                                    <div style="padding: 15px; color: #94a3b8; font-style: italic;">No submissions found.</div>
                                <?php else: ?>
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <?php foreach ($subs as $sub):
                                            // Extract details for this specific submission
                                            $subId = $sub['id'];
                                            $status = $sub['status'];
                                            $verification = $sub['verification_status'] ?? 'Pending';
                                            $slotTitle = $sub['slot_title'] ?? ('Assessment ' . $sub['assessment_slot_id']);

                                            // Determine verification color
                                            $verColor = match ($verification) {
                                                'Accepted', 'Verified' => 'green',
                                                'Rejected', 'Flagged' => 'red',
                                                default => 'orange'
                                            };
                                            ?>
                                            <tr style="border-bottom: 1px dashed #f1f5f9;">
                                                <td style="padding: 10px; width: 35%;">
                                                    <div style="font-size: 0.9rem; font-weight: 600; color: #334155;">
                                                        <?= htmlspecialchars($slotTitle) ?>
                                                    </div>
                                                    <div style="margin-top: 5px;">
                                                        <a href="<?= APP_URL ?>/preview/submission/<?= $subId ?>" target="_blank"
                                                            class="btn btn-outline" style="font-size: 0.75rem; padding: 2px 8px;">
                                                            📄 View Evidence
                                                        </a>
                                                    </div>
                                                </td>
                                                <td style="padding: 10px; width: 25%;">
                                                    <span style="font-weight: bold; font-size: 0.9rem; color: #475569;">
                                                        <?= htmlspecialchars($status) ?>
                                                    </span>
                                                </td>
                                                <td style="padding: 10px;">
                                                    <form action="<?= APP_URL ?>/review/verification_update" method="POST"
                                                        style="display: flex; flex-direction: column; gap: 5px;">
                                                        <input type="hidden" name="submission_id" value="<?= $subId ?>">
                                                        <input type="hidden" name="redirect_url"
                                                            value="<?= $_SERVER['REQUEST_URI'] ?>">

                                                        <div
                                                            style="display: flex; align-items: center; justify-content: space-between;">
                                                            <span
                                                                style="font-size: 0.8rem; font-weight: bold; color: <?= $verColor ?>">
                                                                <?= htmlspecialchars($verification) ?>
                                                            </span>
                                                        </div>

                                                        <?php
                                                        // Normalize status
                                                        $verCheck = trim(strtolower($verification));
                                                        $isVerified = in_array($verCheck, ['accepted', 'verified', 'completed']);
                                                        ?>

                                                        <?php if (!$isVerified): ?>
                                                            <div style="display: flex; gap: 5px;">
                                                                <button type="submit" name="status" value="Accepted"
                                                                    title="Agree/Verify"
                                                                    style="background: #dcfce7; border: 1px solid #22c55e; color: #15803d; cursor: pointer; border-radius: 4px; padding: 2px 6px; font-size: 0.8rem;">
                                                                    Verify
                                                                </button>
                                                                <input type="text" name="cv_reason" placeholder="Reason..."
                                                                    style="padding: 2px 4px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.8rem; width: 80px;">
                                                                <button type="submit" name="status" value="Rejected" title="Reject"
                                                                    style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; cursor: pointer; border-radius: 4px; padding: 2px 6px; font-size: 0.8rem;">
                                                                    Reject
                                                                </button>
                                                            </div>
                                                        <?php endif; ?>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>