<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px; max-width: 600px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Dashboard</a>
    </div>

    <h1>My Profile</h1>
    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <form action="<?= APP_URL ?>/profile/update" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
                <div
                    style="width: 80px; height: 80px; background: #e2e8f0; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <?php if (!empty($user['profile_picture'])): ?>
                        <img src="<?= APP_URL ?>/uploads/profile/<?= htmlspecialchars($user['profile_picture']) ?>"
                            alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <span style="font-size: 2rem; color: #64748b;">👤</span>
                    <?php endif; ?>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-size: 0.9rem;">Change Photo</label>
                    <input type="file" name="profile_picture" accept="image/*" style="font-size: 0.9rem;">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #64748b;">Identifier (Reg No / PF No)</label>
                <input type="text" value="<?= htmlspecialchars($user['identifier'] ?? 'Not Set') ?>" disabled
                    style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fafc; color: #94a3b8;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #64748b;">Full Name</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #64748b;">Phone Number</label>
                <input type="text" name="phone_number" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>"
                    placeholder="e.g. +254..."
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #64748b;">Email Address</label>
                <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled
                    style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fafc; color: #94a3b8;">
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 5px;">Email cannot be changed.</p>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #64748b;">Role</label>
                <input type="text" value="<?= htmlspecialchars($user['role_name']) ?>" disabled
                    style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fafc; color: #94a3b8;">
            </div>

            <?php if (!empty($user['dept_name'])): ?>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Department</label>
                    <input type="text" value="<?= htmlspecialchars($user['dept_name']) ?>" disabled
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fafc; color: #94a3b8;">
                </div>
            <?php endif; ?>

            <?php if (!empty($classes)): ?>
                <div
                    style="margin-bottom: 15px; background: #f0f9ff; padding: 15px; border-radius: 6px; border: 1px solid #bae6fd;">
                    <label style="display: block; margin-bottom: 10px; color: #0369a1; font-weight: 600;">Academic
                        Enrollment</label>
                    <?php foreach ($classes as $c): ?>
                        <div style="margin-bottom: 8px; font-size: 0.9rem;">
                            <span style="font-weight: 600; color: #0284c7;"><?= htmlspecialchars($c['class_code']) ?></span>
                            <span style="color: #64748b;"> - <?= htmlspecialchars($c['course_title']) ?>
                                (<?= htmlspecialchars($c['course_code']) ?>)</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">

            <h4 style="margin-bottom: 15px;">Change Password</h4>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">New Password (Optional)</label>
                <input type="password" name="password" placeholder="Leave blank to keep current"
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Update Profile</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>