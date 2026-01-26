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

        <!-- User List -->
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
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0;">Role</th>
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
                                <a href="<?= APP_URL ?>/users/edit/<?= $u['id'] ?>" class="btn btn-outline"
                                    style="font-size: 0.8rem; padding: 4px 8px;">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

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
                    <select name="role_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                        <?php foreach ($roles as $r): ?>
                            <option value="<?= $r['id'] ?>">
                                <?= htmlspecialchars($r['name']) ?>
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