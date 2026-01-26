<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="max-width: 400px; margin-top: 60px;">
    <div style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 30px; color: var(--text-dark);">Login</h2>

        <?php if (isset($error)): ?>
            <div
                style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= APP_URL ?>/login" method="POST">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Registration Number / Email</label>
                <input type="text" name="identifier" required placeholder="e.g. S1234 or admin@local"
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Password</label>
                <input type="password" name="password" required
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Sign In</button>
        </form>
    </div>

    <div style="text-align: center; margin-top: 20px; font-size: 0.9rem; color: var(--secondary);">
        <p>Default Admin: admin@cbet.local / admin123</p>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>