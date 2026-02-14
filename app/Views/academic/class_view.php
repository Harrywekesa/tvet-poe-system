<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <?php if ($_SESSION['role'] !== 'Trainer'): ?>
            <a href="<?= APP_URL ?>/academic/cohort/<?= $class['cohort_id'] ?>" class="btn btn-outline">&larr; Back to
                Cohort</a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
        <?php endif; ?>
    </div>

    <h1>Class:
        <?= htmlspecialchars($class['class_code']) ?>
    </h1>
    <p class="text-secondary">
        <?= htmlspecialchars($course['title']) ?> (
        <?= htmlspecialchars($course['code']) ?>)
    </p>

    <div class="grid-main-side" style="margin-top: 30px; align-items: start;">

        <!-- Main: Unit Allocations -->
        <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <h3>Unit Allocations</h3>
            <p class="text-secondary" style="font-size: 0.9rem; margin-bottom: 20px;">Assign Trainers and Verifiers to
                units for this class.</p>

            <?php if ($_SESSION['role'] === 'Trainer'): ?>
                <div
                    style="margin-bottom: 20px; padding: 15px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;"
                        onclick="document.getElementById('quick-add-unit').classList.toggle('hidden')">
                        <span style="font-weight: 600; color: #1e40af;">+ Create New Unit & Self Allocate</span>
                        <span style="font-size: 0.8rem;">▼</span>
                    </div>
                    <div id="quick-add-unit" class="hidden" style="margin-top: 15px;">
                        <form action="<?= APP_URL ?>/institution/unit" method="POST"
                            style="display: flex; flex-wrap: wrap; gap: 10px; width: 100%; box-sizing: border-box;">
                            <input type="hidden" name="course_id" value="<?= $class['course_id'] ?>">
                            <input type="hidden" name="context_class_id" value="<?= $class['id'] ?>">

                            <input type="text" name="unit_code" placeholder="Code" required
                                style="flex: 1 1 100px; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                            <input type="text" name="unit_title" placeholder="Title" required
                                style="flex: 2 1 150px; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                            <select name="category"
                                style="flex: 1 1 80px; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                                <option value="Core">Core</option>
                                <option value="Basic">Basic</option>
                                <option value="Common">Common</option>
                            </select>
                            <input type="text" name="description" placeholder="Desc"
                                style="flex: 2 1 120px; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">

                            <button type="submit" class="btn btn-primary"
                                style="flex: 0 0 auto; padding: 8px 16px; font-size: 0.9rem; box-sizing: border-box;">Create</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <div style="margin-bottom: 20px; text-align: right;">
                <a href="<?= APP_URL ?>/review/unit/<?= $units[0]['id'] ?? 0 ?>/<?= $class['id'] ?>"
                    class="btn btn-primary">
                    Review All Evidence
                </a>
                <!-- Ideally this link should be per UNIT in the table below, but for now we link globally or pick one -->
                <!-- Better: Add 'Review' button in the table per row -->
            </div>

            <!-- Responsive Table/Grid -->
            <style>
                /* Desktop Table */
                .allocations-table {
                    width: 100%;
                    border-collapse: collapse;
                }

                .allocations-table th {
                    text-align: left;
                    padding: 10px;
                    border-bottom: 2px solid #e2e8f0;
                    font-size: 0.85rem;
                }

                .allocations-table td {
                    padding: 10px;
                    border-bottom: 1px solid #f1f5f9;
                    vertical-align: middle;
                }

                /* Mobile Cards */
                @media (max-width: 768px) {

                    .allocations-table,
                    .allocations-table thead,
                    .allocations-table tbody,
                    .allocations-table th,
                    .allocations-table td,
                    .allocations-table tr {
                        display: block;
                    }

                    .allocations-table thead {
                        display: none;
                    }

                    .allocations-table tr {
                        margin-bottom: 15px;
                        border: 1px solid #e2e8f0;
                        border-radius: 8px;
                        padding: 15px;
                        background: #f8fafc;
                    }

                    .allocations-table td {
                        border: none;
                        padding: 5px 0;
                        position: relative;
                        padding-left: 0;
                    }

                    .allocations-table td:before {
                        content: attr(data-label);
                        font-weight: 600;
                        display: block;
                        font-size: 0.75rem;
                        color: #64748b;
                        margin-bottom: 2px;
                    }

                    /* Specific adjustments for inputs */
                    .allocations-table select {
                        width: 100%;
                        margin-bottom: 10px;
                    }

                    .allocations-table .actions-cell {
                        display: flex;
                        gap: 10px;
                        margin-top: 10px;
                        border-top: 1px dashed #cbd5e1;
                        padding-top: 10px;
                    }
                }
            </style>

            <table class="allocations-table">
                <thead>
                    <tr>
                        <th style="width: 30%;">Unit</th>
                        <th style="width: 25%;">Trainer</th>
                        <th style="width: 25%;">Verifier (IV)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($units as $u): ?>
                        <tr>
                            <form action="<?= APP_URL ?>/academic/allocate" method="POST">
                                <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
                                <input type="hidden" name="unit_id" value="<?= $u['id'] ?>">

                                <td data-label="Unit">
                                    <div style="font-weight: 600; font-size: 0.95rem; color: #1e293b;">
                                        <?= htmlspecialchars($u['unit_title']) ?>
                                    </div>
                                    <div style="color: #64748b; font-size: 0.8rem; margin-top: 2px;">
                                        <?= htmlspecialchars($u['unit_code']) ?>
                                    </div>
                                </td>

                                <td data-label="Trainer">
                                    <select name="trainer_id"
                                        style="padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.9rem; background: white; width: 100%;">
                                        <option value="">-- Select Trainer --</option>
                                        <?php foreach ($trainers as $t): ?>
                                            <option value="<?= $t['id'] ?>" <?= ($u['trainer_user_id'] ?? '') == $t['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($t['full_name']) ?>
                                                (<?= htmlspecialchars($t['identifier']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <td data-label="Verifier (IV)">
                                    <select name="verifier_id"
                                        style="padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.9rem; background: white; width: 100%;">
                                        <option value="">-- Select IV --</option>
                                        <?php foreach ($verifiers as $v): ?>
                                            <option value="<?= $v['id'] ?>" <?= ($u['verifier_user_id'] ?? '') == $v['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($v['full_name']) ?>
                                                (<?= htmlspecialchars($v['identifier']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <td class="actions-cell" data-label="Actions">
                                    <button type="submit" class="btn btn-primary"
                                        style="padding: 6px 12px; font-size: 0.85rem;">Save</button>

                                    <?php if ($_SESSION['role'] === 'Trainer' && ($u['trainer_user_id'] ?? '') == $_SESSION['user_id']): ?>
                                        <a href="<?= APP_URL ?>/documents/upload?class_id=<?= $class['id'] ?>&unit_id=<?= $u['id'] ?>"
                                            class="btn btn-outline"
                                            style="padding: 6px 12px; font-size: 0.85rem; margin-left: 5px;"
                                            title="Upload Professional Docs (PDF)">
                                            📂 Docs
                                        </a>
                                        <a href="<?= APP_URL ?>/review/unit/<?= $u['id'] ?>/<?= $class['id'] ?>"
                                            class="btn btn-outline"
                                            style="padding: 6px 12px; font-size: 0.85rem; margin-left: 5px;">
                                            Review
                                        </a>
                                    <?php endif; ?>

                                    <?php if (in_array($_SESSION['role'], ['Admin', 'HOD', 'InternalVerifier'])): ?>
                                        <a href="<?= APP_URL ?>/marks/marksheet/<?= $u['id'] ?>/<?= $class['id'] ?>"
                                            class="btn btn-outline"
                                            style="padding: 6px 12px; font-size: 0.85rem; margin-left: 5px;">
                                            Marksheet
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Sidebar: Students -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <h3>Enrolled Students</h3>
                <p class="text-secondary" style="font-size: 0.9rem;">Manage class roster.</p>

                <form action="<?= APP_URL ?>/academic/enroll" method="POST"
                    style="margin-top: 15px; display: flex; flex-direction: column; gap: 10px;">
                    <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
                    <select name="user_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                        <option value="">-- Select Student to Enroll --</option>
                        <?php foreach ($available_students as $s): ?>
                            <option value="<?= $s['id'] ?>">
                                <?= htmlspecialchars($s['full_name']) ?> (
                                <?= htmlspecialchars($s['email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Enroll Student</button>
                </form>

                <div style="margin-top: 15px; border-top: 1px dashed #e2e8f0; padding-top: 15px;">
                    <p style="font-size: 0.85rem; font-weight: 500; margin-bottom: 5px;">Bulk Enrollment (CSV)</p>
                    <form action="<?= APP_URL ?>/academic/import_enrollment" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
                        <input type="file" name="csv_file" required
                            style="font-size: 0.8rem; width: 100%; margin-bottom: 5px;">
                        <div style="display: flex; gap: 5px;">
                            <button type="submit" class="btn btn-primary"
                                style="font-size: 0.8rem; flex: 1; padding: 6px;">Upload</button>
                            <a href="<?= APP_URL ?>/academic/template/enrollment" class="btn btn-outline"
                                style="font-size: 0.8rem; padding: 6px;">Template</a>
                        </div>
                    </form>
                </div>

                <br>
                <input type="text" id="studentSearch" onkeyup="searchList('studentSearch', 'enrolledList')"
                    placeholder="Filter students..."
                    style="width: 100%; padding: 6px; border: 1px solid #e2e8f0; border-radius: 4px; font-size: 0.8rem;">
                <ul id="enrolledList" style="margin-top: 20px; list-style: none; padding: 0;">
                    <?php foreach ($enrolled_students as $est): ?>
                        <li
                            style="padding: 10px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; display: flex; justify-content: space-between;">
                            <span style="display: flex; align-items: center; gap: 10px;">
                                <?= htmlspecialchars($est['full_name']) ?> <span class="text-secondary"
                                    style="font-size:0.85rem;">(<?= htmlspecialchars($est['identifier']) ?>)</span>
                            </span>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($enrolled_students)): ?>
                        <li style="color: #64748b; padding: 10px; font-size: 0.9rem;">No students enrolled.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <h3>Transcripts</h3>
                <p class="text-secondary" style="font-size: 0.9rem; margin-bottom: 15px;">View and print student
                    transcripts.</p>

                <a href="<?= APP_URL ?>/marks/class_transcripts/<?= $class['id'] ?>" class="btn btn-primary"
                    style="width: 100%; text-align: center;">
                    Manage Class Transcripts
                </a>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/../partials/footer.php'; ?>