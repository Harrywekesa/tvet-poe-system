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
    </style>
</head>

<body>
    <!-- Toast Notification -->
    <?php if (isset($_SESSION['flash_success']) || isset($_SESSION['flash_error'])): ?>
        <div id="toast"
            style="position: fixed; top: 20px; right: 20px; z-index: 1000; background: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border-left: 5px solid; display: flex; align-items: center; justify-content: space-between; min-width: 300px; animation: slideIn 0.3s ease-out;">
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

    <nav>
        <div class="container nav-wrapper">
            <a href="<?= APP_URL ?>" class="logo">
                CBET POE System
            </a>

            <button class="nav-toggle" aria-label="toggle navigation"
                onclick="document.querySelector('.nav-links').classList.toggle('active')">
                <span
                    style="display: block; width: 25px; height: 3px; background: var(--primary); margin: 5px 0;"></span>
                <span
                    style="display: block; width: 25px; height: 3px; background: var(--primary); margin: 5px 0;"></span>
                <span
                    style="display: block; width: 25px; height: 3px; background: var(--primary); margin: 5px 0;"></span>
            </button>

            <div class="nav-links">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="<?= APP_URL ?>/login">Login</a>
                <?php else: ?>
                    <a href="<?= APP_URL ?>/dashboard">Dashboard</a>

                    <?php if ($_SESSION['role'] === 'Admin'): ?>
                        <a href="<?= APP_URL ?>/institution" title="Manage Institution">Institution</a>
                        <a href="<?= APP_URL ?>/academic" title="Manage Cohorts">Academic</a>
                        <a href="<?= APP_URL ?>/users" title="Manage Users">Users</a>
                        <a href="<?= APP_URL ?>/reports" style="color: #c2410c;" title="System Logs">Reports</a>
                    <?php elseif ($_SESSION['role'] === 'HOD'): ?>
                        <a href="<?= APP_URL ?>/institution" title="Manage Institution">Institution</a>
                        <a href="<?= APP_URL ?>/documents/review" title="Review Docs">Review</a>
                    <?php elseif ($_SESSION['role'] === 'InternalVerifier'): ?>
                        <a href="<?= APP_URL ?>/audit" title="Audit Units">Start Audit</a>
                        <a href="<?= APP_URL ?>/reports" title="QA Reports">QA Reports</a>
                    <?php elseif ($_SESSION['role'] === 'Student'): ?>
                        <a href="<?= APP_URL ?>/poe/dashboard" title="View Evidence">My POE</a>
                    <?php endif; ?>

                    <a href="<?= APP_URL ?>/profile">My Profile</a>
                    <a href="<?= APP_URL ?>/logout" style="color: #ef4444;">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main style="flex: 1;">