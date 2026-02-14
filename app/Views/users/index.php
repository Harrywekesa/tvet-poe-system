<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="margin: 0;">User Management</h1>
        <a href="<?= APP_URL ?>/users/import" class="btn btn-primary" style="background: #22c55e;">Import CSV</a>
    </div>
    <p class="text-secondary">Create and manage institutional users.</p>

    <div class="grid-main-side" style="margin-top: 20px;">

        <!-- HOD Team View -->
        <?php if (!empty($team_trainers) || !empty($team_students) || ($_SESSION['role'] === 'HOD')): ?>

            <div style="display: flex; gap: 20px; flex-direction: column;">

                <!-- Trainers Section -->
                <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h3>Trainers & Allocations</h3>
                    <?php if (empty($team_trainers)): ?>
                        <p class="text-secondary">No trainers found with allocations in your department.</p>
                    <?php else: ?>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                            <thead>
                                <tr style="background: #f8fafc; text-align: left;">
                                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Trainer Name</th>
                                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Class (Course)</th>
                                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Units Allocated</th>
                                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($team_trainers as $t): ?>
                                    <tr>
                                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                            <strong><?= htmlspecialchars($t['full_name']) ?></strong><br>
                                            <span
                                                style="font-size:0.8rem; color:#64748b;"><?= htmlspecialchars($t['email']) ?></span>
                                        </td>
                                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                            <span
                                                style="background: #e0f2fe; color: #0284c7; padding: 2px 6px; border-radius: 4px; font-weight:bold;">
                                                <?= htmlspecialchars($t['class_code']) ?>
                                            </span>
                                        </td>
                                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                            <?= htmlspecialchars($t['units']) ?>
                                        </td>
                                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                            <a href="<?= APP_URL ?>/users/edit/<?= $t['id'] ?>"
                                                class="btn btn-outline btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>

                <!-- Students Section -->
                <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h3>Students & Units</h3>
                    <?php if (empty($team_students)): ?>
                        <p class="text-secondary">No students enrolled in your department's classes.</p>
                    <?php else: ?>
                        <!-- Simple Client Search for Students -->
                        <input type="text" id="studentScan" onkeyup="searchTable('studentScan', 'studentTable')"
                            placeholder="Search students..."
                            style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #cbd5e1; border-radius: 4px;">

                        <table id="studentTable" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f8fafc; text-align: left;">
                                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Student Details</th>
                                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Class</th>
                                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Units Taking (Course Units)
                                    </th>
                                    <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($team_students as $s): ?>
                                    <tr>
                                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                            <strong><?= htmlspecialchars($s['full_name']) ?></strong><br>
                                            <span
                                                style="font-size:0.8rem; color:#64748b;"><?= htmlspecialchars($s['identifier']) ?></span>
                                        </td>
                                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                            <?= htmlspecialchars($s['class_code']) ?>
                                        </td>
                                        <td
                                            style="padding: 10px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; color: #475569;">
                                            <?= htmlspecialchars($s['units']) ?>
                                        </td>
                                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                            <a href="<?= APP_URL ?>/users/edit/<?= $s['id'] ?>"
                                                class="btn btn-outline btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>
            <!-- Fallback / Admin Generic View -->
            <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <h3>All Users</h3>
                <input type="text" id="userScan" onkeyup="searchTable('userScan', 'userTable')"
                    placeholder="Search users by name, email or role..."
                    style="width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #cbd5e1; border-radius: 4px;">
                <table id="userTable" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead>
                        <tr style="background: #f8fafc; text-align: left;">
                            <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Name</th>
                            <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Role</th>
                            <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">ID / Reg No</th>
                            <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Email</th>
                            <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Status</th>
                            <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                    <strong><?= htmlspecialchars($u['full_name']) ?></strong>
                                </td>
                                <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; color: #64748b;">
                                    <?= htmlspecialchars($u['role_name']) ?>
                                </td>
                                <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-size: 0.9rem;">
                                    <?= htmlspecialchars($u['dept_name'] ?? '-') ?>
                                </td>
                                <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                    <?= htmlspecialchars($u['identifier'] ?? '-') ?>
                                </td>
                                <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                    <?= htmlspecialchars($u['email']) ?>
                                </td>
                                <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                    <?php if ($u['is_active']): ?>
                                        <span
                                            style="background: #dcfce7; color: #166534; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem;">Active</span>
                                    <?php else: ?>
                                        <span
                                            style="background: #fee2e2; color: #991b1b; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; cursor:help;"
                                            title="<?= htmlspecialchars($u['suspension_reason'] ?? 'No reason') ?>">Suspended</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                    <a href="<?= APP_URL ?>/users/edit/<?= $u['id'] ?>" class="btn btn-outline"
                                        style="font-size: 0.8rem; padding: 4px 8px;">Edit</a>

                                    <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                        <?php if ($u['is_active']): ?>
                                            <button onclick="openSuspendModal(<?= $u['id'] ?>)" class="btn btn-outline"
                                                style="font-size: 0.8rem; padding: 4px 8px; color: #d97706; border-color: #d97706;">Suspend</button>
                                        <?php else: ?>
                                            <a href="<?= APP_URL ?>/users/activate/<?= $u['id'] ?>" class="btn btn-outline"
                                                style="font-size: 0.8rem; padding: 4px 8px; color: #166534; border-color: #166534;">Activate</a>
                                        <?php endif; ?>

                                        <a href="<?= APP_URL ?>/users/delete/<?= $u['id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this user? This cannot be undone.');"
                                            class="btn btn-outline"
                                            style="font-size: 0.8rem; padding: 4px 8px; color: #dc2626; border-color: #dc2626; margin-left: 5px;">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- Add User Form -->
        <div
            style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; height: fit-content;">
            <h3>Create New User</h3>
            <form action="<?= APP_URL ?>/users/store" method="POST" style="margin-top: 20px;">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Full Name</label>
                    <input type="text" name="full_name" required
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Email Address</label>
                    <input type="email" name="email" required
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Identifier (Reg No / PF No)</label>
                    <input type="text" name="identifier" required placeholder="e.g. ST/001/24 or PF-10293"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Role</label>
                    <select name="role_id" required onchange="toggleDept(this)"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                        <?php foreach ($roles as $r): ?>
                            <option value="<?= $r['id'] ?>">
                                <?= htmlspecialchars($r['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="deptField" style="margin-bottom: 15px; display: none;">
                    <label style="display: block; margin-bottom: 5px;">Department (Optional)</label>
                    <select name="department_id"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                        <option value="">Select Department...</option>
                        <?php
                        // Quick fetch for view
                        $deptModel = new \App\Models\InstitutionModel();
                        $depts = $deptModel->getAllDepartments();
                        foreach ($depts as $d):
                            ?>
                            <option value="<?= $d['id'] ?>">
                                <?= htmlspecialchars($d['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <script>
                    function toggleDept(select) {
                        const text = select.options[select.selectedIndex].text;
                        // Trainers and HODs usually need departments. Students might too for filters.
                        // Let's just show it for everyone or specific roles?
                        // User request: "assigning the new user to a department".
                        // Let's show it always, or maybe hide for Admin?
                        // Actually, simplified: Show it always for now, or just logic.
                        document.getElementById('deptField').style.display = 'block';
                    }
                    // Run on load
                    document.addEventListener('DOMContentLoaded', function () {
                        toggleDept(document.querySelector('select[name="role_id"]'));
                    });
                </script>

                <div id="classField" style="margin-bottom: 15px; display: none;">
                    <label style="display: block; margin-bottom: 5px;">Class (For Students)</label>
                    <select name="class_id"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                        <option value="">Select Class...</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?= $c['id'] ?>">
                                <?= htmlspecialchars($c['class_code']) ?> (<?= htmlspecialchars($c['course_title']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px;">Initial Password</label>
                    <input type="text" name="password" value="cbet1234" required
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Create User</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>

<!-- Scripts -->
<script>
    function toggleDept(select) {
        const text = select.options[select.selectedIndex].text;
        
        // Show Dept for everyone (or specific logic)
        document.getElementById('deptField').style.display = 'block';

        // Show Class ONLY for Students
        const classDiv = document.getElementById('classField');
        if (text.includes('Student')) {
            classDiv.style.display = 'block';
        } else {
            classDiv.style.display = 'none';
        }
    }
    // Run on load
    document.addEventListener('DOMContentLoaded', function() {
        toggleDept(document.querySelector('select[name="role_id"]'));
    });
</script>

<!-- Suspend Modal -->
<div id="suspendModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 8px; width: 400px; max-width: 90%;">
        <h3>Suspend User</h3>
        <p>Please provide a reason for suspending this user.</p>
        <form action="<?= APP_URL ?>/users/suspend" method="POST">
            <input type="hidden" name="user_id" id="suspendUserId">
            <textarea name="reason" rows="3" required placeholder="Reason for suspension..."
                style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; margin-bottom: 20px;"></textarea>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeSuspendModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #d97706;">Suspend User</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openSuspendModal(userId) {
        document.getElementById('suspendUserId').value = userId;
        document.getElementById('suspendModal').style.display = 'flex';
    }

    function closeSuspendModal() {
        document.getElementById('suspendModal').style.display = 'none';
    }

    // Close on outside click
    window.onclick = function (event) {
        var modal = document.getElementById('suspendModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>