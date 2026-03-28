<?php 
$cohorts = is_array($cohorts ?? []) ? $cohorts : [];
require_once __DIR__ . '/../partials/header.php'; 
?>

<div class="container mt-4" style="max-width: 1200px;">
    
    <!-- Breadcrumb -->
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i data-feather="arrow-left" style="width: 16px;"></i> Back to Dashboard
        </a>
    </div>

    <!-- Header Block -->
    <div style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <span class="badge badge-primary">Institutional Core</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;">Registrar Settings</span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;">Cohort Management</h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;">Manage academic intakes, sessions, and baseline active periods.</p>
    </div>

    <div class="grid-main-side" style="align-items: start; gap: 30px;">
        <!-- Left Pane: Cohort Directory -->
        <div class="card" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
            <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
                <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                    <i data-feather="calendar" style="color: var(--secondary);"></i> Active Intakes / Cohorts
                </h3>
                <span class="badge badge-secondary"><?= count($cohorts ?? []) ?> Found</span>
            </div>
            
            <?php if (empty($cohorts)): ?>
                <div class="text-center" style="padding: 40px 20px;">
                    <i data-feather="inbox" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                    <p style="color: var(--text-muted); margin: 0; font-style: italic;">No cohorts configured yet.<br>Create a new baseline intake to begin processing enrollments.</p>
                </div>
            <?php else: ?>
                <div style="display: flex; flex-direction: column;">
                    <?php foreach ($cohorts as $i => $c): ?>
                        <div style="padding: 15px 20px; border-bottom: <?= $i === count($cohorts) - 1 ? 'none' : '1px solid var(--border-color)' ?>; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; transition: background 0.2s; background: white;" onmouseover="this.style.background='#fbfcfd'" onmouseout="this.style.background='white'">
                            
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 40px; height: 40px; border-radius: 8px; background: rgba(37,99,235,0.05); border: 1px solid rgba(37,99,235,0.1); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                    <i data-feather="calendar" style="width: 18px;"></i>
                                </div>
                                <div>
                                    <span style="font-weight: 700; font-size: 1.05rem; display: block; color: var(--text-primary); margin-bottom: 4px;">
                                        <?= htmlspecialchars($c['name']) ?>
                                    </span>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <span class="badge" style="background: var(--bg-app); border: 1px solid var(--border-color); font-size: 0.75rem;"><i data-feather="clock" style="width: 10px; margin-right: 4px;"></i> <?= htmlspecialchars($c['start_date']) ?> to <?= htmlspecialchars($c['end_date'] ?? 'Ongoing') ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <?= component('button', [
                                'href' => APP_URL . "/academic/cohort/{$c['id']}", 
                                'label' => 'Manage Classes',
                                'class' => 'btn-outline',
                                'style' => 'font-size: 0.85rem;'
                            ]) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Pane: Add Form -->
        <?php if ($_SESSION['role'] === 'Admin'): ?>
            <div class="card" style="border-top: 4px solid var(--primary); padding: 24px;">
                <h3 style="margin-bottom: 20px; font-size: 1.25rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="plus-circle" style="color: var(--primary);"></i> Initialize Cohort
                </h3>

                <form action="<?= APP_URL ?>/academic/cohort" method="POST">
                    <?= csrf_field() ?>
                    
                    <div style="margin-bottom: 15px;">
                        <?= component('input', [
                            'name' => 'name',
                            'label' => 'Cohort Label',
                            'placeholder' => 'e.g. Jan 2024 Intake',
                            'required' => true
                        ]) ?>
                    </div>
                    
                    <div class="grid-2" style="gap: 15px;">
                        <div class="form-group m-0">
                            <?= component('input', [
                                'type' => 'date',
                                'name' => 'start_date',
                                'label' => 'Start Date',
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="form-group m-0">
                            <label class="form-label" style="display: flex; align-items: center; justify-content: space-between;">End Date <span style="color:var(--text-muted); font-size: 0.75rem; font-weight: normal;">Optional</span></label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100" style="padding: 12px; font-weight: 600; margin-top: 24px; font-size: 1rem;">
                        <i data-feather="check" style="width: 18px;"></i> Create Cohort
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>