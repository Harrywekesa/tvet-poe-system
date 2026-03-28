<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1000px;">
    <div class="flex-between align-center" style="margin-bottom: 24px;">
        <div>
            <h1 class="page-title">IQS Verification: <?= htmlspecialchars($unit['unit_title']) ?></h1>
            <p class="text-muted">Review items marked as 'Approved' by trainers.</p>
        </div>
        <div>
            <?= component('button', ['href' => APP_URL . '/dashboard', 'label' => '&larr; Back to Dashboard', 'variant' => 'outline']) ?>
        </div>
    </div>
    
    <div class="card">
        <h3 style="margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
            <i data-feather="check-square" style="color: var(--success); width: 20px;"></i> 
            Approved Submissions (Sample Pool)
        </h3>
        
        <?php if (empty($samples)): ?>
            <div class="text-center text-muted" style="padding: 40px; background: var(--bg-app); border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
                <i data-feather="inbox" style="width: 40px; height: 40px; color: #cbd5e1; margin-bottom: 15px;"></i>
                <p style="margin: 0;">No approved submissions found to sample.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Student</th>
                            <th style="width: 30%;">Assessment</th>
                            <th style="width: 15%;">Evidence</th>
                            <th style="width: 30%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($samples as $s): ?>
                        <tr>
                            <td>
                                <strong style="color: var(--text-primary); font-size: 0.95rem; display: block;">
                                    <?= htmlspecialchars($s['student_name']) ?>
                                </strong>
                            </td>
                            <td>
                                <span style="font-size: 0.9rem; color: var(--text-muted);">
                                    <?= htmlspecialchars($s['slot_title']) ?>
                                </span>
                            </td>
                            <td>
                                 <a href="<?= APP_URL ?>/uploads/<?= htmlspecialchars($s['file_path']) ?>" target="_blank" style="text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-weight: 500; font-size: 0.85rem; color: var(--primary);">
                                    <i data-feather="external-link" style="width: 14px;"></i> View File
                                 </a>
                            </td>
                            <td>
                                <form action="<?= APP_URL ?>/verification/submit" method="POST" style="margin: 0; display: flex; flex-direction: column; gap: 8px;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="submission_id" value="<?= htmlspecialchars($s['id']) ?>">
                                    <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                    
                                    <input type="text" name="comments" class="form-control" placeholder="Verification Internal Note..." style="font-size: 0.8rem; padding: 6px;">
                                    
                                    <div style="display: flex; gap: 8px;">
                                        <button type="submit" name="decision" value="Accept" class="btn btn-primary w-100" style="padding: 6px; font-size: 0.85rem; background: var(--success); border-color: var(--success);">
                                            Accept
                                        </button>
                                        <button type="submit" name="decision" value="Flag" class="btn btn-outline w-100" style="padding: 6px; font-size: 0.85rem; color: var(--warning); border-color: var(--warning);">
                                            Flag Issue
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
