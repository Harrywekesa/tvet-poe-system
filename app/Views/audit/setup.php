<?php
$title = 'Audit Setup';
ob_start();
?>

<!-- Header -->
<div class="card p-4 mb-4 border-0 shadow-sm">
    <div class="flex-between align-center">
        <div>
            <div class="flex align-center gap-2 mb-1">
                <span class="badge bg-light text-primary border-0 text-xs text-uppercase tracking-wider font-bold">
                    <?= htmlspecialchars($unit['unit_code']) ?>
                </span>
                <span class="text-xs text-gray uppercase tracking-wider">Internal Verification</span>
            </div>
            <h2 class="m-0 text-dark">Audit Setup</h2>
            <p class="text-sm text-gray mt-1"><?= htmlspecialchars($unit['unit_title']) ?> &bull; <?= htmlspecialchars($class['class_code']) ?></p>
        </div>
        <a href="<?= APP_URL ?>/audit" class="btn btn-outline-gray text-sm flex-center gap-2">
            <span>&larr;</span> Back to Dashboard
        </a>
    </div>
</div>

<form action="<?= APP_URL ?>/audit/start" method="POST" id="auditForm">
    <?= csrf_field() ?>
    <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">
    <input type="hidden" name="class_id" value="<?= $class['id'] ?>">

    <div class="grid-main-side gap-6">
        <!-- Main: Student Selection -->
        <div style="flex: 2;">
            <div class="card border-0 shadow-sm overflow-hidden">
                <!-- Toolbar -->
                <div class="p-4 border-bottom bg-white">
                    <div class="flex-between align-center mb-3">
                        <h3 class="m-0 text-lg font-bold">Select Sample Students</h3>
                        <div class="text-right">
                             <div class="text-xs text-gray uppercase font-bold tracking-wide">Population</div>
                             <div class="text-xl font-bold"><?= $population ?></div>
                        </div>
                    </div>
                    
                    <div class="flex-between align-center bg-gray-50 p-3 rounded-lg border">
                        <div class="flex align-center gap-3">
                            <button type="button" class="btn btn-dark btn-sm shadow-sm" onclick="selectRandom(<?= $recommended_sample ?>)">
                                🎲 Random (<?= $recommended_sample ?>)
                            </button>
                            <span class="text-xs text-gray">Recommended: <strong class="text-dark"><?= $recommended_sample ?></strong> students</span>
                        </div>
                        <div class="flex gap-2">
                             <button type="button" class="btn btn-link text-sm text-primary p-0" onclick="selectAll()">Select All</button>
                             <span class="text-gray-light">|</span>
                             <button type="button" class="btn btn-link text-sm text-gray p-0" onclick="clearSelection()">Clear</button>
                        </div>
                    </div>
                    
                     <div class="mt-3 relative">
                        <input type="text" id="studentSearch" class="form-control pl-5" placeholder="🔍 Search students by name or ID..." onkeyup="filterStudents()">
                    </div>
                </div>

                <!-- List -->
                <div style="max-height: 600px; overflow-y: auto;" class="custom-scrollbar">
                    <table class="table w-100 mb-0 align-middle">
                        <thead class="bg-light sticky-header">
                            <tr>
                                <th width="50" class="text-center pl-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="selectAllCheckbox" onchange="toggleAll(this)">
                                        <label class="custom-control-label" for="selectAllCheckbox"></label>
                                    </div>
                                </th>
                                <th class="text-xs uppercase text-gray font-bold tracking-wider">Student</th>
                                <th class="text-right pr-4 text-xs uppercase text-gray font-bold tracking-wider">Reg No.</th>
                            </tr>
                        </thead>
                        <tbody id="studentListBody">
                            <?php foreach ($students as $s): 
                                // Generate Avatar Initials
                                $parts = explode(' ', $s['full_name']);
                                $initials = substr($parts[0], 0, 1) . (count($parts) > 1 ? substr(end($parts), 0, 1) : '');
                                $colorIndex = (ord($initials[0]) % 5) + 1; // 1-5
                            ?>
                                <tr class="hover-bg student-row transition">
                                    <td class="text-center pl-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="students[]" value="<?= $s['id'] ?>" 
                                                class="custom-control-input student-checkbox" id="chk-<?= $s['id'] ?>">
                                            <label class="custom-control-label" for="chk-<?= $s['id'] ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex align-center gap-3">
                                            <div class="avatar avatar-sm bg-accent-<?= $colorIndex ?>">
                                                <?= strtoupper($initials) ?>
                                            </div>
                                            <div>
                                                <div class="font-bold text-dark student-name"><?= htmlspecialchars($s['full_name']) ?></div>
                                                <div class="text-xs text-success">Active</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right pr-4 text-sm text-gray font-mono student-id">
                                        <?= htmlspecialchars($s['identifier']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div style="flex: 1;">
            <div class="sticky-sidebar">
                <div class="card p-5 border-0 shadow-lg bg-dark text-white mb-4" style="background: #1e293b;">
                    <h4 class="text-sm uppercase tracking-wider text-gray-400 mb-4">Summary</h4>
                    
                    <div class="flex-between align-end mb-2">
                        <span class="text-2xl font-bold" id="selectedCountDisplay">0</span>
                        <span class="text-sm text-gray-400 mb-1">selected</span>
                    </div>
                    <div class="progress-bar-bg bg-gray-700 rounded-full h-2 mb-4">
                        <div id="selectionProgress" class="bg-success h-100 rounded-full" style="width: 0%"></div>
                    </div>

                    <p class="text-xs text-gray-400 mb-4">
                        Select at least <strong class="text-white"><?= $recommended_sample ?></strong> students for a valid sample size.
                    </p>
                    
                    <input type="hidden" name="sample_size" id="finalSampleSize" value="0">
                    
                    <button type="submit" class="btn btn-success w-100 py-3 font-bold shadow-green-glow" id="startBtn" disabled>
                        START AUDIT SESSION &rarr;
                    </button>
                </div>

                <div class="card p-4 border-0 shadow-sm bg-white">
                    <label class="text-xs text-gray uppercase font-bold tracking-wide mb-2 d-block">Notes (Optional)</label>
                    <textarea name="notes" class="form-control bg-light border-0 text-sm p-3" rows="4" 
                        placeholder="Add specific focus areas for this session..."></textarea>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    /* Premium Setup Styles */
    .gap-6 { gap: 2rem; }
    .gap-3 { gap: 1rem; }
    .text-lg { font-size: 1.125rem; }
    .text-xl { font-size: 1.25rem; }
    .text-2xl { font-size: 1.5rem; }
    .font-mono { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; }
    .text-gray-light { color: #cbd5e1; }
    .text-gray-400 { color: #94a3b8; }
    .bg-gray-50 { background-color: #f9fafb; }
    .bg-gray-700 { background-color: #334155; }
    .rounded-lg { border-radius: 0.5rem; }
    .shadow-green-glow { box-shadow: 0 4px 14px 0 rgba(34, 197, 94, 0.39); }
    .align-middle { vertical-align: middle; }
    
    /* Custom Checkbox */
    .custom-control { position: relative; display: block; min-height: 1.5rem; padding-left: 1.5rem; }
    .custom-control-input { position: absolute; opacity: 0; z-index: -1; }
    .custom-control-label { position: relative; margin-bottom: 0; vertical-align: top; cursor: pointer; }
    .custom-control-label::before {
        content: "";
        position: absolute;
        top: 0.25rem;
        left: -1.5rem;
        display: block;
        width: 1.25rem;
        height: 1.25rem;
        pointer-events: none;
        background-color: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 0.25rem;
        transition: all 0.2s;
    }
    .custom-control-label::after {
        content: "";
        position: absolute;
        top: 0.25rem;
        left: -1.5rem;
        display: block;
        width: 1.25rem;
        height: 1.25rem;
        content: "";
        background: no-repeat 50% / 50% 50%;
    }
    .custom-control-input:checked ~ .custom-control-label::before {
        color: #fff;
        border-color: #008975;
        background-color: #008975;
    }
    .custom-control-input:checked ~ .custom-control-label::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26l2.974 2.99L8 2.193z'/%3e%3c/svg%3e");
    }

    /* Avatars */
    .avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.875rem; color: #fff; }
    .bg-accent-1 { background-color: #3b82f6; } /* Blue */
    .bg-accent-2 { background-color: #8b5cf6; } /* Purple */
    .bg-accent-3 { background-color: #ec4899; } /* Pink */
    .bg-accent-4 { background-color: #f59e0b; } /* Amber */
    .bg-accent-5 { background-color: #10b981; } /* Emerald */

    /* Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    
    /* Hover Effects */
    .student-row:hover { background-color: #f8fafc; cursor: pointer; }
    .sticky-header { position: sticky; top: 0; z-index: 10; border-bottom: 2px solid #e2e8f0; }
    
    .sticky-sidebar { position: sticky; top: 20px; }
    
    /* Buttons */
    .btn-link { text-decoration: none; font-weight: 500; }
    .btn-link:hover { text-decoration: underline; }
    
    .pl-5 { padding-left: 2.5rem; }
    .relative { position: relative; }
</style>

<script>
    const checkboxes = document.querySelectorAll('.student-checkbox');
    const countDisplay = document.getElementById('selectedCountDisplay');
    const inputSize = document.getElementById('finalSampleSize');
    const startBtn = document.getElementById('startBtn');
    const selectAllBox = document.getElementById('selectAllCheckbox');
    const progressBar = document.getElementById('selectionProgress');
    const recommended = <?= $recommended_sample ?>;

    function updateCount() {
        let count = 0;
        checkboxes.forEach(cb => { if (cb.checked) count++; });
        
        countDisplay.innerText = count;
        inputSize.value = count;
        startBtn.disabled = count === 0;
        
        // Progress Bar
        const percentage = Math.min((count / recommended) * 100, 100);
        progressBar.style.width = percentage + '%';
        if(count >= recommended) {
            progressBar.classList.remove('bg-warning');
            progressBar.classList.add('bg-success');
        } else {
            progressBar.classList.remove('bg-success');
            progressBar.classList.add('bg-warning');
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
        cb.addEventListener('change', updateCount);
        // Row click
        cb.closest('tr').addEventListener('click', (e) => {
            if (e.target !== cb && e.target.tagName !== 'LABEL') {
                cb.checked = !cb.checked;
                updateCount();
            }
        });
    });

    function toggleAll(source) {
        // Only toggle visible rows if filtering
        const visibleRows = document.querySelectorAll('#studentListBody tr:not([style*="display: none"]) .student-checkbox');
        visibleRows.forEach(cb => cb.checked = source.checked);
        updateCount();
    }

    function selectRandom(n) {
        clearSelection();
        const indices = Array.from(checkboxes.keys());
        // Fisher-Yates
        for (let i = indices.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [indices[i], indices[j]] = [indices[j], indices[i]];
        }
        indices.slice(0, n).forEach(idx => checkboxes[idx].checked = true);
        updateCount();
    }

    function selectAll() {
        checkboxes.forEach(cb => cb.checked = true);
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

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layout.php';
?>