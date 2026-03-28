<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1200px;">
    <!-- Breadcrumb / Back Navigation -->
    <div style="margin-bottom: 20px;">
        <?php if (($_SESSION['role'] ?? '') === 'Trainer'): ?>
            <a href="<?= APP_URL ?>/dashboard" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
                <i data-feather="arrow-left" style="width: 16px;"></i> Back to Dashboard
            </a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/institution/course/<?= $unit['course_id'] ?>" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
                <i data-feather="arrow-left" style="width: 16px;"></i> Back to Course Overview
            </a>
        <?php endif; ?>
    </div>

    <!-- Header Area -->
    <div style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <span class="badge badge-primary">Assessment Configurator</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;"><?= htmlspecialchars($unit['unit_code']) ?></span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;"><?= htmlspecialchars($unit['unit_title']) ?></h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;">Define the evidence slots that candidates must complete for this competency.</p>
    </div>

    <!-- Active Assessments & Form Layout -->
    <div class="grid-main-side" style="align-items: start; gap: 30px;">

        <!-- Left Pane: Defined Assessments -->
        <div>
            <div class="card" style="padding: 0; overflow: hidden;">
                <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: 10px;">
                    <i data-feather="list" style="color: var(--secondary);"></i>
                    <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary);">Defined Assessment Slots</h3>
                </div>

                <?php if (empty($slots)): ?>
                    <div class="text-center" style="padding: 40px 20px;">
                        <i data-feather="inbox" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                        <p style="color: var(--text-muted); margin: 0;">No assessments defined for this unit yet.<br>Create slots using the configurator.</p>
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column;">
                        <?php foreach ($slots as $i => $s): ?>
                            <div style="padding: 20px; border-bottom: <?= $i === count($slots) - 1 ? 'none' : '1px solid var(--border-color)' ?>; display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; transition: background 0.2s; background: white;" onmouseover="this.style.background='#fbfcfd'" onmouseout="this.style.background='white'">
                                
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 8px;">
                                        <h4 style="margin: 0; font-size: 1.05rem; color: var(--text-primary);"><?= htmlspecialchars($s['title']) ?></h4>
                                        <span class="badge" style="background: #f1f5f9; color: var(--text-muted); border: 1px solid #e2e8f0;"><i data-feather="tag" style="width: 10px; margin-right: 4px;"></i><?= htmlspecialchars($s['type']) ?></span>
                                        
                                        <?php if (!empty($s['topic_title'])): ?>
                                            <span class="badge" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">Topic: <?= htmlspecialchars($s['topic_title']) ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if (isset($s['allow_student_uploads']) && $s['allow_student_uploads'] == 0): ?>
                                            <span class="badge badge-warning" style="display: flex; align-items: center; gap: 4px;"><i data-feather="lock" style="width: 10px;"></i> Trainer Upload Only</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (!empty($s['instructions'])): ?>
                                        <p style="color: var(--secondary); font-size: 0.9rem; margin-bottom: 10px; line-height: 1.5;"><?= nl2br(htmlspecialchars($s['instructions'])) ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($s['file_path'])): ?>
                                        <a href="<?= APP_URL ?>/uploads/assessments/<?= htmlspecialchars($s['file_path']) ?>" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: rgba(37, 99, 235, 0.05); color: var(--primary); border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 500; text-decoration: none; border: 1px solid rgba(37, 99, 235, 0.1);">
                                            <i data-feather="file-text" style="width: 14px;"></i> Question Paper / Guide
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <a href="<?= APP_URL ?>/assessment/delete/<?= $s['id'] ?>" class="btn btn-outline" style="color: var(--danger); border-color: #fca5a5; padding: 6px 10px; font-size: 0.85rem;" onclick="return confirm('WARNING: Are you sure you want to delete this slot? This will unconditionally delete ALL student evidence submissions tied to this specific slot!');" title="Delete Slot">
                                        <i data-feather="trash-2" style="width: 16px;"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Pane: Add Assesment Form -->
        <div>
            <div class="card" style="border-top: 4px solid var(--primary); padding: 24px;">
                <h3 style="margin-bottom: 20px; font-size: 1.25rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="plus-circle" style="color: var(--primary);"></i> Add New Slot
                </h3>

                <form action="<?= APP_URL ?>/assessment/store" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">

                    <div class="form-group">
                        <label class="form-label">Slot Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Practical Project 1" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Topic / Unit Element</label>
                        <select name="topic_id" class="form-control" required>
                            <option value="">Select Topic...</option>
                            <?php foreach ($topics as $t): ?>
                                <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['title']) ?> (Seq: <?= $t['sequence_order'] ?>)</option>
                            <?php endforeach; ?>
                            <option value="">-- General / Covers Entire Unit --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Assessment Type</label>
                        <select name="type" class="form-control" required>
                            <option value="Written">Written Submission</option>
                            <option value="Practical">Practical Demonstration</option>
                            <option value="Observation">Observation Record</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Reference Material (PDF/Image)</label>
                        <input type="file" name="assessment_file" class="form-control" accept=".pdf,.png,.jpg,.jpeg">
                        <small style="color: var(--text-muted); font-size: 0.8rem; display: block; margin-top: 4px;">Optional. Provide the question paper or grading rubric.</small>
                    </div>

                    <div class="form-group" style="background: var(--bg-app); padding: 15px; border-radius: var(--radius-md); border: 1px dashed var(--border-color); margin-top: 20px;">
                        <label style="display: flex; align-items: center; gap: 10px; font-weight: 600; cursor: pointer; color: var(--text-primary); margin-bottom: 6px;">
                            <input type="checkbox" name="allow_student_uploads" value="1" checked style="width: 16px; height: 16px; accent-color: var(--primary);">
                            Allow Student Uploads
                        </label>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0 0 0 26px; line-height: 1.4;">
                            Uncheck this if students cannot upload evidence digitally. If unchecked, Assessors will strictly manage uploads (e.g., photo grading of physical work).
                        </p>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Instructions & Requirements</label>
                        <textarea name="instructions" class="form-control" placeholder="Provide specific criteria the candidate must meet..." style="min-height: 90px; resize: vertical;"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" style="padding: 12px; font-weight: 600; margin-top: 10px; font-size: 1rem;">
                        <i data-feather="save" style="width: 18px;"></i> Create Assessment Slot
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>