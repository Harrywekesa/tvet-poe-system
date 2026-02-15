<?php
$title = 'IV Audit Dashboard';
ob_start();
?>

<div class="card p-4 mb-5 border-0 shadow-sm bg-gradient-brand text-white"
    style="background: linear-gradient(135deg, #008975 0%, #00BF9A 100%);">
    <div class="flex-between align-center">
        <div>
            <div class="text-xs uppercase tracking-wider opacity-75 mb-1">Internal Verification</div>
            <h2 class="m-0 text-white">Audit Hub</h2>
            <p class="text-sm opacity-90 mt-1">Manage, track, and verify assessment quality.</p>
        </div>
        <div class="text-right">
            <span class="text-xs opacity-75 d-block">Current Session</span>
            <span class="font-bold text-lg"><?= date('F Y') ?></span>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger mb-4 shadow-sm border-0"><?= $_SESSION['flash_error'];
    unset($_SESSION['flash_error']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['flash_success'])): ?>
    <div class="alert alert-success mb-4 shadow-sm border-0"><?= $_SESSION['flash_success'];
    unset($_SESSION['flash_success']); ?></div>
<?php endif; ?>

<!-- Stats Row -->
<div class="grid-3 mb-5 gap-4">
    <div class="card p-4 border-0 shadow-hover transition bg-white">
        <div class="flex-between align-start">
            <div>
                <div class="text-xs text-gray uppercase font-bold tracking-wide mb-1">Total Assigned</div>
                <div class="text-3xl font-bold text-dark"><?= $stats['total'] ?></div>
            </div>
            <div class="icon-box bg-blue-50 text-blue-600">
                📂
            </div>
        </div>
    </div>
    <div class="card p-4 border-0 shadow-hover transition bg-white">
        <div class="flex-between align-start">
            <div>
                <div class="text-xs text-gray uppercase font-bold tracking-wide mb-1">Completed</div>
                <div class="text-3xl font-bold text-success"><?= $stats['completed'] ?></div>
            </div>
            <div class="icon-box bg-green-50 text-green-600">
                ✅
            </div>
        </div>
    </div>
    <div class="card p-4 border-0 shadow-hover transition bg-white">
        <div class="flex-between align-start">
            <div>
                <div class="text-xs text-gray uppercase font-bold tracking-wide mb-1">Pending</div>
                <div class="text-3xl font-bold text-warning"><?= $stats['pending'] ?></div>
            </div>
            <div class="icon-box bg-orange-50 text-orange-600">
                ⏳
            </div>
        </div>
    </div>
</div>

<div class="flex-between align-center mb-4">
    <h3 class="m-0 text-dark">Assigned Units</h3>
    <div class="text-sm text-gray">
        Showing <strong><?= count($assigned) ?></strong> allocations
    </div>
</div>

<?php if (empty($assigned)): ?>
    <div class="card p-5 text-center border-dashed">
        <div class="text-4xl mb-3 opacity-50">📭</div>
        <h3 class="text-gray-dark">No Audits Assigned</h3>
        <p class="text-gray text-sm">You have not been assigned any units to verify yet.</p>
    </div>
<?php else: ?>
    <div class="grid-3 gap-4">
        <?php foreach ($assigned as $a):
            $progress = 0;
            // Calculate pseudo-progress (Start = 0, Perform = 50, Completed = 100)
            if ($a['session_id']) {
                $progress = $a['session_status'] === 'Completed' ? 100 : 50;
            }
            ?>
            <div class="card p-0 border-0 shadow-hover transition h-100 flex-column d-flex overflow-hidden bg-white">
                <div class="p-4 flex-grow-1">
                    <div class="flex-between mb-3">
                        <span class="badge bg-light text-primary border-0 font-medium text-xs">
                            <?= htmlspecialchars($a['unit_code']) ?>
                        </span>
                        <span class="text-xs text-gray font-medium">
                            <?= htmlspecialchars($a['class_code']) ?>
                        </span>
                    </div>

                    <h4 class="mb-2 text-lg font-bold text-dark leading-tight" style="min-height: 3rem;">
                        <?= htmlspecialchars($a['unit_title']) ?>
                    </h4>

                    <p class="text-sm text-gray mb-0">
                        <span class="d-block mb-1">📚 <?= htmlspecialchars($a['course_title']) ?></span>
                        <span class="d-block">👥 <?= $a['population'] ?> Students Enrolled</span>
                    </p>
                </div>

                <!-- Progress Bar -->
                <?php if ($a['session_id']): ?>
                    <div class="px-4 pb-2">
                        <div class="flex-between text-xs text-gray mb-1">
                            <span>Status</span>
                            <span
                                class="<?= $progress == 100 ? 'text-success' : 'text-primary' ?> font-bold"><?= $progress ?>%</span>
                        </div>
                        <div class="w-100 bg-gray-100 rounded-full h-15 overflow-hidden">
                            <div class="bg-<?= $progress == 100 ? 'success' : 'primary' ?> h-100" style="width: <?= $progress ?>%">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="p-4 pt-3 mt-auto border-top-light">
                    <?php if ($a['session_id']): ?>
                        <?php if ($a['session_status'] === 'Completed'): ?>
                            <a href="<?= APP_URL ?>/audit/report?id=<?= $a['session_id'] ?>"
                                class="btn btn-outline-success w-100 flex-center gap-2">
                                <span>📄</span> View Report
                            </a>
                        <?php else: ?>
                            <a href="<?= APP_URL ?>/audit/perform?id=<?= $a['session_id'] ?>"
                                class="btn btn-primary w-100 flex-center gap-2 shadow-primary-sm">
                                <span>▶</span> Continue Audit
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if ($a['population'] > 0): ?>
                            <a href="<?= APP_URL ?>/audit/setup?unit_id=<?= $a['unit_id'] ?>&class_id=<?= $a['class_id'] ?>"
                                class="btn btn-dark w-100 flex-center gap-2">
                                <span>🚀</span> Start Audit
                            </a>
                        <?php else: ?>
                            <button disabled class="btn btn-light w-100 text-gray">No Students</button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
    /* Premium Utilities */
    .bg-gradient-brand {
        background: linear-gradient(135deg, #008975 0%, #00BF9A 100%);
    }

    .text-white {
        color: #fff;
    }

    .opacity-75 {
        opacity: 0.75;
    }

    .opacity-90 {
        opacity: 0.9;
    }

    .opacity-50 {
        opacity: 0.5;
    }

    .tracking-wider {
        letter-spacing: 0.05em;
    }

    .tracking-wide {
        letter-spacing: 0.025em;
    }

    .gap-4 {
        gap: 1.5rem;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .shadow-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
    }

    .transition {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.5rem;
    }

    .bg-blue-50 {
        background-color: #eff6ff;
    }

    .text-blue-600 {
        color: #2563eb;
    }

    .bg-green-50 {
        background-color: #f0fdf4;
    }

    .text-green-600 {
        color: #16a34a;
    }

    .bg-orange-50 {
        background-color: #fff7ed;
    }

    .text-orange-600 {
        color: #ea580c;
    }

    .text-3xl {
        font-size: 1.875rem;
    }

    .text-4xl {
        font-size: 2.25rem;
    }

    .text-lg {
        font-size: 1.125rem;
    }

    .font-medium {
        font-weight: 500;
    }

    .leading-tight {
        line-height: 1.25;
    }

    .border-dashed {
        border: 2px dashed #e2e8f0;
    }

    .border-0 {
        border: none !important;
    }

    .shadow-sm {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .rounded-full {
        border-radius: 9999px;
    }

    .h-15 {
        height: 6px;
    }

    .h-100 {
        height: 100%;
    }

    .border-top-light {
        border-top: 1px solid #f1f5f9;
    }

    .flex-center {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-dark {
        background-color: #1e293b;
        color: #fff;
        border: none;
    }

    .btn-dark:hover {
        background-color: #0f172a;
    }

    .btn-outline-success {
        color: #16a34a;
        border: 1px solid #16a34a;
        background: transparent;
    }

    .btn-outline-success:hover {
        background: #f0fdf4;
    }

    .shadow-primary-sm {
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
    }

    /* Ensure cards stretch in grid */
    .d-flex {
        display: flex;
    }

    .flex-column {
        flex-direction: column;
    }

    .flex-grow-1 {
        flex-grow: 1;
    }

    .mt-auto {
        margin-top: auto;
    }
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layout.php';
?>