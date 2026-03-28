<?php require_once __DIR__ . '/../partials/header.php'; ?>

<form action="<?= APP_URL ?>/audit/start" method="POST" id="auditForm">
    <?= csrf_field() ?>
    <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">
    <input type="hidden" name="class_id" value="<?= $class['id'] ?>">

    <div class="container" style="max-width: 1200px; margin-top: 40px;">
        
        <!-- Premium Lightweight Header -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <a href="<?= APP_URL ?>/audit" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); font-size: 0.85rem; text-decoration: none; margin-bottom: 10px; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
                        <i data-feather="arrow-left" style="width: 14px;"></i> Return to Hub
                    </a>
                    <h1 class="page-title" style="margin: 0; font-size: 1.8rem; color: var(--text-primary); font-weight: 800; letter-spacing: -0.5px;">Setup Target Demographics</h1>
                    <p class="text-muted" style="margin: 4px 0 0 0; font-size: 0.95rem;">
                        Identify compliance sampling targets for <strong style="color: var(--text-primary);"><?= htmlspecialchars($unit['unit_title']) ?></strong> (<?= htmlspecialchars($class['class_code']) ?>)
                    </p>
                </div>
                
                <div style="text-align: right; background: white; padding: 15px 25px; border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                    <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); font-weight: 700; display: block; margin-bottom: 4px;">Registered Population</span>
                    <div style="font-size: 1.8rem; font-weight: 800; color: var(--primary); line-height: 1;"><?= $population ?></div>
                </div>
            </div>
        </div>

        <div class="card p-0" style="border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--shadow-md); overflow: hidden; margin-bottom: 40px;">
            
            <!-- Tools Ribbon -->
            <div style="background: rgba(248, 250, 252, 1); padding: 20px 24px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <button type="button" class="btn btn-outline" onclick="selectRandom(<?= $recommended_sample ?>)" style="display: inline-flex; align-items: center; gap: 6px; background: white; border-color: #cbd5e1; font-weight: 600;">
                        <i data-feather="shuffle" style="width: 16px;"></i> Auto-Pick (<?= $recommended_sample ?>)
                    </button>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Recommended compliance target: <strong style="color: var(--text-primary);"><?= $recommended_sample ?></strong></span>
                </div>
                
                <div style="position: relative; width: 300px;">
                    <i data-feather="search" style="position: absolute; left: 12px; top: 10px; width: 16px; color: #94a3b8;"></i>
                    <input type="text" id="studentSearch" class="form-control" style="padding-left: 36px; border-radius: 20px; font-size: 0.85rem;" placeholder="Search candidate records..." onkeyup="filterStudents()">
                </div>
            </div>

            <div style="max-height: 500px; overflow-y: auto;" class="custom-scrollbar">
                <table class="table" style="margin: 0; border: none;">
                    <thead style="position: sticky; top: 0; background: white; border-bottom: 2px solid var(--border-color); z-index: 10;">
                        <tr>
                            <th style="padding: 16px 24px; width: 60px; text-align: center;">
                                <input type="checkbox" id="selectAllCheckbox" onchange="toggleAll(this)" style="width: 16px; height: 16px; cursor: pointer;">
                            </th>
                            <th style="padding: 16px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">Candidate Designator</th>
                            <th style="padding: 16px 24px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; text-align: right;">System Registration</th>
                        </tr>
                    </thead>
                    <tbody id="studentListBody">
                        <?php foreach ($students as $s): ?>
                            <tr class="student-row" style="border-bottom: 1px solid var(--border-color); transition: background 0.15s; cursor: pointer;" onclick="document.getElementById('chk-<?= $s['id'] ?>').click();">
                                <td style="padding: 16px 24px; text-align: center; vertical-align: middle;">
                                    <input type="checkbox" name="students[]" value="<?= $s['id'] ?>" class="student-checkbox" id="chk-<?= $s['id'] ?>" style="width: 16px; height: 16px; pointer-events: none;">
                                </td>
                                <td style="padding: 16px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--bg-app); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--primary); font-size: 0.9rem;">
                                            <?= strtoupper(substr($s['full_name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="student-name" style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem; margin-bottom: 2px;"><?= htmlspecialchars($s['full_name']) ?></div>
                                            <div style="font-size: 0.75rem; color: var(--success); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;"><i data-feather="check-circle" style="width: 10px; margin-top: -2px;"></i> Active Profile</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 16px 24px; text-align: right; vertical-align: middle;">
                                    <div class="student-id" style="font-family: monospace; color: var(--text-muted); font-size: 0.9rem;">
                                        <?= htmlspecialchars($s['identifier']) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Fixed Bottom Action Bar -->
            <div style="background: white; border-top: 1px solid var(--border-color); padding: 20px 24px; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 4px;">Target Load</div>
                        <div style="display: flex; align-items: baseline; gap: 6px;">
                            <span id="selectedCountDisplay" style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary); line-height: 1;">0</span>
                            <span style="font-size: 0.85rem; color: var(--text-muted);">/ <?= $population ?> selected</span>
                        </div>
                    </div>
                    
                    <div style="width: 200px; padding-left: 20px; border-left: 1px solid var(--border-color);">
                        <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 6px; font-weight: 600; color: var(--text-muted);" id="progressLabel">
                            <span>Compliance Threshold</span>
                        </div>
                        <div style="height: 6px; background: rgba(0,0,0,0.05); border-radius: 4px; overflow: hidden;">
                            <div id="selectionProgress" style="height: 100%; width: 0%; background: var(--warning); transition: all 0.3s ease;"></div>
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="width: 250px;">
                        <input type="text" name="notes" class="form-control" style="font-size: 0.85rem;" placeholder="Optional session notes...">
                    </div>
                    
                    <input type="hidden" name="sample_size" id="finalSampleSize" value="0">
                    <button type="submit" id="startBtn" class="btn btn-primary" disabled style="display: inline-flex; align-items: center; gap: 8px; font-weight: 700; padding: 10px 25px; opacity: 0.5; transition: opacity 0.2s;">
                        <i data-feather="play-circle" style="width: 18px;"></i> Execute Audit
                    </button>
                </div>
            </div>

        </div>
    </div>
</form>

<script>
    const checkboxes = document.querySelectorAll('.student-checkbox');
    const countDisplay = document.getElementById('selectedCountDisplay');
    const inputSize = document.getElementById('finalSampleSize');
    const startBtn = document.getElementById('startBtn');
    const selectAllBox = document.getElementById('selectAllCheckbox');
    const progressBar = document.getElementById('selectionProgress');
    const progressLabel = document.getElementById('progressLabel');
    const recommended = <?= $recommended_sample ?>;

    // Hover effect for table rows
    document.querySelectorAll('.student-row').forEach(row => {
        row.addEventListener('mouseover', () => { row.style.background = '#f8fafc'; });
        row.addEventListener('mouseout', () => { row.style.background = 'transparent'; });
    });

    function updateCount() {
        let count = 0;
        checkboxes.forEach(cb => { if (cb.checked) count++; });
        
        countDisplay.innerText = count;
        inputSize.value = count;
        
        if (count > 0) {
            startBtn.disabled = false;
            startBtn.style.opacity = '1';
        } else {
            startBtn.disabled = true;
            startBtn.style.opacity = '0.5';
        }
        
        // Progress Bar
        const percentage = Math.min((count / recommended) * 100, 100);
        progressBar.style.width = percentage + '%';
        if(count >= recommended) {
            progressBar.style.background = 'var(--success)';
            progressLabel.style.color = 'var(--success)';
            progressLabel.innerHTML = '<span>Threshold Met</span> <i data-feather="check" style="width:12px;"></i>';
            if(window.feather) feather.replace();
        } else {
            progressBar.style.background = 'var(--warning)';
            progressLabel.style.color = 'var(--text-muted)';
            progressLabel.innerHTML = '<span>Compliance Threshold</span>';
        }
        
        // Select All State
        if (count === checkboxes.length && count > 0) {
            selectAllBox.checked = true;
            selectAllBox.indeterminate = false;
        } else if (count > 0) {
            selectAllBox.checked = false;
            selectAllBox.indeterminate = true;
        } else {
            selectAllBox.checked = false;
            selectAllBox.indeterminate = false;
        }
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', (e) => {
            e.stopPropagation(); 
            updateCount();
        });
    });

    function toggleAll(source) {
        const visibleRows = document.querySelectorAll('#studentListBody tr:not([style*="display: none"]) .student-checkbox');
        visibleRows.forEach(cb => cb.checked = source.checked);
        updateCount();
    }

    function selectRandom(n) {
        clearSelection();
        const visibleRows = Array.from(document.querySelectorAll('#studentListBody tr:not([style*="display: none"]) .student-checkbox'));
        
        // Fisher-Yates
        for (let i = visibleRows.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [visibleRows[i], visibleRows[j]] = [visibleRows[j], visibleRows[i]];
        }
        
        visibleRows.slice(0, n).forEach(cb => cb.checked = true);
        updateCount();
    }

    function clearSelection() {
        checkboxes.forEach(cb => cb.checked = false);
        updateCount();
    }
    
    function filterStudents() {
        const input = document.getElementById('studentSearch');
        const filter = input.value.toUpperCase();
        const rows = document.getElementById('studentListBody').getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const nameCol = rows[i].getElementsByClassName('student-name')[0];
            const idCol = rows[i].getElementsByClassName('student-id')[0];
            if (nameCol || idCol) {
                const txtValueName = nameCol.textContent || nameCol.innerText;
                const txtValueId = idCol.textContent || idCol.innerText;
                if (txtValueName.toUpperCase().indexOf(filter) > -1 || txtValueId.toUpperCase().indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; border-left: 1px solid var(--border-color); }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>