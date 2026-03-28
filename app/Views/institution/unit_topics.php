<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1200px;">
    
    <!-- Breadcrumb / Back Navigation -->
    <div style="margin-bottom: 20px;">
        <?php if (($_SESSION['role'] ?? '') === 'Trainer'): ?>
            <a href="<?= APP_URL ?>/dashboard" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
                <i data-feather="arrow-left" style="width: 16px;"></i> Back to Dashboard
            </a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/institution/unit/<?= $unit['id'] ?>" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
                <i data-feather="arrow-left" style="width: 16px;"></i> Back to Unit Overview
            </a>
        <?php endif; ?>
    </div>

    <!-- Layout Header -->
    <div style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <span class="badge badge-primary">Topic Matrix</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;"><?= htmlspecialchars($unit['unit_code']) ?></span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;"><?= htmlspecialchars($unit['unit_title']) ?></h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;">Manage curricular elements and structural weighting.</p>
    </div>

    <div class="grid-main-side" style="align-items: start; gap: 30px;">
        
        <!-- Left Pane: Topics List & Level Config -->
        <div>
            <!-- Warning Alert for Weighting -->
            <?php if ($totalWeight != 100): ?>
                <div class="alert alert-warning" style="margin-bottom: 20px; display: flex; align-items: center; gap: 12px; border-left: 4px solid var(--warning);">
                    <i data-feather="alert-triangle" style="color: var(--warning);"></i>
                    <div>
                        <strong>Curriculum Warning:</strong> Total topic weighting is currently <strong><?= number_format($totalWeight, 0) ?>%</strong>. It must equal exactly 100% for the grading engine to compute final marks accurately.
                    </div>
                </div>
            <?php endif; ?>

            <!-- Topics List Card -->
            <div class="card" style="padding: 0; overflow: hidden; margin-bottom: 20px;">
                <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i data-feather="layers" style="color: var(--secondary);"></i>
                        <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary);">Configured Elements</h3>
                    </div>
                    <span class="badge badge-secondary"><?= count($topics) ?> Topics</span>
                </div>

                <?php if (empty($topics)): ?>
                    <div class="text-center" style="padding: 40px 20px;">
                        <i data-feather="check-square" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                        <p style="color: var(--text-muted); margin: 0;">No topics defined yet.<br>Use the configurator to map the curriculum.</p>
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column;">
                        <?php foreach ($topics as $i => $t): ?>
                            <div style="padding: 15px 20px; border-bottom: <?= $i === count($topics) - 1 ? 'none' : '1px solid var(--border-color)' ?>; display: flex; justify-content: space-between; align-items: center; transition: background 0.2s;" onmouseover="this.style.background='#fbfcfd'" onmouseout="this.style.background='white'">
                                
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div style="width: 32px; height: 32px; border-radius: 6px; background: var(--bg-app); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--text-muted); font-size: 0.85rem;">
                                        #<?= htmlspecialchars($t['sequence_order']) ?>
                                    </div>
                                    <div>
                                        <h4 style="margin: 0; font-size: 1rem; color: var(--text-primary); margin-bottom: 4px;"><?= htmlspecialchars($t['title']) ?></h4>
                                        <div style="display: flex; gap: 10px; align-items: center;">
                                            <span style="font-size: 0.8rem; font-weight: 600; color: <?= $t['weight_percentage'] > 0 ? 'var(--primary)' : 'var(--text-muted)' ?>; background: rgba(37,99,235,0.08); padding: 2px 8px; border-radius: 12px; border: 1px solid rgba(37,99,235,0.1);">Weight: <?= number_format($t['weight_percentage'], 0) ?>%</span>
                                        </div>
                                    </div>
                                </div>

                                <form action="<?= APP_URL ?>/topic/delete/<?= htmlspecialchars($t['id']) ?>" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to delete this topic? This may impact tied assessments.');" style="margin: 0;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-outline" style="color: var(--danger); border-color: #fca5a5; padding: 6px 10px; font-size: 0.85rem;" title="Delete Topic">
                                        <i data-feather="trash-2" style="width: 16px;"></i>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Assessment Strategy Control (Moving to bottom left instead of taking up top space) -->
            <div class="card" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                <div>
                    <h3 style="margin: 0 0 4px 0; font-size: 1.1rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                        <i data-feather="settings" style="width: 18px; color: var(--primary);"></i> Grading Strategy Engine
                    </h3>
                    <p style="color: var(--text-muted); margin: 0; font-size: 0.9rem;">Sets the exact Written vs. Practical weight ratio for the entire unit's final calculated grade.</p>
                </div>
                
                <form action="<?= APP_URL ?>/unit/update_level" method="POST" style="margin: 0; display: flex; gap: 10px; flex-wrap: nowrap; align-items: stretch;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="unit_id" value="<?= htmlspecialchars($unit['id']) ?>">
                    <select name="assessment_level" class="form-control" style="width: auto; height: auto;">
                        <option value="Level 6" <?= $unit['assessment_level'] == 'Level 6' ? 'selected' : '' ?>>Level 6 (40% W / 60% P)</option>
                        <option value="Level 5" <?= $unit['assessment_level'] == 'Level 5' ? 'selected' : '' ?>>Level 5 (30% W / 70% P)</option>
                        <option value="Level 4" <?= $unit['assessment_level'] == 'Level 4' ? 'selected' : '' ?>>Level 4 (10% W / 90% P)</option>
                    </select>
                    <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-weight: 600; white-space: nowrap;">Apply Level</button>
                </form>
            </div>
        </div>

        <!-- Right Pane: Add Form -->
        <div>
            <!-- Stats -->
            <div class="grid-2" style="gap: 15px; margin-bottom: 20px;">
                <div class="card text-center" style="display: flex; flex-direction: column; justify-content: center; padding: 15px;">
                    <h4 style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Curriculum Weight</h4>
                    <div style="font-size: 2rem; font-weight: 800; color: <?= $totalWeight == 100 ? 'var(--success)' : ($totalWeight > 100 ? 'var(--danger)' : 'var(--warning)') ?>; line-height: 1;">
                        <?= number_format($totalWeight, 0) ?>%
                    </div>
                </div>
                <div class="card text-center" style="display: flex; flex-direction: column; justify-content: center; padding: 15px;">
                    <h4 style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Total Topics</h4>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--text-primary); line-height: 1;">
                        <?= count($topics) ?>
                    </div>
                </div>
            </div>

            <!-- Add Form -->
            <div class="card" style="border-top: 4px solid var(--primary); padding: 24px;">
                <h3 style="margin-bottom: 20px; font-size: 1.25rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="plus-circle" style="color: var(--primary);"></i> Add Topic
                </h3>

                <form action="<?= APP_URL ?>/topic/add" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="unit_id" value="<?= htmlspecialchars($unit['id']) ?>">

                    <div class="form-group">
                        <label class="form-label">Topic / Element Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Identify Hardware Components" required>
                    </div>

                    <div class="grid-2" style="gap: 15px;">
                        <div class="form-group m-0">
                            <label class="form-label">Weight (%)</label>
                            <input type="number" name="weight" class="form-control" placeholder="20" min="1" max="100" required>
                        </div>
                        <div class="form-group m-0">
                            <label class="form-label">Sequence #</label>
                            <input type="number" name="sequence_order" class="form-control" value="<?= count($topics) + 1 ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" style="padding: 12px; font-weight: 600; margin-top: 20px; font-size: 1rem;">
                        <i data-feather="save" style="width: 18px;"></i> Save Topic
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>