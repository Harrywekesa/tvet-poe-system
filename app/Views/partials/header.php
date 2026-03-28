<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CBET POE' ?></title>
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css?v=<?= time() ?>">
</head>

<body>
    <!-- Toast Notification -->
    <?php if (isset($_SESSION['flash_success']) || isset($_SESSION['flash_error'])): ?>
        <div id="toast"
            style="position: fixed; top: 20px; right: 20px; z-index: 2000; background: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border-left: 5px solid; display: flex; align-items: center; justify-content: space-between; min-width: 300px; animation: slideIn 0.3s ease-out;">
            <span style="margin-right: 20px; font-weight: 500;">
                <?= $_SESSION['flash_success'] ?? $_SESSION['flash_error'] ?>
            </span>
            <button onclick="document.getElementById('toast').remove()"
                style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #94a3b8;">&times;</button>
        </div>
        <script src="<?= APP_URL ?>/js/toast.js"></script>
        
        <?php
        unset($_SESSION['flash_success']);
        unset($_SESSION['flash_error']);
    endif;
    ?>

    <?php
    // Fetch System Settings
    if (!isset($systemSettings)) {
        $instModelHeader = new \App\Models\InstitutionModel();
        $systemSettings = $instModelHeader->getInstitutionDetails();
    }
    $systemName = $systemSettings['system_name'] ?? 'CBET POE System';
    $logoPath = $systemSettings['logo_path'] ?? null;
    ?>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- GUEST LAYOUT (Top Nav) -->
        <nav class="guest-nav">
            <div class="container nav-wrapper">
                <a href="<?= APP_URL ?>" class="logo">
                    <?php if ($logoPath): ?>
                        <img src="<?= APP_URL . $logoPath ?>" alt="Logo"
                            style="height: 32px; width: auto; object-fit: contain;">
                    <?php endif; ?>
                    <?= htmlspecialchars($systemName) ?>
                </a>
                <div class="nav-links">
                    <a href="<?= APP_URL ?>/login">Login</a>
                </div>
            </div>
        </nav>
        <main style="flex: 1;">

        <?php else: ?>
            <!-- LOGGED IN SIDEBAR LAYOUT -->
            <div class="sidebar-overlay" onclick="toggleSidebar()" id="sidebarOverlay"></div>
            <div class="app-layout">
                <aside class="sidebar" id="sidebar">
                    <div class="sidebar-header">
                        <?php if ($logoPath): ?>
                            <img src="<?= APP_URL . $logoPath ?>" alt="Logo"
                                style="height: 28px; width: auto; object-fit: contain;">
                        <?php endif; ?>
                        <span><?= htmlspecialchars($systemName) ?></span>
                    </div>

                    <div class="sidebar-nav">
                        <div class="nav-group">
                            <div class="nav-group-title">Main</div>
                            <a href="<?= APP_URL ?>/dashboard" class="nav-item"><i data-feather="pie-chart" style="width: 18px; height: 18px; margin-right: 10px;"></i> Dashboard</a>
                            <a href="<?= APP_URL ?>/profile" class="nav-item"><i data-feather="user" style="width: 18px; height: 18px; margin-right: 10px;"></i> My Profile</a>
                        </div>

                        <?php if ($_SESSION['role'] === 'Admin'): ?>
                            <div class="nav-group">
                                <div class="nav-group-title">Management</div>
                                <a href="<?= APP_URL ?>/institution" class="nav-item"><i data-feather="briefcase" style="width: 18px; height: 18px; margin-right: 10px;"></i> Institution</a>
                                <a href="<?= APP_URL ?>/academic" class="nav-item"><i data-feather="book" style="width: 18px; height: 18px; margin-right: 10px;"></i> Academic / Classes</a>
                                <a href="<?= APP_URL ?>/users" class="nav-item"><i data-feather="users" style="width: 18px; height: 18px; margin-right: 10px;"></i> Users & Roles</a>
                            </div>
                            <div class="nav-group">
                                <div class="nav-group-title">Data & Reports</div>
                                <a href="<?= APP_URL ?>/marks/transcripts" class="nav-item"><i data-feather="file-text" style="width: 18px; height: 18px; margin-right: 10px;"></i> Transcripts</a>
                                <a href="<?= APP_URL ?>/bulk-imports" class="nav-item"><i data-feather="upload-cloud" style="width: 18px; height: 18px; margin-right: 10px;"></i> Bulk Imports</a>
                                <a href="<?= APP_URL ?>/reports" class="nav-item"><i data-feather="activity" style="width: 18px; height: 18px; margin-right: 10px;"></i> logs & Activity</a>
                            </div>
                        <?php endif; ?>

                        <?php if ($_SESSION['role'] === 'HOD'): ?>
                            <div class="nav-group">
                                <div class="nav-group-title">Department</div>
                                <a href="<?= APP_URL ?>/documents/review" class="nav-item"><i data-feather="check-circle" style="width: 18px; height: 18px; margin-right: 10px;"></i> Review Docs</a>
                                <a href="<?= APP_URL ?>/marks/approvals" class="nav-item"><i data-feather="check-square" style="width: 18px; height: 18px; margin-right: 10px;"></i> Approvals</a>
                                <a href="<?= APP_URL ?>/marks/transcripts" class="nav-item"><i data-feather="file-text" style="width: 18px; height: 18px; margin-right: 10px;"></i> Transcripts</a>
                            </div>
                        <?php endif; ?>

                        <?php if ($_SESSION['role'] === 'InternalVerifier'): ?>
                            <div class="nav-group">
                                <div class="nav-group-title">Quality Assurance</div>
                                <a href="<?= APP_URL ?>/audit" class="nav-item"><i data-feather="search" style="width: 18px; height: 18px; margin-right: 10px;"></i> Start Audit</a>
                                <a href="<?= APP_URL ?>/marks/approvals" class="nav-item"><i data-feather="check-square" style="width: 18px; height: 18px; margin-right: 10px;"></i> Approvals</a>
                                <a href="<?= APP_URL ?>/reports" class="nav-item"><i data-feather="activity" style="width: 18px; height: 18px; margin-right: 10px;"></i> QA Reports</a>
                            </div>
                        <?php endif; ?>

                        <?php if ($_SESSION['role'] === 'Student'): ?>
                            <div class="nav-group">
                                <div class="nav-group-title">Learning</div>
                                <a href="<?= APP_URL ?>/poe/dashboard" class="nav-item"><i data-feather="folder" style="width: 18px; height: 18px; margin-right: 10px;"></i> My POE</a>
                            </div>
                        <?php endif; ?>

                        <div style="margin-top: auto; border-top: 1px solid #334155; padding-top: 10px;">
                            <a href="<?= APP_URL ?>/logout" class="nav-item" style="color: #f87171;"><i data-feather="log-out" style="width: 18px; height: 18px; margin-right: 10px;"></i> Logout</a>
                        </div>
                    </div>
                </aside>

                <div class="main-content">
                    <!-- Top Bar for Logged In User -->
                    <header class="top-bar">
                        <button class="nav-toggle" onclick="toggleSidebar()">
                            <i data-feather="menu"></i>
                        </button>
                        <div class="hidden-xs" style="font-weight: 600; font-size: 1.1rem; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding: 0 10px;">
                            <?= $title ?? 'Dashboard' ?>
                        </div>
                        <div style="display: flex; align-items: center; gap: 15px; margin-left: auto;">
                            <span style="font-size: 0.9rem; color: var(--text-muted); display: flex; align-items: center; gap: 8px;">
                                <span style="display: inline-block; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($_SESSION['name'] ?? 'User') ?></span>
                                <span class="badge badge-secondary hidden-mobile">
                                    <?= $_SESSION['role'] ?? 'Guest' ?>
                                </span>
                            </span>
                        </div>
                    </header>
                    <main style="flex: 1; padding-bottom: 40px;" class="container">

                        <script src="<?= APP_URL ?>/js/sidebar.js"></script>
                    <?php endif; ?>