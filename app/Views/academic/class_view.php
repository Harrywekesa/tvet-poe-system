<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4">
    <div class="flex-between align-center" style="margin-bottom: 24px;">
        <div>
            <h1 class="page-title">Class: <?= htmlspecialchars($class['class_code']) ?></h1>
            <p class="text-muted"><?= htmlspecialchars($course['title']) ?> (<?= htmlspecialchars($course['code']) ?>)</p>
        </div>
        <div>
            <?php if ($_SESSION['role'] !== 'Trainer'): ?>
                <?= component('button', ['href' => APP_URL . "/academic/cohort/{$class['cohort_id']}", 'label' => '&larr; Back to Cohort', 'variant' => 'outline']) ?>
            <?php else: ?>
                <?= component('button', ['href' => APP_URL . '/dashboard', 'label' => '&larr; Back to Dashboard', 'variant' => 'outline']) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid-main-side" style="align-items: start;">

        <!-- Main: Unit Allocations -->
        <div class="card">
            <div class="flex-between align-center" style="margin-bottom: 20px;">
                <div>
                    <h3 style="margin: 0;">Unit Allocations</h3>
                    <p class="text-muted" style="font-size: 0.9rem; margin-top: 5px;">Assign Trainers and Verifiers to units for this class.</p>
                </div>
                <div>
                    <a href="<?= APP_URL ?>/review/unit/<?= htmlspecialchars($units[0]['id'] ?? 0) ?>/<?= htmlspecialchars($class['id']) ?>" class="btn btn-primary">
                        Review All Evidence
                    </a>
                </div>
            </div>

            <?php if ($_SESSION['role'] === 'Trainer'): ?>
                <div style="margin-bottom: 24px; padding: 15px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: var(--radius-md);">
                    <div style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;" onclick="document.getElementById('quick-add-unit').classList.toggle('hidden')">
                        <span style="font-weight: 600; color: #1e40af;"><i data-feather="plus-circle" style="width:16px; margin-right:5px; vertical-align:-3px;"></i> Create New Unit & Self Allocate</span>
                        <span style="font-size: 0.8rem; color: #1e40af;">Toggle ▼</span>
                    </div>
                    <div id="quick-add-unit" class="hidden" style="margin-top: 20px;">
                        <form action="<?= APP_URL ?>/institution/unit" method="POST" class="grid-4" style="align-items: end; gap: 10px;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="course_id" value="<?= htmlspecialchars($class['course_id']) ?>">
                            <input type="hidden" name="context_class_id" value="<?= htmlspecialchars($class['id']) ?>">

                            <?= component('input', ['name' => 'unit_code', 'label' => 'Code', 'placeholder' => 'Code', 'required' => true]) ?>
                            <?= component('input', ['name' => 'unit_title', 'label' => 'Title', 'placeholder' => 'Title', 'required' => true]) ?>
                            
                            <div class="form-group" style="margin: 0;">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-control" required>
                                    <option value="Core">Core</option>
                                    <option value="Basic">Basic</option>
                                    <option value="Common">Common</option>
                                </select>
                            </div>
                            
                            <?= component('button', ['type' => 'submit', 'label' => 'Create Unit', 'class' => 'w-100']) ?>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table" style="min-width: 800px;">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Unit</th>
                            <th style="width: 20%;">Trainer</th>
                            <th style="width: 20%;">Verifier (IV)</th>
                            <th style="width: 35%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($units as $u): ?>
                            <tr>
                                <form action="<?= APP_URL ?>/academic/allocate" method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="class_id" value="<?= htmlspecialchars($class['id']) ?>">
                                    <input type="hidden" name="unit_id" value="<?= htmlspecialchars($u['id']) ?>">

                                    <td>
                                        <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">
                                            <?= htmlspecialchars($u['unit_title']) ?>
                                        </div>
                                        <span style="font-size: 0.8rem; color: var(--text-muted); background: var(--bg-app); padding: 2px 6px; border-radius: 4px;">
                                            <?= htmlspecialchars($u['unit_code']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <select name="trainer_id" class="form-control" style="font-size: 0.9rem;">
                                            <option value="">-- Select Trainer --</option>
                                            <?php foreach ($trainers as $t): ?>
                                                <option value="<?= htmlspecialchars($t['id']) ?>" <?= ($u['trainer_user_id'] ?? '') == $t['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($t['full_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>

                                    <td>
                                        <select name="verifier_id" class="form-control" style="font-size: 0.9rem;">
                                            <option value="">-- Select IV --</option>
                                            <?php foreach ($verifiers as $v): ?>
                                                <option value="<?= htmlspecialchars($v['id']) ?>" <?= ($u['verifier_user_id'] ?? '') == $v['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($v['full_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>

                                    <td>
                                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                            <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.85rem;">Save</button>

                                            <?php if ($_SESSION['role'] === 'Trainer' && ($u['trainer_user_id'] ?? '') == $_SESSION['user_id']): ?>
                                                <a href="<?= APP_URL ?>/documents/upload?class_id=<?= htmlspecialchars($class['id']) ?>&unit_id=<?= htmlspecialchars($u['id']) ?>" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem;" title="Upload Professional Docs (PDF)">
                                                    📂 Docs
                                                </a>
                                                <a href="<?= APP_URL ?>/review/unit/<?= htmlspecialchars($u['id']) ?>/<?= htmlspecialchars($class['id']) ?>" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem;">
                                                    Review
                                                </a>
                                            <?php endif; ?>

                                            <?php if (in_array($_SESSION['role'], ['Admin', 'HOD', 'InternalVerifier'])): ?>
                                                <a href="<?= APP_URL ?>/marks/marksheet/<?= htmlspecialchars($u['id']) ?>/<?= htmlspecialchars($class['id']) ?>" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem;">
                                                    Marksheet
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar: Students & Actions -->
        <div>
            <!-- Transcripts Shortcut -->
            <div class="card" style="margin-bottom: 20px;">
                <h3 style="margin-bottom: 10px;">Transcripts</h3>
                <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 20px;">View and print student transcripts.</p>
                <?= component('button', ['href' => APP_URL . "/marks/class_transcripts/{$class['id']}", 'label' => 'Manage Class Transcripts', 'class' => 'w-100']) ?>
            </div>

            <!-- Enrolled Students -->
            <div class="card">
                <h3 style="margin-bottom: 5px;">Enrolled Students</h3>
                <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 20px;">Manage class roster.</p>

                <form action="<?= APP_URL ?>/academic/enroll" method="POST" style="margin-bottom: 20px;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="class_id" value="<?= htmlspecialchars($class['id']) ?>">
                    <div class="form-group">
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Select Student to Enroll --</option>
                            <?php foreach ($available_students as $s): ?>
                                <option value="<?= htmlspecialchars($s['id']) ?>">
                                    <?= htmlspecialchars($s['full_name']) ?> (<?= htmlspecialchars($s['email']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?= component('button', ['type' => 'submit', 'label' => 'Enroll Student', 'class' => 'w-100']) ?>
                </form>

                <div style="border-top: 1px dashed var(--border-color); padding-top: 20px; margin-bottom: 20px;">
                    <p style="font-size: 0.85rem; font-weight: 600; margin-bottom: 15px; color: var(--text-primary);">Bulk Enrollment (CSV)</p>
                    <form action="<?= APP_URL ?>/academic/import_enrollment" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="class_id" value="<?= htmlspecialchars($class['id']) ?>">
                        <input type="file" name="csv_file" required style="font-size: 0.85rem; width: 100%; margin-bottom: 15px; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
                        
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 8px; font-size: 0.9rem;">Upload</button>
                            <a href="<?= APP_URL ?>/academic/template/enrollment" class="btn btn-outline" style="flex: 1; padding: 8px; font-size: 0.9rem; text-align: center;">Template</a>
                        </div>
                    </form>
                </div>

                <div style="margin-bottom: 15px;">
                    <input type="text" id="studentSearch" onkeyup="searchList('studentSearch', 'enrolledList')" placeholder="Filter students..." class="form-control" style="font-size: 0.85rem; padding: 8px 12px;">
                </div>

                <ul id="enrolledList" style="list-style: none; padding: 0; margin: 0; max-height: 400px; overflow-y: auto;">
                    <?php foreach ($enrolled_students as $est): ?>
                        <li style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-size: 0.9rem;">
                            <span style="font-weight: 500; color: var(--text-primary); display: block; margin-bottom: 2px;">
                                <?= htmlspecialchars($est['full_name']) ?>
                            </span>
                            <span style="color: var(--text-muted); font-size: 0.8rem; background: var(--bg-app); padding: 2px 6px; border-radius: 4px;">
                                <?= htmlspecialchars($est['identifier']) ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($enrolled_students)): ?>
                        <li style="color: var(--text-muted); padding: 20px 0; text-align: center; font-size: 0.9rem;">No students enrolled.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.hidden { display: none !important; }
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>