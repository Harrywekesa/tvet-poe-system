<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" class="btn btn-outline">&larr; Back to Dashboard</a>
    </div>

    <h1>Institution Setup</h1>

    <!-- Tabs for Bulk Actions -->
    <div style="margin-top:20px; margin-bottom: 20px;">
        <details style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px;">
            <summary style="cursor: pointer; font-weight: 600; color: #2563eb;">📂 Bulk Import Data (CSV)</summary>
            <div class="grid-3" style="margin-top: 15px;">

                <!-- Dept Import -->
                <div style="padding: 15px; background: #f8fafc; border-radius: 6px;">
                    <strong>Departments</strong>
                    <p style="font-size: 0.8rem; margin-bottom: 10px;"><a
                            href="<?= APP_URL ?>/institution/template/department" download>Download Template</a></p>
                    <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="department">
                        <input type="file" name="csv_file" required style="font-size: 0.8rem; margin-bottom: 5px;">
                        <button type="submit" class="btn btn-primary"
                            style="font-size: 0.8rem; padding: 4px 8px;">Upload</button>
                    </form>
                </div>

                <!-- Course Import -->
                <div style="padding: 15px; background: #f8fafc; border-radius: 6px;">
                    <strong>Courses</strong>
                    <p style="font-size: 0.8rem; margin-bottom: 10px;"><a
                            href="<?= APP_URL ?>/institution/template/course" download>Download Template</a></p>
                    <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="course">
                        <input type="file" name="csv_file" required style="font-size: 0.8rem; margin-bottom: 5px;">
                        <button type="submit" class="btn btn-primary"
                            style="font-size: 0.8rem; padding: 4px 8px;">Upload</button>
                    </form>
                </div>

                <!-- Unit Import -->
                <div style="padding: 15px; background: #f8fafc; border-radius: 6px;">
                    <strong>Units</strong>
                    <p style="font-size: 0.8rem; margin-bottom: 10px;"><a
                            href="<?= APP_URL ?>/institution/template/unit" download>Download Template</a></p>
                    <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="unit">
                        <input type="file" name="csv_file" required style="font-size: 0.8rem; margin-bottom: 5px;">
                        <button type="submit" class="btn btn-primary"
                            style="font-size: 0.8rem; padding: 4px 8px;">Upload</button>
                    </form>
                </div>

            </div>
        </details>
    </div>

    <div class="grid-2" style="margin-top: 20px;">

        <!-- Details Form -->
        <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <h3>Institution Details</h3>
            <form action="<?= APP_URL ?>/institution/update" method="POST" enctype="multipart/form-data"
                style="margin-top: 20px;">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Institution Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($institution['name'] ?? '') ?>" required
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">TVET / CBET Code</label>
                    <input type="text" name="tvet_code" value="<?= htmlspecialchars($institution['tvet_code'] ?? '') ?>"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Address</label>
                    <textarea name="address"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;"><?= htmlspecialchars($institution['address'] ?? '') ?></textarea>
                </div>

                <hr style="margin: 20px 0; border: 0; border-top: 1px solid #e2e8f0;">

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">System Name</label>
                    <input type="text" name="system_name"
                        value="<?= htmlspecialchars($institution['system_name'] ?? 'CBET POE System') ?>"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">System Logo</label>
                    <?php if (!empty($institution['logo_path'])): ?>
                        <div style="margin-bottom: 5px;">
                            <img src="<?= APP_URL . $institution['logo_path'] ?>" alt="Logo" style="height: 40px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="logo" accept="image/*"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <small style="color: #64748b;">Upload a PNG or JPG (approx 40px height recommended)</small>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Hero Image (Landing Page)</label>
                    <?php if (!empty($institution['hero_image_path'])): ?>
                        <div style="margin-bottom: 5px;">
                            <img src="<?= APP_URL . $institution['hero_image_path'] ?>" alt="Hero"
                                style="height: 80px; width: auto; border-radius: 4px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="hero_image" accept="image/*"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <small style="color: #64748b;">Upload a screenshot or banner for the home page (approx
                        600x400px)</small>
                </div>

                <div class="grid-2">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px;">Contact Email</label>
                        <input type="email" name="contact_email"
                            value="<?= htmlspecialchars($institution['contact_email'] ?? '') ?>"
                            style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px;">Contact Phone</label>
                        <input type="text" name="contact_phone"
                            value="<?= htmlspecialchars($institution['contact_phone'] ?? '') ?>"
                            style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">About / Footer Text</label>
                    <textarea name="about_text" rows="3"
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;"><?= htmlspecialchars($institution['about_text'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Details</button>
            </form>
        </div>

        <!-- Department List -->
        <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <h3>Departments</h3>

            <form action="<?= APP_URL ?>/institution/department" method="POST"
                style="margin-top: 20px; display: flex; gap: 10px;">
                <input type="text" name="name" placeholder="New Department Name" required
                    style="flex: 1; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                <button type="submit" class="btn btn-primary">Add</button>
            </form>

            <div
                style="margin-top: 20px; display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px;">
                <?php foreach ($departments as $dept): ?>
                    <div
                        style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                        <div style="margin-bottom: 15px;">
                            <h4 style="margin: 0; color: #1e293b; font-size: 1.1rem;"><?= htmlspecialchars($dept['name']) ?>
                            </h4>
                        </div>

                        <div
                            style="display: flex; justify-content: space-between; align-items: center; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                            <a href="<?= APP_URL ?>/institution/department/<?= $dept['id'] ?>" class="btn btn-primary"
                                style="font-size: 0.85rem; padding: 6px 12px; background: #0f172a;">Manage Courses</a>

                            <!-- Delete Button -->
                            <form action="<?= APP_URL ?>/institution/department/delete" method="POST"
                                style="display: inline-block;"
                                onsubmit="return confirm('Are you sure? This will delete the department.');">
                                <input type="hidden" name="id" value="<?= $dept['id'] ?>">
                                <button type="submit" class="btn btn-outline"
                                    style="padding: 6px 10px; font-size: 0.85rem; border-color: #ef4444; color: #ef4444;"
                                    title="Delete Department">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($departments)): ?>
                    <div style="grid-column: 1 / -1; color: #64748b; padding: 10px; text-align: center;">No departments
                        found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>