<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <h1>Dataset Management</h1>
    <p class="text-secondary">Centralized hub for bulk importing data into the system.</p>

    <div class="grid-2" style="margin-top: 30px;">

        <!-- Institution Data -->
        <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <h3 style="display: flex; align-items: center; gap: 10px;">
                🏛️ Institution Data
            </h3>
            <p class="text-secondary" style="font-size: 0.9rem; margin-bottom: 20px;">Departments, Courses, and Units.
            </p>

            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div style="padding: 15px; background: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0;">
                    <strong>Departments</strong>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <a href="<?= APP_URL ?>/institution/template/department"
                            style="font-size: 0.85rem; color: #64748b;">Download Template</a>
                        <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data"
                            style="display: flex; gap: 5px;">
                            <input type="hidden" name="type" value="department">
                            <input type="file" name="csv_file" required style="font-size: 0.8rem; width: 180px;">
                            <button type="submit" class="btn btn-primary"
                                style="padding: 4px 10px; font-size: 0.8rem;">Upload</button>
                        </form>
                    </div>
                </div>

                <div style="padding: 15px; background: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0;">
                    <strong>Courses</strong>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <a href="<?= APP_URL ?>/institution/template/course"
                            style="font-size: 0.85rem; color: #64748b;">Download Template</a>
                        <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data"
                            style="display: flex; gap: 5px;">
                            <input type="hidden" name="type" value="course">
                            <input type="file" name="csv_file" required style="font-size: 0.8rem; width: 180px;">
                            <button type="submit" class="btn btn-primary"
                                style="padding: 4px 10px; font-size: 0.8rem;">Upload</button>
                        </form>
                    </div>
                </div>

                <div style="padding: 15px; background: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0;">
                    <strong>Units</strong>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <a href="<?= APP_URL ?>/institution/template/unit"
                            style="font-size: 0.85rem; color: #64748b;">Download Template</a>
                        <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data"
                            style="display: flex; gap: 5px;">
                            <input type="hidden" name="type" value="unit">
                            <input type="file" name="csv_file" required style="font-size: 0.8rem; width: 180px;">
                            <button type="submit" class="btn btn-primary"
                                style="padding: 4px 10px; font-size: 0.8rem;">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- User & Academic Data -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <h3 style="display: flex; align-items: center; gap: 10px;">
                    👥 User Management
                </h3>
                <p class="text-secondary" style="font-size: 0.9rem; margin-bottom: 20px;">Bulk create users (Students,
                    Trainers, etc).</p>

                <div style="padding: 15px; background: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0;">
                    <strong>All Users</strong>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <a href="<?= APP_URL ?>/users/template" style="font-size: 0.85rem; color: #64748b;">Download
                            Template</a>
                        <form action="<?= APP_URL ?>/users/import" method="POST" enctype="multipart/form-data"
                            style="display: flex; gap: 5px;">
                            <input type="file" name="csv_file" required style="font-size: 0.8rem; width: 180px;">
                            <button type="submit" class="btn btn-primary"
                                style="padding: 4px 10px; font-size: 0.8rem;">Upload</button>
                        </form>
                    </div>
                </div>
            </div>

            <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <h3 style="display: flex; align-items: center; gap: 10px;">
                    🎓 Class Enrollment
                </h3>
                <p class="text-secondary" style="font-size: 0.9rem; margin-bottom: 20px;">To bulk enroll students, you
                    must first select a Class.</p>

                <a href="<?= APP_URL ?>/academic" class="btn btn-primary" style="width: 100%; text-align: center;">Go to
                    Class Management</a>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>