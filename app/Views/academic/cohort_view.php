<?php 
$classes = is_array($classes ?? []) ? $classes : [];
require_once __DIR__ . '/../partials/header.php'; 
?>

<div class="container mt-4" style="max-width: 1200px;">
    
    <!-- Breadcrumb -->
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/academic" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i data-feather="arrow-left" style="width: 16px;"></i> All Cohort Baselines
        </a>
    </div>

    <!-- Header Block -->
    <div style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <span class="badge badge-primary">Cohort Sandbox</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;">Registrar Settings</span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;"><?= htmlspecialchars($cohort['name']) ?></h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;">Manage active class programs and courses nested within this intake.</p>
    </div>

    <div class="grid-main-side" style="align-items: start; gap: 30px;">
        <!-- Left Pane: Classes List -->
        <div class="card" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
            <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
                <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                    <i data-feather="layers" style="color: var(--secondary);"></i> Active Course Programs
                </h3>
                <span class="badge badge-secondary"><?= count($classes ?? []) ?> Active</span>
            </div>
            
            <?php if (empty($classes)): ?>
                <div class="text-center" style="padding: 40px 20px;">
                    <i data-feather="monitor" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                    <p style="color: var(--text-muted); margin: 0; font-style: italic;">No classes populated in this cohort.<br>Create a course program on the right panel.</p>
                </div>
            <?php else: ?>
                <div style="display: flex; flex-direction: column;">
                    <?php foreach ($classes as $i => $cl): ?>
                        <div style="padding: 15px 20px; border-bottom: <?= $i === count($classes) - 1 ? 'none' : '1px solid var(--border-color)' ?>; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; transition: background 0.2s; background: white;" onmouseover="this.style.background='#fbfcfd'" onmouseout="this.style.background='white'">
                            
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 40px; height: 40px; border-radius: 8px; background: rgba(37,99,235,0.05); border: 1px solid rgba(37,99,235,0.1); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                    <i data-feather="home" style="width: 18px;"></i>
                                </div>
                                <div>
                                    <span style="font-weight: 700; font-size: 1.05rem; display: block; color: var(--text-primary); margin-bottom: 4px;">
                                        <?= htmlspecialchars($cl['class_code']) ?>
                                    </span>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <span class="badge" style="background: var(--bg-app); border: 1px solid var(--border-color); font-size: 0.75rem;"><i data-feather="book-open" style="width: 10px; margin-right: 4px;"></i> <?= htmlspecialchars($cl['course_title']) ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <?= component('button', [
                                'href' => APP_URL . "/academic/class/{$cl['id']}", 
                                'label' => 'Manage View',
                                'class' => 'btn-outline',
                                'style' => 'font-size: 0.85rem;'
                            ]) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Pane: Add Class Form -->
        <div class="card" style="border-top: 4px solid var(--primary); padding: 24px;">
            <h3 style="margin-bottom: 20px; font-size: 1.25rem; display: flex; align-items: center; gap: 8px;">
                <i data-feather="plus-circle" style="color: var(--primary);"></i> Provision Class
            </h3>

            <form action="<?= APP_URL ?>/academic/class" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="cohort_id" value="<?= htmlspecialchars($cohort['id']) ?>">
                
                <div class="form-group">
                    <label class="form-label">Core Program Track <span style="color:var(--danger)">*</span></label>
                    <select name="course_id" class="form-control" required style="font-weight: 600;">
                        <option value="">Select Parent Course...</option>
                        <?php foreach ($courses as $c): ?>
                            <option value="<?= htmlspecialchars($c['id']) ?>"><?= htmlspecialchars($c['title']) ?> (<?= htmlspecialchars($c['code']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 10px;">
                    <?= component('input', [
                        'name' => 'class_code',
                        'label' => 'Unique Class Code / Roster Hash',
                        'placeholder' => 'e.g. ICT-JAN-24-A',
                        'required' => true,
                        'attrs' => 'style="font-family: monospace; font-weight: 700;"'
                    ]) ?>
                </div>
                
                <button type="submit" class="btn btn-primary w-100" style="padding: 12px; font-weight: 600; margin-top: 15px; font-size: 1rem;">
                    <i data-feather="save" style="width: 18px;"></i> Commit Class
                </button>
            </form>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
