<?php require_once __DIR__ . '/partials/header.php'; ?>

<!-- Public Landing Page matching the Enterprise SaaS Design System -->
<div class="container" style="margin-top: 60px; max-width: 1200px;">
    
    <!-- Hero Section -->
    <div class="grid-main-side" style="align-items: center; gap: 60px; margin-bottom: 80px;">
        <div style="animation: slideIn 0.8s ease-out;">
            <h1 style="font-size: 3.5rem; font-weight: 800; color: var(--accent); line-height: 1.15; margin-bottom: 24px; letter-spacing: -1px;">
                Evidence-Based <br>
                <span style="color: var(--primary);">Competency Assessment</span>
            </h1>
            <p style="font-size: 1.15rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 32px; max-width: 550px;">
                Streamline your TVET institution's Portfolio of Evidence (POE) management. A secure, digital, and fully compliant framework replacing outdated manual paperwork.
            </p>
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <?= component('button', [
                    'href' => APP_URL . '/login', 
                    'label' => 'Access Institution Portal &rarr;', 
                    'class' => 'btn-primary',
                    'attrs' => 'style="padding: 16px 32px; font-size: 1.05rem;"'
                ]) ?>
            </div>
        </div>

        <!-- Dashboard Preview Card Wrapper -->
        <div class="card" style="padding: 0; overflow: hidden; position: relative; border-radius: 16px; box-shadow: var(--shadow-lg); background: white;">
            
            <!-- Faux Top Bar -->
            <div style="background: var(--bg-sidebar); height: 40px; display: flex; align-items: center; padding: 0 15px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <div style="display: flex; gap: 6px;">
                    <div style="width: 10px; height: 10px; border-radius: 50%; background: #EF4444;"></div>
                    <div style="width: 10px; height: 10px; border-radius: 50%; background: #F59E0B;"></div>
                    <div style="width: 10px; height: 10px; border-radius: 50%; background: #10B981;"></div>
                </div>
            </div>
            
            <!-- Faux Body -->
            <div style="padding: 24px; display: flex; gap: 20px;">
                <!-- Faux Sidebar -->
                <div style="width: 60px; display: flex; flex-direction: column; gap: 15px;">
                    <div style="height: 12px; background: #e2e8f0; border-radius: 4px;"></div>
                    <div style="height: 12px; background: #f1f5f9; border-radius: 4px; width: 80%;"></div>
                    <div style="height: 12px; background: #f1f5f9; border-radius: 4px; width: 90%;"></div>
                </div>
                <!-- Faux Content -->
                <div style="flex: 1;">
                    <div style="height: 20px; background: #e2e8f0; border-radius: 4px; width: 140px; margin-bottom: 20px;"></div>
                    <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                        <div style="flex: 1; height: 80px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px;"></div>
                        <div style="flex: 1; height: 80px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px;"></div>
                    </div>
                    <div style="height: 120px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px;"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- Features Overview using Enterprise Cards -->
    <div style="text-align: center; margin-bottom: 50px;">
        <h2 style="font-size: 2rem; color: var(--accent);">Why Choose Our Platform?</h2>
        <p class="text-muted" style="font-size: 1.05rem;">Built specifically for the dynamic needs of modern TVET institutions transitioning to CBET.</p>
    </div>

    <div class="grid-3" style="gap: 30px; margin-bottom: 80px;">
        <div class="card text-center" style="padding: 40px 24px; border-top: 4px solid var(--info);">
            <div style="width: 56px; height: 56px; background: #eff6ff; color: var(--info); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i data-feather="shield"></i>
            </div>
            <h3 style="margin-bottom: 12px; font-size: 1.3rem;">Secure Evidence</h3>
            <p class="text-muted" style="font-size: 0.95rem;">Digital portfolios are securely encrypted and stored indefinitely. Prevent document loss and maintain a pristine audit trail.</p>
        </div>

        <div class="card text-center" style="padding: 40px 24px; border-top: 4px solid var(--warning);">
            <div style="width: 56px; height: 56px; background: #fffbeb; color: var(--warning); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i data-feather="users"></i>
            </div>
            <h3 style="margin-bottom: 12px; font-size: 1.3rem;">Role-Based Workflows</h3>
            <p class="text-muted" style="font-size: 0.95rem;">Seamlessly connect Students, Trainers, Internal Verifiers, and HODs in a unified, strictly governed verification ecosystem.</p>
        </div>

        <div class="card text-center" style="padding: 40px 24px; border-top: 4px solid var(--success);">
            <div style="width: 56px; height: 56px; background: #f0fdf4; color: var(--success); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i data-feather="bar-chart-2"></i>
            </div>
            <h3 style="margin-bottom: 12px; font-size: 1.3rem;">Advanced Analytics</h3>
            <p class="text-muted" style="font-size: 0.95rem;">Generate deep insights and QA analytics to instantly identify department bottlenecks and assess institutional health.</p>
        </div>
    </div>

    <!-- Additional Content Layout -->
    <div class="card" style="margin-bottom: 60px; display: flex; flex-direction: column; align-items: center; text-align: center; padding: 50px 30px; background: var(--bg-sidebar); color: white;">
        <h2 style="color: white; margin-bottom: 20px;">Ready to Modernize Your Assessments?</h2>
        <p style="color: #cbd5e1; max-width: 600px; margin-bottom: 30px; font-size: 1.1rem;">
            <?= htmlspecialchars(isset($systemSettings['about_text']) ? $systemSettings['about_text'] : 'Join the growing number of institutions implementing fully compliant digital POE structures. Sign in to your portal below.') ?>
        </p>
        <?= component('button', ['href' => APP_URL . '/login', 'label' => 'Go to Login Portal', 'variant' => 'primary', 'attrs' => 'style="background: white; color: var(--bg-sidebar); border: none; font-weight: 700; padding: 12px 28px;"']) ?>
    </div>

</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>