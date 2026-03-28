<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1200px;">
    
    <!-- Breadcrumb / Back Navigation -->
    <div style="margin-bottom: 20px;">
        <a href="<?= APP_URL ?>/dashboard" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
            <i data-feather="arrow-left" style="width: 16px;"></i> Back to Dashboard
        </a>
    </div>

    <!-- Layout Header -->
    <div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 15px;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <span class="badge badge-primary">Institutional Core</span>
                <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
                <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;">Access Management</span>
            </div>
            <h1 class="page-title" style="margin-bottom: 5px;">User Directory</h1>
            <p class="text-muted" style="margin: 0; font-size: 1.05rem;">Provision roles and manage institutional access privileges.</p>
        </div>
        <div>
            <?= component('button', ['href' => APP_URL . '/users/import', 'label' => 'Import CSV Defaults', 'variant' => 'outline', 'icon' => 'upload']) ?>
        </div>
    </div>

    <div class="grid-main-side" style="align-items: start; gap: 30px;">
        
        <!-- Left Pane: User Directories -->
        <div>
            <?php if (!empty($team_trainers) || !empty($team_students) || ($_SESSION['role'] === 'HOD')): ?>

                <!-- Trainers Directory -->
                <div class="card" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
                    <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
                        <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                            <i data-feather="users" style="color: var(--primary);"></i> Assigned Trainers
                        </h3>
                        <span class="badge badge-secondary"><?= count($team_trainers ?? []) ?> Active</span>
                    </div>

                    <?php if (empty($team_trainers)): ?>
                        <div class="text-center" style="padding: 40px 20px;">
                            <p style="color: var(--text-muted); margin: 0; font-style: italic;">No trainers found with allocated units in your department.</p>
                        </div>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column;">
                            <?php foreach ($team_trainers as $i => $t): ?>
                                <div style="padding: 15px 20px; border-bottom: <?= $i === count($team_trainers) - 1 ? 'none' : '1px solid var(--border-color)' ?>; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; transition: background 0.2s;" onmouseover="this.style.background='#fbfcfd'" onmouseout="this.style.background='white'">
                                    
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--bg-app); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--primary); font-size: 1rem; box-shadow: var(--shadow-sm);">
                                            <?= substr(htmlspecialchars($t['full_name']), 0, 1) ?>
                                        </div>
                                        <div>
                                            <h4 style="margin: 0; font-size: 1rem; color: var(--text-primary); margin-bottom: 2px; font-weight: 700;"><?= htmlspecialchars($t['full_name']) ?></h4>
                                            <div style="font-size: 0.85rem; color: var(--text-muted); font-family: monospace; display: flex; gap: 8px; align-items: center;">
                                                <?= htmlspecialchars($t['email']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
                                            <span class="badge" style="background: rgba(37,99,235,0.1); color: var(--primary); font-size: 0.75rem; border: 1px solid rgba(37,99,235,0.2);"><i data-feather="book-open" style="width: 10px; margin-right:4px;"></i> <?= htmlspecialchars($t['class_code']) ?></span>
                                            <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;"><?= htmlspecialchars($t['units']) ?> Unit Allocations</span>
                                        </div>
                                        <a href="<?= APP_URL ?>/users/edit/<?= $t['id'] ?>" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem;"><i data-feather="edit-2" style="width: 14px;"></i> Update</a>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Enrolled Students Directory -->
                <div class="card" style="padding: 0; overflow: hidden; margin-bottom: 20px;">
                    <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                        <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                            <i data-feather="users" style="color: var(--secondary);"></i> Active Student Roster
                        </h3>
                        <div style="position: relative; max-width: 300px; flex: 1; min-width: 200px;">
                            <i data-feather="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); width: 14px;"></i>
                            <input type="text" id="studentScan" class="form-control" onkeyup="searchCards('studentScan', 'student-item', 'data-search')" placeholder="Search student name or reg..." style="padding-left: 32px; border-radius: var(--radius-sm); font-size: 0.85rem; padding-top: 6px; padding-bottom: 6px;">
                        </div>
                    </div>

                    <?php if (empty($team_students)): ?>
                        <div class="text-center" style="padding: 40px 20px;">
                            <p style="color: var(--text-muted); margin: 0; font-style: italic;">No active students enrolled in your department's parameters.</p>
                        </div>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column;">
                            <?php foreach ($team_students as $i => $s): ?>
                                <div class="student-item" data-search="<?= strtolower(htmlspecialchars($s['full_name']) . ' ' . ($s['identifier'] ?? '')) ?>" style="padding: 15px 20px; border-bottom: <?= $i === count($team_students) - 1 ? 'none' : '1px solid var(--border-color)' ?>; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; transition: background 0.2s;" onmouseover="this.style.background='#fbfcfd'" onmouseout="this.style.background='white'">
                                    
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: white; border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--secondary); font-size: 1rem; box-shadow: var(--shadow-sm);">
                                            <?= substr(htmlspecialchars($s['full_name']), 0, 1) ?>
                                        </div>
                                        <div>
                                            <h4 style="margin: 0; font-size: 1rem; color: var(--text-primary); margin-bottom: 2px; font-weight: 700;"><?= htmlspecialchars($s['full_name']) ?></h4>
                                            <div style="font-size: 0.85rem; color: var(--text-muted); font-family: monospace; display: flex; gap: 8px; align-items: center;">
                                                <span style="font-weight: 600; color: var(--primary);"><?= htmlspecialchars($s['identifier'] ?? 'NO-REG') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
                                            <span class="badge badge-secondary" style="font-size: 0.70rem; border: 1px solid var(--border-color);"><i data-feather="home" style="width: 10px; margin-right:4px;"></i> <?= htmlspecialchars($s['class_code']) ?></span>
                                            <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Tracking <?= htmlspecialchars($s['units']) ?> Modules</span>
                                        </div>
                                        <a href="<?= APP_URL ?>/users/edit/<?= $s['id'] ?>" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem;"><i data-feather="edit-2" style="width: 14px;"></i> Update Profile</a>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php else: ?>

                <!-- Universal Admin Master Directory (Fallback) -->
                <div class="card" style="padding: 0; overflow: hidden; margin-bottom: 20px;">
                    <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                        <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                            <i data-feather="book" style="color: var(--primary);"></i> Master System Roster
                        </h3>
                        <div style="position: relative; max-width: 350px; flex: 1; min-width: 200px;">
                            <i data-feather="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); width: 14px;"></i>
                            <input type="text" id="userScan" class="form-control" onkeyup="searchCards('userScan', 'admin-user-item', 'data-search')" placeholder="Search directory by name, role, email or ID..." style="padding-left: 32px; border-radius: var(--radius-sm); font-size: 0.85rem; padding-top: 6px; padding-bottom: 6px;">
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column;">
                        <?php foreach ($users as $i => $u): ?>
                            <div class="admin-user-item" data-search="<?= strtolower(htmlspecialchars($u['full_name']) . ' ' . htmlspecialchars($u['role_name']) . ' ' . htmlspecialchars($u['email']) . ' ' . htmlspecialchars($u['identifier'] ?? '')) ?>" style="padding: 16px 20px; border-bottom: <?= $i === count($users) - 1 ? 'none' : '1px solid var(--border-color)' ?>; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; transition: background 0.2s;" onmouseover="this.style.background='#fbfcfd'" onmouseout="this.style.background='white'">
                                
                                <!-- User Identity -->
                                <div style="display: flex; align-items: center; gap: 15px; flex: 1; min-width: 250px;">
                                    <!-- Status Indicator Dot integrated into Avatar constraint -->
                                    <div style="position: relative;">
                                        <div style="width: 42px; height: 42px; border-radius: 50%; background: <?= $u['is_active'] ? 'white' : '#f8fafc' ?>; border: 1px solid <?= $u['is_active'] ? 'var(--border-color)' : '#e2e8f0' ?>; display: flex; align-items: center; justify-content: center; font-weight: 700; color: <?= $u['is_active'] ? 'var(--primary)' : '#94a3b8' ?>; font-size: 1.1rem; box-shadow: <?= $u['is_active'] ? 'var(--shadow-sm)' : 'none' ?>;">
                                            <?= substr(htmlspecialchars($u['full_name']), 0, 1) ?>
                                        </div>
                                        <div style="position: absolute; bottom: 0px; right: 0px; width: 12px; height: 12px; border-radius: 50%; background: <?= $u['is_active'] ? 'var(--success)' : 'var(--danger)' ?>; border: 2px solid white;"></div>
                                    </div>
                                    <div>
                                        <h4 style="margin: 0; font-size: 1.05rem; color: <?= $u['is_active'] ? 'var(--text-primary)' : '#94a3b8' ?>; margin-bottom: 2px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                                            <?= htmlspecialchars($u['full_name']) ?>
                                            <?php if (!$u['is_active']): ?>
                                                <span class="badge" style="background: #fef2f2; color: var(--danger); font-size: 0.65rem; border: 1px solid #fecaca; padding: 2px 6px;">Suspended</span>
                                            <?php endif; ?>
                                        </h4>
                                        <div style="font-size: 0.85rem; color: var(--text-muted); display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                            <span style="display: inline-flex; align-items: center; gap: 3px; font-weight: 600;"><i data-feather="shield" style="width: 10px;"></i> <?= htmlspecialchars($u['role_name']) ?></span>
                                            <span>&bull;</span>
                                            <span style="font-family: monospace;"><?= htmlspecialchars($u['identifier'] ?? 'NO-REG') ?></span>
                                            <span>&bull;</span>
                                            <a href="mailto:<?= htmlspecialchars($u['email']) ?>" style="color: var(--primary); text-decoration: none;"><?= htmlspecialchars($u['email']) ?></a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Meta & Actions -->
                                <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                    <?php if (!empty($u['dept_name'])): ?>
                                        <div style="text-align: right; display: none; @media(min-width: 640px) { display: block; }">
                                            <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Department</span>
                                            <div style="font-size: 0.85rem; color: var(--text-primary); font-weight: 500;"><?= htmlspecialchars($u['dept_name']) ?></div>
                                        </div>
                                    <?php endif; ?>

                                    <div style="display: flex; gap: 8px;">
                                        <a href="<?= APP_URL ?>/users/edit/<?= $u['id'] ?>" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem;" title="Edit Core Details"><i data-feather="edit-2" style="width: 14px; margin-right: 4px;"></i> Edit</a>

                                        <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                            <?php if ($u['is_active']): ?>
                                                <button onclick="openSuspendModal(<?= $u['id'] ?>)" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem; color: var(--warning); border-color: #fce7f3; background: #fffbeb;" title="Suspend Access"><i data-feather="pause-circle" style="width: 14px; margin-right: 4px;"></i> Suspend</button>
                                            <?php else: ?>
                                                <a href="<?= APP_URL ?>/users/activate/<?= $u['id'] ?>" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem; color: var(--success); border-color: #dcfce7; background: #f0fdf4;" title="Restore Access"><i data-feather="play-circle" style="width: 14px; margin-right: 4px;"></i> Restore</a>
                                            <?php endif; ?>

                                            <a href="<?= APP_URL ?>/users/delete/<?= $u['id'] ?>" onclick="return confirm('CRITICAL WARNING: Are you sure you want to hard delete this user? Their records, evidence portfolios, and historical assessments will become orphaned! Suspension is heavily advised instead. Proceed with Delete?');" class="btn btn-outline" style="padding: 6px 10px; font-size: 0.85rem; color: var(--danger); border-color: #fecaca; margin-left: auto;" title="Hard Delete Data"><i data-feather="trash-2" style="width: 14px;"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php endif; ?>
        </div>

        <!-- Right Pane: Add User Form -->
        <div>
            <div class="card" style="border-top: 4px solid var(--primary); padding: 24px;">
                <h3 style="margin-bottom: 20px; font-size: 1.25rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="user-plus" style="color: var(--primary);"></i> Provision User Account
                </h3>

                <form action="<?= APP_URL ?>/users/store" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label class="form-label">Full Legal Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="e.g. Johnathan Doe" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address (Login ID)</label>
                        <input type="email" name="email" class="form-control" placeholder="staff@institution.edu" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Institutional Identifier</label>
                        <input type="text" name="identifier" class="form-control" placeholder="PF No / Reg No (e.g. ST/001/24)" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Security Clearance Role <span style="color:var(--danger)">*</span></label>
                        <select name="role_id" required onchange="toggleDept(this)" class="form-control">
                            <?php foreach ($roles as $r): ?>
                                <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="deptField" class="form-group" style="display: none;">
                        <label class="form-label">Branch / Department (Optional)</label>
                        <select name="department_id" class="form-control">
                            <option value="">Select Department...</option>
                            <?php
                            $deptModel = new \App\Models\InstitutionModel();
                            $depts = $deptModel->getAllDepartments();
                            foreach ($depts as $d):
                            ?>
                                <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="classField" class="form-group" style="display: none;">
                        <label class="form-label">Initial Cohort Assignment (For Students)</label>
                        <select name="class_id" class="form-control">
                            <option value="">Select Class...</option>
                            <?php foreach ($classes as $c): ?>
                                <option value="<?= $c['id'] ?>">
                                    <?= htmlspecialchars($c['class_code']) ?> (<?= htmlspecialchars($c['course_title']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Initial Password Token</label>
                        <div style="position: relative;">
                            <i data-feather="key" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); width: 14px;"></i>
                            <input type="text" name="password" class="form-control" value="cbet1234" style="padding-left: 36px; font-family: monospace; color: var(--primary); font-weight: 700; border-color: #bfdbfe;" required>
                        </div>
                        <small style="color: var(--text-muted); font-size: 0.75rem; display: block; margin-top: 4px;">Default assigned password for first login.</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" style="padding: 12px; font-weight: 600; margin-top: 15px; font-size: 1rem;">
                        <i data-feather="check" style="width: 18px;"></i> Create & Activate User
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Scripts -->
<script>
    function searchCards(inputId, className, dataAttr) {
        let input = document.getElementById(inputId).value.toLowerCase();
        let cards = document.querySelectorAll('.' + className);
        
        cards.forEach(card => {
            let searchable = card.getAttribute(dataAttr);
            if (searchable && searchable.includes(input)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function toggleDept(select) {
        const text = select.options[select.selectedIndex].text;
        document.getElementById('deptField').style.display = 'block';

        const classDiv = document.getElementById('classField');
        if (text.includes('Student')) {
            classDiv.style.display = 'block';
            classDiv.querySelector('select').setAttribute('required', 'true');
        } else {
            classDiv.style.display = 'none';
            classDiv.querySelector('select').removeAttribute('required');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleDept(document.querySelector('select[name="role_id"]'));
    });
</script>

<!-- Suspend Modal -->
<div id="suspendModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease;">
    <div class="card" style="width: 450px; max-width: 90%; transform: translateY(20px); transition: transform 0.3s ease;" id="suspendModalCard">
        
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 15px;">
            <h3 style="margin: 0; font-size: 1.25rem; display: flex; align-items: center; gap: 8px; color: var(--warning);">
                <i data-feather="pause-circle"></i> Suspend Access Privilege
            </h3>
            <button type="button" onclick="closeSuspendModal()" style="background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 5px;">
                <i data-feather="x" style="width: 18px;"></i>
            </button>
        </div>

        <p class="text-muted" style="margin-bottom: 20px; font-size: 0.95rem; line-height: 1.5;">You are about to suspend this user account. They will be immediately blocked from logging into the framework. Please provide a mandatory reason for the audit logs.</p>
        
        <form action="<?= APP_URL ?>/users/suspend" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="user_id" id="suspendUserId">
            
            <div class="form-group">
                <label class="form-label" style="font-weight: 600; color: var(--text-primary);">Audit Justification Log <span style="color:var(--danger)">*</span></label>
                <textarea name="reason" rows="3" required placeholder="e.g. Violation of academic integrity, tuition arrears..." class="form-control" style="background: #f8fafc; resize: vertical; min-height: 80px;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 25px;">
                <button type="button" onclick="closeSuspendModal()" class="btn btn-outline" style="padding: 10px 16px; font-weight: 600;">Cancel</button>
                <button type="submit" class="btn" style="background: var(--warning); color: #78350f; border: none; padding: 10px 16px; font-weight: 700; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);">
                    Confirm Suspension
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openSuspendModal(userId) {
        document.getElementById('suspendUserId').value = userId;
        const modal = document.getElementById('suspendModal');
        const card = document.getElementById('suspendModalCard');
        
        modal.style.display = 'flex';
        // Trigger reflow
        void modal.offsetWidth; 
        
        modal.style.opacity = '1';
        card.style.transform = 'translateY(0)';
    }

    function closeSuspendModal() {
        const modal = document.getElementById('suspendModal');
        const card = document.getElementById('suspendModalCard');
        
        modal.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    // Close on backdrop click
    window.onclick = function (event) {
        var modal = document.getElementById('suspendModal');
        if (event.target == modal) {
            closeSuspendModal();
        }
    }
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>