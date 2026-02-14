<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/users" class="btn btn-outline">&larr; Back to Users</a>
    </div>

    <h1>Edit User</h1>

    <div style="background: white; padding: 30px; border-radius: 8px; border: 1px solid #e2e8f0; max-width: 600px;">
        <form action="<?= APP_URL ?>/users/update" method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Full Name</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Email Address</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Identifier (Reg No / PF No)</label>
                <input type="text" name="identifier" value="<?= htmlspecialchars($user['identifier'] ?? '') ?>"
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Role</label>
                <select name="role_id" required
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= $user['role_id'] == $r['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Department (Optional)</label>
                <!-- We need to fetch departments in controller first -->
                <select name="department_id"
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <option value="">-- None --</option>
                    <?php if (isset($departments)): ?>
                        <?php foreach ($departments as $d): ?>
                            <option value="<?= $d['id'] ?>" <?= ($user['department_id'] ?? '') == $d['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($d['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Enroll in Class (Optional)</label>
                <select name="class_id"
                    style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <option value="">-- Select Class to Enroll --</option>
                    <?php foreach ($classes as $c): ?>
                        <option value="<?= $c['id'] ?>">
                            <?= htmlspecialchars($c['class_code']) ?> (<?= htmlspecialchars($c['course_title']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <p style="font-size: 0.8rem; color: #64748b; margin-top: 5px;">
                    Note: Selecting a class will add a new enrollment. It does not remove existing enrollments.
                </p>
            </div>

            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                <h4 style="margin: 0 0 15px 0;">Authentication & Security</h4>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Reset Password (Optional)</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current password"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" name="force_change" id="force_change" value="1"
                        <?= $user['must_change_password'] ? 'checked' : '' ?>>
                    <label for="force_change" style="cursor: pointer;">Force Password Change on Next Login</label>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>