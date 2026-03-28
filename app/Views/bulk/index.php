<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1200px;">
    
    <!-- Breadcrumb -->
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i data-feather="arrow-left" style="width: 16px;"></i> Back to Dashboard
        </a>
    </div>

    <!-- Header Block -->
    <div style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <span class="badge badge-primary">Data Initialization</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;">System Operations</span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;">Dataset Management Hub</h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;">Centralized portal for bulk formatting and importing mass data structures into the framework.</p>
    </div>

    <div class="grid-main-side" style="align-items: start; gap: 30px;">

        <!-- Left Column: Primary Datasets -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Institution Data Card -->
            <div class="card" style="padding: 0; overflow: visible;">
                <div style="padding: 24px; background: white; border-bottom: 1px solid var(--border-color); display: flex; align-items: flex-start; gap: 15px;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.05); border: 1px solid rgba(37,99,235,0.1); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                        <i data-feather="grid" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.25rem; color: var(--text-primary); margin-bottom: 4px;">Institutional Architecture</h3>
                        <p style="font-size: 0.95rem; color: var(--text-muted); margin: 0; line-height: 1.5;">Establish base hierarchy: Departments mapped to Courses, mapped to specific Curriculum Units.</p>
                    </div>
                </div>

                <div style="padding: 24px; display: flex; flex-direction: column; gap: 20px; background: #f8fafc;">
                    
                    <!-- Department Block -->
                    <div style="background: white; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; box-shadow: var(--shadow-sm);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <strong style="font-size: 1.1rem; color: var(--text-primary); display: block;">1. Departments Directory</strong>
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Root level organizational nodes (e.g. ICT, Engineering)</span>
                            </div>
                            <a href="<?= APP_URL ?>/institution/template/department" class="btn btn-outline" style="font-size: 0.8rem; padding: 6px 12px;"><i data-feather="download-cloud" style="width: 14px; margin-right:4px;"></i> Base Template</a>
                        </div>
                        <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; background: #f1f5f9; padding: 10px; border-radius: var(--radius-sm); border: 1px dashed #cbd5e1; margin: 0;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="type" value="department">
                            <input type="file" name="csv_file" required style="font-size: 0.85rem; flex: 1; min-width: 200px;" class="form-control">
                            <button type="submit" class="btn btn-primary" style="padding: 6px 16px; font-weight: 600;"><i data-feather="upload" style="width: 14px; margin-right:4px;"></i> Upload</button>
                        </form>
                    </div>

                    <!-- Courses Block -->
                    <div style="background: white; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; box-shadow: var(--shadow-sm);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <strong style="font-size: 1.1rem; color: var(--text-primary); display: block;">2. Core Courses List</strong>
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Academic structures attached to specific Dept IDs</span>
                            </div>
                            <a href="<?= APP_URL ?>/institution/template/course" class="btn btn-outline" style="font-size: 0.8rem; padding: 6px 12px;"><i data-feather="download-cloud" style="width: 14px; margin-right:4px;"></i> Base Template</a>
                        </div>
                        <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; background: #f1f5f9; padding: 10px; border-radius: var(--radius-sm); border: 1px dashed #cbd5e1; margin: 0;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="type" value="course">
                            <input type="file" name="csv_file" required style="font-size: 0.85rem; flex: 1; min-width: 200px;" class="form-control">
                            <button type="submit" class="btn btn-primary" style="padding: 6px 16px; font-weight: 600;"><i data-feather="upload" style="width: 14px; margin-right:4px;"></i> Upload</button>
                        </form>
                    </div>

                    <!-- Units Block -->
                    <div style="background: white; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; box-shadow: var(--shadow-sm);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <strong style="font-size: 1.1rem; color: var(--text-primary); display: block;">3. Curriculum Units</strong>
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Specific syllabus chunks attached to Course IDs</span>
                            </div>
                            <a href="<?= APP_URL ?>/institution/template/unit" class="btn btn-outline" style="font-size: 0.8rem; padding: 6px 12px;"><i data-feather="download-cloud" style="width: 14px; margin-right:4px;"></i> Base Template</a>
                        </div>
                        <form action="<?= APP_URL ?>/institution/import" method="POST" enctype="multipart/form-data" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; background: #f1f5f9; padding: 10px; border-radius: var(--radius-sm); border: 1px dashed #cbd5e1; margin: 0;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="type" value="unit">
                            <input type="file" name="csv_file" required style="font-size: 0.85rem; flex: 1; min-width: 200px;" class="form-control">
                            <button type="submit" class="btn btn-primary" style="padding: 6px 16px; font-weight: 600;"><i data-feather="upload" style="width: 14px; margin-right:4px;"></i> Upload</button>
                        </form>
                    </div>

                </div>
            </div>
            
        </div>

        <!-- Right Column: Secondary Datasets & Navigation -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- User Import Pane -->
            <div class="card" style="border-top: 4px solid var(--primary); padding: 24px;">
                <div style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 20px;">
                    <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(37,99,235,0.05); border: 1px solid rgba(37,99,235,0.1); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                        <i data-feather="users" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary); margin-bottom: 4px;">User Provisioning</h3>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0; line-height: 1.5;">Bulk generate user profiles, credentials, and implicit roles.</p>
                    </div>
                </div>

                <div style="background: white; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; box-shadow: var(--shadow-sm);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <strong style="font-size: 1rem; color: var(--text-primary); display: block;">Active Roster Masterfile</strong>
                            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; max-width: 200px;">Load Students, Trainers, and System Admins simultaneously.</span>
                        </div>
                        <a href="<?= APP_URL ?>/users/template" class="btn btn-outline" style="font-size: 0.8rem; padding: 6px 12px;"><i data-feather="download-cloud" style="width: 14px; margin-right:4px;"></i> Get Template</a>
                    </div>
                    
                    <form action="<?= APP_URL ?>/users/import" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 10px; background: #f1f5f9; padding: 12px; border-radius: var(--radius-sm); border: 1px dashed #cbd5e1; margin: 0;">
                        <?= csrf_field() ?>
                        <input type="file" name="csv_file" required style="font-size: 0.85rem;" class="form-control w-100">
                        <button type="submit" class="btn btn-primary w-100" style="padding: 10px; font-weight: 600;"><i data-feather="upload" style="width: 14px; margin-right:4px;"></i> Execute Bulk Upload</button>
                    </form>
                </div>
            </div>

            <!-- Contextual Hint Block -->
            <div class="card" style="padding: 24px; background: rgba(16, 185, 129, 0.03); border: 1px solid rgba(16, 185, 129, 0.2);">
                <h3 style="display: flex; align-items: center; gap: 8px; font-size: 1.15rem; color: var(--text-primary); margin-bottom: 12px;">
                    <i data-feather="check-circle" style="color: var(--success);"></i> Class Enrollments
                </h3>
                <p style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 20px; line-height: 1.5;">Student assignments are isolated per-class to prevent accidental data contamination. You cannot bulk enroll via CSV blindly; you must trigger it from a specific active Cohort Class page.</p>
                <a href="<?= APP_URL ?>/academic" class="btn btn-outline w-100" style="text-align: center; border-color: rgba(16, 185, 129, 0.5); color: #065f46; background: white;"><i data-feather="external-link" style="width: 14px; margin-right: 4px;"></i> Navigate to Academic Manager</a>
            </div>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>