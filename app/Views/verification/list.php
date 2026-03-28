<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
    </div>

    <h1>Verify: <?= htmlspecialchars($unit['unit_title']) ?></h1>
    
    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <h3>Approved Submissions (Sample Pool)</h3>
        <p class="text-secondary" style="font-size: 0.9rem; margin-bottom: 20px;">Review items marked as 'Approved' by trainers.</p>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; text-align: left;">
                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Student</th>
                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Assessment</th>
                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Evidence</th>
                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($samples as $s): ?>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;"><?= htmlspecialchars($s['student_name']) ?></td>
                    <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;"><?= htmlspecialchars($s['slot_title']) ?></td>
                    <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                         <a href="<?= APP_URL ?>/uploads/<?= $s['file_path'] ?>" target="_blank" style="text-decoration: underline; color: #2563eb;">View File</a>
                    </td>
                    <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                        <form action="<?= APP_URL ?>/verification/submit" method="POST" style="display: flex; gap: 5px; align-items: center;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="submission_id" value="<?= $s['id'] ?>">
                            <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                            
                            <input type="text" name="comments" placeholder="Verification Internal Note..." style="padding: 6px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.8rem; width: 180px;">
                            
                            <button type="submit" name="decision" value="Accept" class="btn btn-primary" style="padding: 6px 10px; font-size: 0.8rem; background: #22c55e;">Accept</button>
                            <button type="submit" name="decision" value="Flag" class="btn btn-primary" style="padding: 6px 10px; font-size: 0.8rem; background: #eab308; border-color: #eab308; color: black;">Flag</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($samples)): ?>
                    <tr><td colspan="4" style="padding: 20px; text-align: center; color: #64748b;">No approved submissions found to sample.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
