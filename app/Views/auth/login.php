<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="max-width: 450px; margin-top: 8vh;">
    <div class="card" style="padding: 40px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <h2 style="color: var(--accent); margin-bottom: 8px;">Welcome Back</h2>
            <p class="text-muted">Sign in to your account</p>
        </div>

        <?php if (isset($error)): ?>
            <?= component('alert', ['message' => htmlspecialchars($error), 'variant' => 'danger']) ?>
        <?php endif; ?>

        <form action="<?= APP_URL ?>/login" method="POST">
            <?= csrf_field() ?>
            
            <?= component('input', [
                'type' => 'text',
                'name' => 'identifier',
                'label' => 'Registration Number / Email',
                'required' => true,
                'placeholder' => 'e.g. S1234 or admin@local'
            ]) ?>

            <?= component('input', [
                'type' => 'password',
                'name' => 'password',
                'label' => 'Password',
                'required' => true,
                'placeholder' => '••••••••'
            ]) ?>

            <div class="mt-4">
                <?= component('button', [
                    'type' => 'submit',
                    'label' => 'Sign In',
                    'class' => 'w-100'
                ]) ?>
            </div>
        </form>
    </div>

    <div class="text-center mt-4 text-muted" style="font-size: 0.9rem;">
        <p>Default Admin: admin@cbet.local / admin123</p>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>