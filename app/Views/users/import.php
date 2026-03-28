<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1200px;">
    
    <!-- Breadcrumb -->
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/users" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i data-feather="arrow-left" style="width: 16px;"></i> Back to User Directory
        </a>
    </div>

    <!-- Header Block -->
    <div style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <span class="badge badge-primary">Security & Compliance</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;">Admin Privileges</span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;">Mass Provisioning Engine</h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;">Bulk initialize student, faculty, and administrative profiles into the system schema via CSV.</p>
    </div>

    <div class="grid-main-side" style="align-items: start; gap: 30px;">
        
        <!-- Left Pane: Implementation Upload -->
        <div>
            <div class="card" style="padding: 24px; border-top: 4px solid var(--primary); margin-bottom: 24px;">
                <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.25rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="upload-cloud" style="color: var(--primary);"></i> Secure Payload Injector
                </h3>

                <p style="font-size: 0.95rem; color: var(--text-secondary); margin-bottom: 20px; line-height: 1.6;">Use the validated `<span style="font-family: monospace; color: var(--primary);">users_template.csv</span>` provided below to guarantee that your organizational hierarchy variables map correctly to the target database columns.</p>
                
                <!-- Step 1 Layout -->
                <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 15px 20px; margin-bottom: 25px;">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <i data-feather="file-text" style="color: var(--text-muted);"></i>
                        <div>
                            <strong style="display:block; font-size: 0.95rem;">Step 1: Download Schema Template</strong>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">Contains precise column headers required for ingestion.</span>
                        </div>
                    </div>
                    <a href="<?= APP_URL ?>/users/template" class="btn btn-outline" style="font-size: 0.85rem; padding: 8px 16px;">
                        <i data-feather="download" style="width: 14px; margin-right:6px;"></i> Download CSV Template
                    </a>
                </div>

                <!-- Step 2 Layout -->
                <h3 style="font-size: 1.05rem; margin-bottom: 15px; color: var(--text-primary); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Step 2: Initialize Bulk Execution</h3>
                
                <form action="<?= APP_URL ?>/users/import" method="POST" enctype="multipart/form-data" style="margin-bottom: 0;">
                    <?= csrf_field() ?>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label class="form-label" style="font-weight: 600;">Target Output Dataset</label>
                        <input type="file" name="csv_file" accept=".csv" required class="form-control" style="background: white;">
                    </div>

                    <div style="padding: 15px; background: rgba(245, 158, 11, 0.05); border: 1px dashed rgba(245, 158, 11, 0.4); border-radius: var(--radius-sm); font-size: 0.85rem; color: #92400e; margin-bottom: 20px; line-height: 1.5; display: flex; gap: 12px; align-items: flex-start;">
                        <i data-feather="alert-triangle" style="min-width: 18px; margin-top: 2px;"></i>
                        <div>
                            <strong>Structural Advisory for Students:</strong> Processing students via this Mass Provisioing Engine *exclusively* creates their core system accounts. It does NOT associate them with localized grading silos. To enroll students, use the <strong>Academic Sandbox &gt; Cohort Class View</strong> roster importation.
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; font-size: 0.85rem; color: var(--text-muted); align-items: center; margin-bottom: 20px; padding: 10px 15px; background: #f1f5f9; border-radius: var(--radius-sm);">
                        <i data-feather="key" style="width: 14px; color: var(--primary);"></i>
                        <span>Initial system password for all instantiated users defaults automatically to: <strong style="color: var(--text-primary); font-family: monospace;">cbet1234</strong></span>
                    </div>

                    <button type="submit" class="btn btn-primary" style="padding: 12px 24px; font-weight: 600; width: 100%;">
                        <i data-feather="server" style="width: 18px; margin-right: 6px;"></i> Execute Database Upload
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Pane: Required Validation Schema -->
        <div>
            <div class="card" style="padding: 24px; background: #f8fafc; position: sticky; top: 20px;">
                <h4 style="margin-top: 0; margin-bottom: 15px; font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="check-square" style="color: var(--secondary);"></i> Format Validation List
                </h4>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 15px; line-height: 1.5;">The ingestion engine strictly parses the `.csv` file against the following parameters. Deviating from these inputs will cause specific row failures during migration.</p>
                
                <ul style="font-size: 0.85rem; padding-left: 0; margin: 0; color: var(--text-secondary); display: flex; flex-direction: column; gap: 12px; list-style: none;">
                    <li style="display: flex; gap: 10px; align-items: flex-start;">
                        <span style="color: var(--danger); margin-top:2px;">*</span> 
                        <div><strong style="color: var(--text-primary);">Full Name</strong><br>Must be a valid string identifier.</div>
                    </li>
                    <li style="display: flex; gap: 10px; align-items: flex-start;">
                        <span style="color: var(--danger); margin-top:2px;">*</span> 
                        <div><strong style="color: var(--text-primary);">Email Address</strong><br>Used as primary login ID. System will reject duplicate emails natively.</div>
                    </li>
                    <li style="display: flex; gap: 10px; align-items: flex-start;">
                        <span style="color: var(--danger); margin-top:2px;">*</span> 
                        <div><strong style="color: var(--text-primary);">Authorization Role</strong><br><span style="color: var(--text-muted); font-family: monospace;">Admin, Trainer, InternalVerifier, HOD, Student.</span><br>(Case-sensitive exact match required)</div>
                    </li>
                    <li style="display: flex; gap: 10px; align-items: flex-start;">
                        <span style="color: #cbd5e1; margin-top:2px;">&#x25CB;</span> 
                        <div><strong style="color: var(--text-primary);">Institution Identifier</strong><br>Optional. Internal Reg No / PF No wrapper.</div>
                    </li>
                    <li style="display: flex; gap: 10px; align-items: flex-start;">
                        <span style="color: #cbd5e1; margin-top:2px;">&#x25CB;</span> 
                        <div><strong style="color: var(--text-primary);">Phone Index</strong><br>Optional. Standard string variable.</div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>