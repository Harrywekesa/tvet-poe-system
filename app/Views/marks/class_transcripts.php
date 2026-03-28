<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1000px;">
    <div class="flex-between align-center" style="margin-bottom: 24px;">
        <div>
            <h1 class="page-title">Transcripts: <?= htmlspecialchars($class['class_code']) ?></h1>
            <p class="text-muted">Manage and print student transcripts.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <?= component('button', ['href' => APP_URL . "/academic/class/{$class['id']}", 'label' => '&larr; Back to Class', 'variant' => 'outline']) ?>
            <?= component('button', ['href' => APP_URL . '/marks/transcripts', 'label' => '&larr; Transcripts Hub', 'variant' => 'outline']) ?>
        </div>
    </div>

    <!-- Controls -->
    <div class="grid-2" style="gap: 20px; margin-bottom: 24px;">
        <div class="card">
            <h3 style="margin-bottom: 15px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                <i data-feather="filter" style="width: 18px; color: var(--primary);"></i> Switch Class
            </h3>
            <div class="form-group" style="margin: 0;">
                <select id="classSelector" class="form-control" onchange="window.location.href='<?= APP_URL ?>/marks/class_transcripts/' + this.value">
                    <?php foreach ($allClasses as $c): ?>
                        <option value="<?= htmlspecialchars($c['id']) ?>" <?= $c['id'] == $class['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['class_code']) ?> - <?= htmlspecialchars($c['course_title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 15px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                <i data-feather="printer" style="width: 18px; color: var(--info);"></i> Bulk Actions
            </h3>
            <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 15px;">Generate continuous PDFs.</p>
            <div style="display: flex; gap: 10px;">
                <?= component('button', ['href' => APP_URL . "/marks/bulk_transcript/{$class['id']}?type=raw", 'label' => 'Generate All (Raw)', 'variant' => 'outline', 'class' => 'w-100', 'attrs' => 'target="_blank"']) ?>
                <?= component('button', ['href' => APP_URL . "/marks/bulk_transcript/{$class['id']}?type=weighted", 'label' => 'Generate All (Weighted)', 'class' => 'w-100', 'attrs' => 'target="_blank"']) ?>
            </div>
        </div>
    </div>

    <!-- Student List -->
    <div class="card">
        <h3 style="margin-bottom: 5px;">Student Transcript List</h3>
        <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 20px;">Select a student to view or print their individual final marksheet record.</p>

        <?php if (empty($students)): ?>
            <div class="text-center text-muted" style="padding: 40px; background: var(--bg-app); border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
                <i data-feather="users" style="width: 40px; height: 40px; color: #cbd5e1; margin-bottom: 15px;"></i>
                <p style="margin: 0;">No students enrolled in this class.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Name</th>
                            <th style="width: 30%;">Identifier</th>
                            <th style="width: 30%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $s): ?>
                            <tr>
                                <td>
                                    <strong style="color: var(--text-primary); font-size: 0.95rem;">
                                        <?= htmlspecialchars($s['full_name']) ?>
                                    </strong>
                                </td>
                                <td>
                                    <span style="font-size: 0.85rem; background: var(--bg-app); padding: 4px 8px; border-radius: 4px; color: var(--text-muted); font-family: monospace;">
                                        <?= htmlspecialchars($s['identifier']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 10px;">
                                        <?= component('button', ['href' => APP_URL . "/marks/transcript/{$s['id']}?type=raw", 'label' => 'Raw PDF', 'variant' => 'outline', 'attrs' => 'target="_blank"']) ?>
                                        <?= component('button', ['href' => APP_URL . "/marks/transcript/{$s['id']}?type=weighted", 'label' => 'Weighted PDF', 'attrs' => 'target="_blank"']) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>