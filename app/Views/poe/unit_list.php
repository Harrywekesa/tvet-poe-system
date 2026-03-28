<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1200px;">
    
    <!-- Breadcrumb -->
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/poe/dashboard" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i data-feather="arrow-left" style="width: 16px;"></i> Return to POE Gateway
        </a>
    </div>

    <div style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <span class="badge badge-primary">Curriculum Structure</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;"><?= htmlspecialchars($class['class_code']) ?></span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;">Manage Class Evidence</h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;">Select a specific curriculum unit to upload required photographic or documentary evidence.</p>
    </div>

    <div class="card" style="padding: 24px; border-top: 4px solid var(--secondary); background: #f8fafc;">
        <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.25rem; display: flex; align-items: center; gap: 8px;">
            <i data-feather="layers" style="color: var(--secondary);"></i> Attached Curriculum Units
        </h3>

        <?php if (empty($units)): ?>
            <div class="text-center text-muted" style="padding: 60px 20px; background: white; border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
                <i data-feather="inbox" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                <p style="margin: 0; font-size: 1.05rem;">No units found for this specific organizational class.</p>
                <p style="font-size: 0.85rem; color: #94a3b8; margin-top: 5px;">Your Department Head may need to link units to your Course framework.</p>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                <?php foreach ($units as $u): ?>
                    <div class="card popup-card" style="padding: 20px; transition: transform 0.2s, border-color 0.2s; display: flex; flex-direction: column; justify-content: space-between; border: 1px solid var(--border-color); background: white; cursor: pointer;"
                         onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-2px)';" 
                         onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='translateY(0)';">
                        
                        <div style="margin-bottom: 25px;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(37,99,235,0.05); display: flex; align-items: center; justify-content: center; color: var(--secondary);">
                                    <i data-feather="bookmark" style="width: 16px;"></i>
                                </div>
                                <span style="font-size: 0.85rem; font-family: monospace; background: var(--bg-app); padding: 4px 8px; border-radius: 4px; color: var(--text-muted); border: 1px solid var(--border-color);">
                                    <?= htmlspecialchars($u['unit_code']) ?>
                                </span>
                            </div>
                            <h4 style="margin: 0; font-size: 1.15rem; color: var(--text-primary); font-weight: 700; margin-bottom: 6px; line-height: 1.4;">
                                <?= htmlspecialchars($u['unit_title']) ?>
                            </h4>
                        </div>
                        
                        <div>
                            <?= component('button', [
                                'href' => APP_URL . "/poe/unit/{$u['id']}", 
                                'label' => 'Upload Evidence', 
                                'variant' => 'primary', 
                                'class' => 'w-100',
                                'icon' => 'upload-cloud'
                            ]) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>