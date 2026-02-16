<?php
$title = 'IV Audit Hub';
ob_start();
?>

<!-- Premium Header -->
<div class="mb-5">
    <div class="flex-between align-end">
        <div>
            <div class="flex align-center gap-2 mb-2">
                <span class="badge bg-primary-soft text-primary font-bold uppercase tracking-wider text-xs">Internal
                    Verification</span>
                <span class="text-xs text-gray-400">&bull;</span>
                <span class="text-xs text-gray-500 font-medium"><?= date('F Y') ?> Session</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 m-0 tracking-tight">Audit Hub</h1>
            <p class="text-gray-500 mt-1 text-base">Oversee and verify assessment quality across all units.</p>
        </div>
        <div class="hidden md-block">
            <div class="flex align-center gap-3">
                <div class="text-right">
                    <div class="text-xs text-gray-400 uppercase font-bold tracking-wider">Internal Verifier</div>
                    <div class="font-bold text-sm text-gray-700"><?= $_SESSION['name'] ?></div>
                </div>
                <div class="avatar bg-gray-100 text-gray-600 font-bold border">
                    <?= substr($_SESSION['name'], 0, 1) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger mb-4 shadow-sm border-0 flex align-center gap-3">
        <span class="text-lg">⚠️</span>
        <div><?= $_SESSION['flash_error'];
        unset($_SESSION['flash_error']); ?></div>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['flash_success'])): ?>
    <div class="alert alert-success mb-4 shadow-sm border-0 flex align-center gap-3">
        <span class="text-lg">✅</span>
        <div><?= $_SESSION['flash_success'];
        unset($_SESSION['flash_success']); ?></div>
    </div>
<?php endif; ?>

<!-- Stats Overview -->
<div class="grid-3 mb-6 gap-6">
    <!-- Total Assigned -->
    <div class="stat-card">
        <div class="flex-between mb-4">
            <div class="stat-icon bg-blue-50 text-blue-600">📂</div>
            <?php if ($stats['total'] > 0): ?>
                <span class="badge bg-blue-50 text-blue-700">+<?= $stats['total'] ?> New</span>
            <?php endif; ?>
        </div>
        <div class="text-3xl font-bold text-gray-900 mb-1"><?= $stats['total'] ?></div>
        <div class="text-sm text-gray-500 font-medium">Total Assigned Units</div>
    </div>

    <!-- Completed -->
    <div class="stat-card">
        <div class="flex-between mb-4">
            <div class="stat-icon bg-green-50 text-green-600">✨</div>
            <?php if ($stats['completed'] > 0): ?>
                <span
                    class="badge bg-green-50 text-green-700"><?= round(($stats['completed'] / max($stats['total'], 1)) * 100) ?>%
                    Rate</span>
            <?php endif; ?>
        </div>
        <div class="text-3xl font-bold text-gray-900 mb-1"><?= $stats['completed'] ?></div>
        <div class="text-sm text-gray-500 font-medium">Completed Audits</div>
    </div>

    <!-- Pending -->
    <div class="stat-card">
        <div class="flex-between mb-4">
            <div class="stat-icon bg-orange-50 text-orange-600">⏳</div>
            <?php if ($stats['pending'] > 0): ?>
                <span class="badge bg-orange-50 text-orange-700">Action Req.</span>
            <?php endif; ?>
        </div>
        <div class="text-3xl font-bold text-gray-900 mb-1"><?= $stats['pending'] ?></div>
        <div class="text-sm text-gray-500 font-medium">Pending Verification</div>
    </div>
</div>

<!-- Main Content Area -->
<div class="mb-4 flex-between align-end">
    <div>
        <h3 class="text-xl font-bold text-gray-800 m-0">Assigned Units</h3>
        <p class="text-sm text-gray-500 m-0 mt-1">Select a unit to start or continue verification.</p>
    </div>
    <div class="flex gap-2">
        <!-- Filter/Sort placeholder if needed -->
    </div>
</div>

<?php if (empty($assigned)): ?>
    <div class="empty-state">
        <div class="empty-icon text-gray-300 mb-4">📭</div>
        <h4 class="text-lg font-bold text-gray-700 mb-2">No Assignments Yet</h4>
        <p class="text-gray-500 max-w-md mx-auto">You haven't been assigned any units for verification. Check back later or
            contact the administrator.</p>
    </div>
<?php else: ?>
    <div class="grid-3 gap-6">
        <?php foreach ($assigned as $a):
            $isStarted = (bool) $a['session_id'];
            $isCompleted = $a['session_status'] === 'Completed';
            $progress = 0;
            if ($isStarted)
                $progress = $isCompleted ? 100 : 50;
            ?>
            <div class="unit-card group">
                <div class="unit-card-header">
                    <div class="flex-between align-start mb-3">
                        <div class="badge bg-gray-100 text-gray-600 font-mono text-xs">
                            <?= htmlspecialchars($a['unit_code']) ?>
                        </div>
                        <?php if ($isCompleted): ?>
                            <span class="badge bg-green-100 text-green-700 flex align-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Verified
                            </span>
                        <?php elseif ($isStarted): ?>
                            <span class="badge bg-blue-100 text-blue-700 flex align-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 block animate-pulse"></span> In Progress
                            </span>
                        <?php else: ?>
                            <span class="badge bg-gray-50 text-gray-500 border">Not Started</span>
                        <?php endif; ?>
                    </div>

                    <h4 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2"
                        title="<?= htmlspecialchars($a['unit_title']) ?>">
                        <?= htmlspecialchars($a['unit_title']) ?>
                    </h4>

                    <div class="flex align-center gap-2 text-sm text-gray-500 mb-1">
                        <span>📚</span>
                        <span class="text-truncate"><?= htmlspecialchars($a['course_title']) ?></span>
                    </div>
                    <div class="flex align-center gap-3 text-sm text-gray-500">
                        <div class="flex align-center gap-1">
                            <span>🏫</span> <?= htmlspecialchars($a['class_code']) ?>
                        </div>
                        <div class="flex align-center gap-1">
                            <span>👥</span> <?= $a['population'] ?> Students
                        </div>
                    </div>
                </div>

                <!-- Footer / Action -->
                <div class="unit-card-footer">
                    <?php if ($isStarted): ?>
                        <div class="mb-3">
                            <div class="flex-between text-xs text-gray-500 mb-1">
                                <span>Progress</span>
                                <span class="font-medium"><?= $progress ?>%</span>
                            </div>
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-primary transition-all duration-500" style="width: <?= $progress ?>%"></div>
                            </div>
                        </div>
                        <?php if ($isCompleted): ?>
                            <a href="<?= APP_URL ?>/audit/report?id=<?= $a['session_id'] ?>"
                                class="btn btn-outline w-100 flex-center gap-2 group-hover:bg-primary group-hover:text-white transition-colors">
                                View Report <span>→</span>
                            </a>
                        <?php else: ?>
                            <a href="<?= APP_URL ?>/audit/perform?id=<?= $a['session_id'] ?>"
                                class="btn btn-primary w-100 flex-center gap-2 shadow-primary-glowing">
                                Continue Audit <span>→</span>
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if ($a['population'] > 0): ?>
                            <a href="<?= APP_URL ?>/audit/setup?unit_id=<?= $a['unit_id'] ?>&class_id=<?= $a['class_id'] ?>"
                                class="btn btn-dark w-100 flex-center gap-2">
                                Start Audit <span>→</span>
                            </a>
                        <?php else: ?>
                            <button disabled class="btn btn-light w-100 text-gray-400 cursor-not-allowed border bg-gray-50">
                                No Students Enrolled
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
    /* Premium Dashboard Styles */

    /* Layout */
    .grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }

    .gap-6 {
        gap: 1.5rem;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .gap-3 {
        gap: 0.75rem;
    }

    /* Typography */
    .text-3xl {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }

    .text-xl {
        font-size: 1.25rem;
        line-height: 1.75rem;
    }

    .text-lg {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }

    .text-base {
        font-size: 1rem;
        line-height: 1.5rem;
    }

    .text-sm {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .text-xs {
        font-size: 0.75rem;
        line-height: 1rem;
    }

    .font-bold {
        font-weight: 700;
    }

    .font-medium {
        font-weight: 500;
    }

    .font-mono {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    }

    .tracking-tight {
        letter-spacing: -0.025em;
    }

    .tracking-wider {
        letter-spacing: 0.05em;
    }

    .text-gray-900 {
        color: #111827;
    }

    .text-gray-800 {
        color: #1f2937;
    }

    .text-gray-700 {
        color: #374151;
    }

    .text-gray-600 {
        color: #4b5563;
    }

    .text-gray-500 {
        color: #6b7280;
    }

    .text-gray-400 {
        color: #9ca3af;
    }

    .text-gray-300 {
        color: #d1d5db;
    }

    .text-primary {
        color: #008975;
    }

    /* Components */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        font-weight: 500;
        white-space: nowrap;
    }

    .bg-primary-soft {
        background-color: rgba(0, 137, 117, 0.1);
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.2s;
    }

    .stat-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transform: translateY(-1px);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Unit Card */
    .unit-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.2s ease-in-out;
        height: 100%;
    }

    .unit-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .unit-card-header {
        padding: 1.5rem;
        flex: 1;
    }

    .unit-card-footer {
        padding: 1.25rem 1.5rem;
        background: #f9fafb;
        border-top: 1px solid #f3f4f6;
    }

    /* Buttons */
    .btn {
        cursor: pointer;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
        border: 1px solid transparent;
    }

    .btn-primary {
        background: #008975;
        color: #fff;
    }

    .btn-primary:hover {
        background: #007a68;
    }

    .btn-dark {
        background: #111827;
        color: #fff;
    }

    .btn-dark:hover {
        background: #000;
    }

    .btn-outline {
        background: white;
        border-color: #e5e7eb;
        color: #374151;
    }

    .btn-outline:hover {
        border-color: #d1d5db;
        background: #f9fafb;
    }

    .shadow-primary-glowing:hover {
        box-shadow: 0 4px 14px 0 rgba(0, 137, 117, 0.39);
    }

    /* Utilities */
    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .w-1\.5 {
        width: 0.375rem;
    }

    .h-1\.5 {
        height: 0.375rem;
    }

    .rounded-full {
        border-radius: 9999px;
    }

    .flex-between {
        display: flex;
        justify-content: space-between;
    }

    .align-center {
        align-items: center;
    }

    .align-end {
        align-items: flex-end;
    }

    .align-start {
        align-items: flex-start;
    }

    .hidden {
        display: none;
    }

    .block {
        display: block;
    }

    .w-100 {
        width: 100%;
    }

    .h-full {
        height: 100%;
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    .max-w-md {
        max-width: 28rem;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #f9fafb;
        border-radius: 12px;
        border: 2px dashed #e5e7eb;
    }

    .empty-icon {
        font-size: 3rem;
    }

    /* Colors */
    .bg-blue-50 {
        background-color: #eff6ff;
    }

    .text-blue-600 {
        color: #2563eb;
    }

    .text-blue-700 {
        color: #1d4ed8;
    }

    .bg-blue-100 {
        background-color: #dbeafe;
    }

    .bg-blue-500 {
        background-color: #3b82f6;
    }

    .bg-green-50 {
        background-color: #f0fdf4;
    }

    .text-green-600 {
        color: #16a34a;
    }

    .text-green-700 {
        color: #15803d;
    }

    .bg-green-100 {
        background-color: #dcfce7;
    }

    .bg-green-500 {
        background-color: #22c55e;
    }

    .bg-orange-50 {
        background-color: #fff7ed;
    }

    .text-orange-600 {
        color: #ea580c;
    }

    .text-orange-700 {
        color: #c2410c;
    }

    .bg-gray-50 {
        background-color: #f9fafb;
    }

    .bg-gray-100 {
        background-color: #f3f4f6;
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: .5;
        }
    }

    @media (min-width: 768px) {
        .md-block {
            display: block;
        }

        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .grid-3 {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layout.php';
?>