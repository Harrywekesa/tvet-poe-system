<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/users" class="btn btn-outline">&larr; Back to Users</a>
    </div>

    <h1>Import Users</h1>
    <p class="text-secondary">Bulk upload users via CSV.</p>

    <div class="grid-main-side" style="margin-top: 20px;">
        <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <h3>Step 1: Download Template</h3>
            <p style="margin-bottom: 20px; font-size: 0.9rem; color: #64748b;">Use this template to ensure your data is
                formatted correctly.</p>
            <a href="<?= APP_URL ?>/users/template" class="btn btn-outline"
                style="display: flex; align-items: center; gap: 8px; width: fit-content;">
                <span>📄</span> Download CSV Template
            </a>

            <h3 style="margin-top: 30px;">Step 2: Upload CSV</h3>
            <form action="<?= APP_URL ?>/users/import" method="POST" enctype="multipart/form-data"
                style="margin-top: 15px;">
    <?= csrf_field() ?>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Select File</label>
                    <input type="file" name="csv_file" accept=".csv" required
                        style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>
                <!-- Default password note -->
                <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 15px;">Default password for all imported
                    users will be <strong>cbet1234</strong>.</p>
                <div
                    style="margin-bottom: 15px; padding: 10px; background: #fff7ed; border: 1px solid #ffedd5; border-radius: 4px; font-size: 0.85rem; color: #c2410c;">
                    <strong>Note for Students:</strong> Importing students here only creates their accounts. To assign
                    them to a class/cohort, please use the <strong>Academic Manager > Class View</strong> bulk
                    enrollment.
                </div>

                <button type="submit" class="btn btn-primary">Import Users</button>
            </form>
        </div>

        <div style="background: #f8fafc; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <h4>Instructions</h4>
            <ul
                style="font-size: 0.9rem; padding-left: 20px; color: #475569; display: flex; flex-direction: column; gap: 8px; margin-top: 10px;">
                <li><strong>Full Name</strong>: Required.</li>
                <li><strong>Email</strong>: Required, must be unique.</li>
                <li><strong>Role</strong>: Must match exactly: 'Admin', 'Trainer', 'InternalVerifier', 'HOD', or
                    'Student'. Case sensitive.</li>
                <li><strong>Identifier</strong>: Optional. Reg No or PF No.</li>
                <li><strong>Phone</strong>: Optional.</li>
            </ul>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>