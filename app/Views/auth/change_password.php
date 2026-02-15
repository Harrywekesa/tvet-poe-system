<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 50px; max-width: 500px;">
    <div
        style="background: white; padding: 30px; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">

        <h2 style="color: #1e293b; margin-bottom: 20px; text-align: center;">Change Password</h2>

        <div class="alert"
            style="background: #eff6ff; color: #1e40af; padding: 15px; border-radius: 6px; margin-bottom: 20px; text-align: center;">
            Please update your password to continue.
        </div>

        <?php if (isset($error)): ?>
            <div class="alert"
                style="background: #fee2e2; color: #dc2626; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= APP_URL ?>/change-password" method="POST">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #475569;">New
                    Password</label>
                <input type="password" name="new_password" required minlength="6"
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #475569;">Confirm
                    Password</label>
                <input type="password" name="confirm_password" required minlength="6"
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 1rem;">
                Update Password
            </button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>