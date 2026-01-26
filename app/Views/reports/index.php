<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
    </div>

    <h1>System Logs & Reports</h1>
    <p class="text-secondary">Audit trail of system activities.</p>

    <!-- filters -->
    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <form action="" method="GET" class="form-grid-4" style="align-items: end;">
            <div>
                <label style="font-size: 0.9rem; display: block; margin-bottom: 5px;">User</label>
                <select name="user_id"
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <option value="">All Users</option>
                    <?php foreach ($users as $u): ?>
                        <option value="<?= $u['id'] ?>" <?= $filters['user_id'] == $u['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($u['full_name']) ?> (
                            <?= $u['role_name'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label style="font-size: 0.9rem; display: block; margin-bottom: 5px;">Action Type</label>
                <input type="text" name="action" placeholder="e.g. Login"
                    value="<?= htmlspecialchars($filters['action'] ?? '') ?>"
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>
            <div>
                <label style="font-size: 0.9rem; display: block; margin-bottom: 5px;">Date</label>
                <input type="date" name="date" value="<?= $filters['date'] ?? '' ?>"
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>
            <button type="submit" class="btn btn-primary" style="height: fit-content;">Filter Logs</button>
        </form>
    </div>

    <!-- Log Table -->
    <div style="background: white; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; text-align: left; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 15px; font-size: 0.9rem; color: #64748b;">Timestamp</th>
                    <th style="padding: 15px; font-size: 0.9rem; color: #64748b;">User</th>
                    <th style="padding: 15px; font-size: 0.9rem; color: #64748b;">Action</th>
                    <th style="padding: 15px; font-size: 0.9rem; color: #64748b;">Details</th>
                    <th style="padding: 15px; font-size: 0.9rem; color: #64748b;">IP Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 15px; white-space: nowrap; font-size: 0.9rem;">
                            <?= $log['created_at'] ?>
                        </td>
                        <td style="padding: 15px; font-weight: 500; font-size: 0.9rem;">
                            <?php if ($log['full_name']): ?>
                                <?= htmlspecialchars($log['full_name']) ?>
                            <?php else: ?>
                                <span style="color: #94a3b8;">System / Guest</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 15px;">
                            <span
                                style="background: #e0f2fe; color: #0284c7; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">
                                <?= htmlspecialchars($log['action']) ?>
                            </span>
                        </td>
                        <td style="padding: 15px; font-size: 0.9rem; color: #475569;">
                            <?= htmlspecialchars($log['details']) ?>
                        </td>
                        <td style="padding: 15px; font-size: 0.85rem; color: #94a3b8;">
                            <?= htmlspecialchars($log['ip_address']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="5" style="padding: 30px; text-align: center; color: #94a3b8;">No logs found for this
                            criteria.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>