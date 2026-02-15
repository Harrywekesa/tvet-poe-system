<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CBET POE' ?></title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --secondary: #64748b;
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Utility Classes */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-outline {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        nav {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 15px 0;
        }

        nav .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        nav .logo {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        nav .nav-links {
            display: flex;
        }

        nav .nav-links a {
            margin-left: 20px;
            color: var(--secondary);
            text-decoration: none;
            font-size: 0.95rem;
        }

        nav .nav-links a:hover {
            color: var(--primary);
        }

        .nav-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Responsive Grid & Layout Helpers */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .grid-main-side {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
        }

        /* Form Grids */
        .form-grid-3 {
            display: grid;
            grid-template-columns: 2fr 2fr auto;
            gap: 10px;
            align-items: end;
        }

        .form-grid-4 {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 10px;
            align-items: end;
        }

        .form-grid-5 {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr 1fr auto;
            gap: 10px;
            align-items: end;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hidden {
            display: none;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .nav-toggle {
                display: block;
            }

            .nav-links {
                display: none !important;
                /* Force hide by default on mobile */
                flex-direction: column;
                width: 100%;
                position: absolute;
                top: 100%;
                left: 0;
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 10px;
                box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
                z-index: 50;
                margin-top: 10px;
            }

            .nav-links.active {
                display: flex !important;
                /* Show only when active class is present */
            }

            nav .nav-links a {
                margin: 0;
                padding: 10px;
                border-bottom: 1px solid #f1f5f9;
                display: block;
            }

            nav .nav-links a:last-child {
                border-bottom: none;
            }

            .grid-2,
            .grid-3,
            .grid-main-side,
            .form-grid-3,
            .form-grid-4,
            .form-grid-5 {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            h1 {
                font-size: 1.75rem;
            }

            /* Responsive Forms */
            form {
                display: flex;
                flex-direction: column !important;
                gap: 10px !important;
            }

            form button {
                width: 100% !important;
                margin-left: 0 !important;
            }

            form input,
            form select,
            form textarea {
                width: 100% !important;
            }

            /* Hide non-critical table columns if needed, or scroll */
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
        /* Sidebar Layout */
        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: #1e293b;
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #334155;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
        }

        .nav-group {
            margin-bottom: 25px;
        }

        .nav-group-title {
            padding: 0 20px;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: 0.05em;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: #334155;
            color: white;
        }

        .nav-item.active {
            background: #334155;
            color: white;
            border-left-color: var(--primary);
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--bg-light);
            min-width: 0; /* Prevent flex overflow */
        }

        .top-bar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Mobile Sidebar */
        @media (max-width: 768px) {
            .app-layout {
                flex-direction: column;
            }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                z-index: 1000;
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>
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
        <script>
            const toast = document.getElementById('toast');
            if (toast) {
                // Set Color based on type
                <?php if (isset($_SESSION['flash_success'])): ?>
                    toast.style.borderLeftColor = '#22c55e'; // Green
                <?php else: ?>
                    toast.style.borderLeftColor = '#ef4444'; // Red
                <?php endif; ?>

                // Auto dismiss
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    toast.style.transition = 'all 0.5s ease';
                    setTimeout(() => toast.remove(), 500);
                }, 4000);
            }
        </script>
        <style>
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }

                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        </style>
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
        <nav>
            <div class="container nav-wrapper">
                <a href="<?= APP_URL ?>" class="logo">
                    <?php if ($logoPath): ?>
                        <img src="<?= APP_URL . $logoPath ?>" alt="Logo" style="height: 32px; width: auto; object-fit: contain;">
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
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
        <div class="app-layout">
            <aside class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <?php if ($logoPath): ?>
                        <img src="<?= APP_URL . $logoPath ?>" alt="Logo" style="height: 28px; width: auto; object-fit: contain;">
                    <?php endif; ?>
                    <span style="font-weight: 700; font-size: 1.1rem; color: #f1f5f9;"><?= htmlspecialchars($systemName) ?></span>
                </div>

                <div class="sidebar-nav">
                    <div class="nav-group">
                        <div class="nav-group-title">Main</div>
                        <a href="<?= APP_URL ?>/dashboard" class="nav-item">📊 Dashboard</a>
                        <a href="<?= APP_URL ?>/profile" class="nav-item">👤 My Profile</a>
                    </div>

                    <?php if ($_SESSION['role'] === 'Admin'): ?>
                        <div class="nav-group">
                            <div class="nav-group-title">Management</div>
                            <a href="<?= APP_URL ?>/institution" class="nav-item">🏛️ Institution</a>
                            <a href="<?= APP_URL ?>/academic" class="nav-item">🎓 Academic / Classes</a>
                            <a href="<?= APP_URL ?>/users" class="nav-item">👥 Users & Roles</a>
                        </div>
                        <div class="nav-group">
                            <div class="nav-group-title">Data & Reports</div>
                            <a href="<?= APP_URL ?>/marks/transcripts" class="nav-item">📜 Transcripts</a>
                            <a href="<?= APP_URL ?>/bulk-imports" class="nav-item">📂 Bulk Imports</a>
                            <a href="<?= APP_URL ?>/reports" class="nav-item">📈 logs & Activity</a>
                        </div>
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] === 'HOD'): ?>
                        <div class="nav-group">
                            <div class="nav-group-title">Department</div>
                            <a href="<?= APP_URL ?>/documents/review" class="nav-item">📑 Review Docs</a>
                            <a href="<?= APP_URL ?>/marks/approvals" class="nav-item">✅ Approvals</a>
                            <a href="<?= APP_URL ?>/marks/transcripts" class="nav-item">📜 Transcripts</a>
                        </div>
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] === 'InternalVerifier'): ?>
                        <div class="nav-group">
                            <div class="nav-group-title">Quality Assurance</div>
                            <a href="<?= APP_URL ?>/audit" class="nav-item">🔍 Start Audit</a>
                            <a href="<?= APP_URL ?>/marks/approvals" class="nav-item">✅ Approvals</a>
                            <a href="<?= APP_URL ?>/reports" class="nav-item">📈 QA Reports</a>
                        </div>
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] === 'Student'): ?>
                         <div class="nav-group">
                            <div class="nav-group-title">Learning</div>
                            <a href="<?= APP_URL ?>/poe/dashboard" class="nav-item">📂 My POE</a>
                        </div>
                    <?php endif; ?>
                    
                    <div style="margin-top: auto; border-top: 1px solid #334155; padding-top: 10px;">
                        <a href="<?= APP_URL ?>/logout" class="nav-item" style="color: #f87171;">🚪 Logout</a>
                    </div>
                </div>
            </aside>

            <div class="main-content">
                <!-- Top Bar for Logged In User -->
                <header class="top-bar">
                    <button class="btn btn-outline nav-toggle" onclick="toggleSidebar()" style="display: none; padding: 5px 10px; font-size: 1.2rem;">
                        ☰
                    </button>
                    <div style="font-weight: 600; color: #475569;">
                        <?= $title ?? 'Dashboard' ?>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span style="font-size: 0.9rem; color: #64748b;">
                            <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?> 
                            <span style="font-size: 0.8rem; background: #e2e8f0; padding: 2px 6px; border-radius: 4px; margin-left: 5px;">
                                <?= $_SESSION['role'] ?? 'Guest' ?>
                            </span>
                        </span>
                    </div>
                </header>
                <main style="flex: 1; padding-bottom: 40px;">

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.querySelector('.sidebar-overlay');
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }
            // Check if mobile, show toggle button
            if (window.innerWidth <= 768) {
                document.querySelector('.nav-toggle').style.display = 'block';
            }
            window.addEventListener('resize', () => {
                 if (window.innerWidth <= 768) {
                    document.querySelector('.nav-toggle').style.display = 'block';
                } else {
                    document.querySelector('.nav-toggle').style.display = 'none';
                    document.getElementById('sidebar').classList.remove('active');
                    document.querySelector('.sidebar-overlay').classList.remove('active');
                }
            });
        </script>
    <?php endif; ?>