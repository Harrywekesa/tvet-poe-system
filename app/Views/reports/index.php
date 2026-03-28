<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1200px;">
    
    <!-- Breadcrumb -->
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/reports/landing" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i data-feather="arrow-left" style="width: 16px;"></i> Reports Hub
        </a>
    </div>

    <!-- Header Block -->
    <div style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <span class="badge badge-primary">Security & Compliance</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;">Admin Privileges</span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;">System Audit Trails</h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;">Immutable cryptographic ledger of framework modifications and triggers.</p>
    </div>

    <div class="grid-main-side" style="align-items: start; gap: 30px;">
        
        <!-- Left Pane: Logs Stream -->
        <div>
            <div class="card" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
                <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                    <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                        <i data-feather="activity" style="color: var(--secondary);"></i> Event Stream
                    </h3>
                    <span class="badge badge-secondary"><?= count($logs ?? []) ?> Records Found</span>
                </div>
                
                <?php if (empty($logs)): ?>
                    <div class="text-center" style="padding: 50px 20px;">
                        <i data-feather="slash" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                        <p style="color: var(--text-muted); margin: 0; font-style: italic;">No audit trails matching your search criteria.</p>
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column;">
                        <?php foreach ($logs as $i => $log): ?>
                            <div class="log-item-grid" style="padding: 20px; border-bottom: <?= $i === count($logs) - 1 ? 'none' : '1px solid var(--border-color)' ?>; transition: background 0.2s; background: white;" onmouseover="this.style.background='#fbfcfd'" onmouseout="this.style.background='white'">
                                
                                <!-- Meta Block -->
                                <div style="display: flex; flex-direction: column; gap: 6px; min-width: 140px;">
                                    <span style="font-size: 0.8rem; color: var(--text-muted); font-family: monospace; font-weight: 600;">
                                        <?= htmlspecialchars(date('M d, Y', strtotime($log['created_at']))) ?>
                                    </span>
                                    <span style="font-size: 0.75rem; color: var(--text-muted); font-family: monospace;">
                                        <?= htmlspecialchars(date('H:i:s', strtotime($log['created_at']))) ?>
                                    </span>
                                    <div style="margin-top: 5px;">
                                        <span class="badge" style="background: var(--bg-app); border: 1px solid var(--border-color); color: var(--text-secondary); text-transform: uppercase;">IP: <?= htmlspecialchars($log['ip_address']) ?></span>
                                    </div>
                                </div>
                                
                                <!-- Payload Block -->
                                <div>
                                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; flex-wrap: wrap; margin-bottom: 8px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(37,99,235,0.1); border: 1px solid rgba(37,99,235,0.2); display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 0.8rem; font-weight: 700;">
                                                <?= $log['full_name'] ? substr(htmlspecialchars($log['full_name']), 0, 1) : 'S' ?>
                                            </div>
                                            <strong style="color: var(--text-primary); font-size: 1.05rem;">
                                                <?= $log['full_name'] ? htmlspecialchars($log['full_name']) : '<span style="color: var(--text-muted); font-style: italic;">System Root</span>' ?>
                                            </strong>
                                        </div>
                                        <span class="badge" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: var(--success); font-weight: 700; letter-spacing: 0.5px;">
                                            <?= htmlspecialchars($log['action']) ?>
                                        </span>
                                    </div>
                                    <div style="font-size: 0.95rem; color: var(--text-secondary); line-height: 1.5; background: #f8fafc; padding: 12px; border-radius: var(--radius-sm); border: 1px dashed var(--border-color); word-break: break-word;">
                                        <?= htmlspecialchars($log['details']) ?>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Pane: Filter Engine -->
        <div class="card" style="border-top: 4px solid var(--primary); padding: 24px; position: sticky; top: 20px;">
            <h3 style="margin-bottom: 20px; font-size: 1.25rem; display: flex; align-items: center; gap: 8px;">
                <i data-feather="filter" style="color: var(--primary);"></i> Query Engine
            </h3>

            <form action="<?= APP_URL ?>/reports" method="GET">
                
                <div class="form-group">
                    <label class="form-label">System Operator</label>
                    <div style="position: relative;">
                        <i data-feather="user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); width: 14px;"></i>
                        <select name="user_id" class="form-control" style="padding-left: 36px;">
                            <option value="">All Users / Root</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id'] ?>" <?= ($filters['user_id'] ?? '') == $u['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($u['full_name']) ?> (<?= $u['role_name'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Action Classification</label>
                    <input type="text" name="action" class="form-control" placeholder="e.g. Login, Delete" value="<?= htmlspecialchars($filters['action'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Temporal Filter</label>
                    <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($filters['date'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Payload Search Filter</label>
                    <div style="position: relative;">
                        <i data-feather="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); width: 14px;"></i>
                        <input type="text" name="search" class="form-control" placeholder="Fuzzy search metadata..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>" style="padding-left: 36px;">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 15px; margin-bottom: 5px;">
                    <label class="form-label" style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-weight: 500; font-size: 0.9rem; color: var(--text-primary);">
                        <input type="checkbox" name="hide_auth" value="1" <?= ($filters['hide_auth'] ?? false) ? 'checked' : '' ?> style="width: 16px; height: 16px; margin-top: 2px; accent-color: var(--primary);">
                        <span>Hide Routine Authentication Events <span style="display:block; font-size: 0.75rem; color: var(--text-muted); font-weight:normal;">Removes Login/Logout from the event stream.</span></span>
                    </label>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 25px; flex-direction: column;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px; font-weight: 600;">
                        <i data-feather="search" style="width: 18px;"></i> Execute Query
                    </button>
                    <a href="<?= APP_URL ?>/reports" class="btn btn-outline" style="text-align: center; font-weight: 600;">Reset Filters</a>
                </div>
                
            </form>
        </div>

    </div>
</div>

<style>
/* Responsive layout for the audit log cards */
.log-item-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
}

@media (min-width: 768px) {
    .log-item-grid {
        grid-template-columns: 140px 1fr;
        gap: 25px;
    }
}

/* Responsive tweaks to ensure grid falls over cleanly on phone */
@media (max-width: 767px) {
    .log-item-grid > div:first-child {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        background: var(--bg-app);
        padding: 10px 15px;
        border-radius: var(--radius-sm);
    }
}
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>