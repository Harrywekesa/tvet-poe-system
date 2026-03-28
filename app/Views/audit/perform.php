<?php
$title = 'Perform Audit';
ob_start();
?>

<!-- Header -->
<div class="card p-4 mb-4 border-0 shadow-sm sticky-top-header bg-white z-10">
    <div class="flex-between align-center">
        <div>
            <div class="flex align-center gap-2 mb-1">
                <span class="badge bg-light text-primary border-0 text-xs text-uppercase tracking-wider font-bold">
                    <?= htmlspecialchars($unit['unit_code']) ?>
                </span>
                <span class="text-xs text-gray uppercase tracking-wider">Audit In Progress</span>
            </div>
            <div class="flex align-center gap-3">
                 <h2 class="m-0 text-dark">Session #<?= $session['id'] ?></h2>
                 <span class="text-gray text-sm">&bull;</span>
                 <span class="text-gray text-sm">Sample Size: <strong><?= count($samples) ?></strong></span>
            </div>
        </div>
        <form action="<?= APP_URL ?>/audit/complete" method="POST"
            onsubmit="return confirm('Are you sure you want to finalize this audit? This cannot be undone.');">
            <?= csrf_field() ?>
            <input type="hidden" name="session_id" value="<?= $session['id'] ?>">
            <button type="submit" class="btn btn-success shadow-green-glow font-bold px-4 py-2">
                ✅ Complete Audit
            </button>
        </form>
    </div>
</div>

<div class="grid-main-side gap-6">
    <!-- Main: Audit Samples -->
    <div style="flex: 2;">
        <div class="flex-between align-center mb-4">
            <h3 class="m-0 text-lg font-bold text-gray-dark">Audit Samples</h3>
            <div class="text-xs text-gray">
                <span id="completedCount">0</span>/<?= count($samples) ?> Reviewed
            </div>
        </div>

        <?php foreach ($samples as $id => $data):
            $s = $data['student'];
            $subs = $data['submissions'];
            // Generate Avatar
            $parts = explode(' ', $s['full_name']);
            $initials = substr($parts[0], 0, 1) . (count($parts) > 1 ? substr(end($parts), 0, 1) : '');
            $colorIndex = (ord($initials[0]) % 5) + 1;
        ?>
            <div class="card border-0 shadow-sm mb-4 overflow-hidden transition sample-card" id="sample-<?= $id ?>" 
                 style="border-left: 4px solid <?= $s['status'] === 'Compliant' ? '#22c55e' : ($s['status'] === 'Non-Compliant' ? '#ef4444' : '#cbd5e1') ?>;">
                
                <!-- Card Header (Click to toggle) -->
                <div class="p-4 bg-white cursor-pointer header-toggle" onclick="toggleCard(<?= $id ?>)">
                    <div class="flex-between align-center">
                        <div class="flex align-center gap-3">
                             <div class="avatar bg-accent-<?= $colorIndex ?>">
                                <?= strtoupper($initials) ?>
                            </div>
                            <div>
                                <h4 class="m-0 text-dark font-bold"><?= htmlspecialchars($s['full_name']) ?></h4>
                                <span class="text-xs text-gray font-mono"><?= htmlspecialchars($s['identifier'] ?? 'Student') ?></span>
                            </div>
                        </div>
                        <div class="flex align-center gap-3">
                             <span class="badge-pill <?= $s['status'] === 'Compliant' ? 'bg-success-light text-success' : ($s['status'] === 'Non-Compliant' ? 'bg-danger-light text-danger' : 'bg-gray-light text-gray') ?>" 
                                   id="badge-<?= $id ?>">
                                <?= $s['status'] ?>
                            </span>
                            <span class="text-gray text-xl toggle-icon">⌄</span>
                        </div>
                    </div>
                </div>

                <!-- Card Body (Collapsible) -->
                <div class="card-body-content bg-gray-50 border-top" id="body-<?= $id ?>" style="display: <?= $s['status'] === 'Pending' ? 'block' : 'none' ?>;">
                    <div class="grid-2 gap-4 p-4">
                        <!-- Evidence Column -->
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <h5 class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-3">Student Evidence</h5>
                            <?php if (empty($subs)): ?>
                                <div class="flex-center flex-column py-4 text-center">
                                    <span class="text-2xl opacity-50 mb-2">📂</span>
                                    <p class="text-gray text-sm m-0">No submissions found.</p>
                                </div>
                            <?php else: ?>
                                <ul class="list-none p-0 m-0">
                                    <?php foreach ($subs as $sub): ?>
                                        <li class="flex-between align-center py-2 border-bottom-dashed last-no-border">
                                            <div class="flex align-center gap-2">
                                                <span class="text-lg">📄</span>
                                                <span class="text-sm text-dark font-medium"><?= htmlspecialchars($sub['slot_title']) ?></span>
                                            </div>
                                            <div class="flex align-center gap-2">
                                                <span class="badge-dot <?= $sub['status'] === 'Approved' ? 'bg-success' : 'bg-warning' ?>"></span>
                                                <?php if ($sub['status'] === 'Approved'): ?>
                                                    <a href="<?= APP_URL ?>/poe/view/<?= $sub['id'] ?>" target="_blank" 
                                                       class="btn-icon text-primary" title="View Evidence">👁️</a>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
    
                        <!-- Findings Column -->
                        <div>
                             <h5 class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-3">Audit Findings</h5>
                             
                             <!-- Segmented Control -->
                             <label class="text-xs text-gray font-bold mb-2 d-block">Conformance Status</label>
                             <div class="segmented-control mb-4">
                                 <input type="radio" name="status-<?= $id ?>" value="Pending" id="status-<?= $id ?>-pending" 
                                    <?= $s['status'] === 'Pending' ? 'checked' : '' ?> onchange="updateSample(<?= $id ?>, 'Pending')">
                                 <label for="status-<?= $id ?>-pending" class="segment-pending">Pending</label>
                                 
                                 <input type="radio" name="status-<?= $id ?>" value="Compliant" id="status-<?= $id ?>-compliant"
                                     <?= $s['status'] === 'Compliant' ? 'checked' : '' ?> onchange="updateSample(<?= $id ?>, 'Compliant')">
                                 <label for="status-<?= $id ?>-compliant" class="segment-compliant">Compliant</label>
                                 
                                 <input type="radio" name="status-<?= $id ?>" value="Non-Compliant" id="status-<?= $id ?>-noncompliant"
                                     <?= $s['status'] === 'Non-Compliant' ? 'checked' : '' ?> onchange="updateSample(<?= $id ?>, 'Non-Compliant')">
                                 <label for="status-<?= $id ?>-noncompliant" class="segment-noncompliant">Non-Compliant</label>
                             </div>
    
                             <div class="form-group">
                                <label class="text-xs text-gray font-bold mb-2 d-block">Verifier Comments</label>
                                <textarea id="comments-<?= $id ?>" class="form-control text-sm bg-white shadow-sm border-0 p-3" rows="4"
                                    placeholder="Add feedback for the internal verifier or trainer..."
                                    onblur="triggerUpdate(<?= $id ?>)"><?= htmlspecialchars($s['comments'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Trainer Documents Sidebar -->
    <div style="flex: 1;">
        <div class="sticky-sidebar">
            <div class="card p-4 border-0 shadow-sm bg-white">
                <h3 class="text-sm uppercase tracking-wider text-gray-400 font-bold mb-3">Trainer Documents</h3>
                
                <?php if (empty($prof_docs)): ?>
                    <div class="p-3 bg-gray-50 rounded text-center text-sm text-gray">
                        No documents available.
                    </div>
                <?php else: ?>
                    <div class="flex flex-column gap-2">
                        <?php foreach ($prof_docs as $doc): ?>
                            <div class="doc-item p-2 rounded border bg-gray-50 flex-between align-center transition">
                                <div class="flex align-center gap-2 overflow-hidden">
                                     <span class="text-xl">📁</span>
                                     <div class="text-truncate">
                                         <div class="text-sm font-bold text-dark text-truncate"><?= htmlspecialchars($doc['type']) ?></div>
                                         <div class="text-xs text-<?= $doc['status'] === 'Approved' ? 'success' : 'warning' ?>">
                                             <?= $doc['status'] ?>
                                         </div>
                                     </div>
                                </div>
                                <?php if ($doc['status'] === 'Approved'): ?>
                                    <a href="<?= APP_URL ?>/documents/view/<?= $doc['id'] ?>" target="_blank"
                                        class="btn btn-sm btn-white shadow-sm border text-gray-dark">
                                        View
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleCard(id) {
        const body = document.getElementById('body-' + id);
        const isHidden = body.style.display === 'none';
        body.style.display = isHidden ? 'block' : 'none';
        
        // Rotate Icon
        const card = document.getElementById('sample-' + id);
        const icon = card.querySelector('.toggle-icon');
        icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    }

    function updateSample(id, status) {
        const comments = document.getElementById('comments-' + id).value;
        const badge = document.getElementById('badge-' + id);
        const card = document.getElementById('sample-' + id);

        // UI Update
        badge.innerText = status;
        badge.className = 'badge-pill ' + 
            (status === 'Compliant' ? 'bg-success-light text-success' : 
            (status === 'Non-Compliant' ? 'bg-danger-light text-danger' : 'bg-gray-light text-gray'));

        card.style.borderLeftColor = 
            status === 'Compliant' ? '#22c55e' : 
            (status === 'Non-Compliant' ? '#ef4444' : '#cbd5e1');

        // Auto collapse if Compliant
        // if (status === 'Compliant') toggleCard(id); 

        saveData(id, status, comments);
    }
    
    function triggerUpdate(id) {
        // Find checked radio
        const status = document.querySelector(`input[name="status-${id}"]:checked`).value;
        const comments = document.getElementById('comments-' + id).value;
        saveData(id, status, comments);
    }

    function saveData(id, status, comments) {
        fetch('<?= APP_URL ?>/audit/update_sample', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `csrf_token=<?= $_SESSION['csrf_token'] ?>&sample_id=${id}&status=${status}&comments=${encodeURIComponent(comments)}`
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) alert('Failed to save.');
        });
    }
    
    // Initialize open cards
    document.querySelectorAll('.toggle-icon').forEach(icon => {
        icon.style.transition = 'transform 0.2s';
    });
</script>

<style>
    /* Premium Perform Styles */
    .gap-6 { gap: 2rem; }
    .gap-3 { gap: 0.75rem; }
    .gap-2 { gap: 0.5rem; }
    .text-lg { font-size: 1.125rem; }
    .text-xl { font-size: 1.25rem; }
    .text-gray-dark { color: #334155; }
    .text-gray-400 { color: #94a3b8; }
    .bg-gray-50 { background-color: #f9fafb; }
    .bg-white { background-color: #ffffff; }
    .rounded-lg { border-radius: 0.5rem; }
    .shadow-green-glow { box-shadow: 0 4px 14px 0 rgba(34, 197, 94, 0.39); }
    .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .border-0 { border: none !important; }
    .sticky-top-header { position: sticky; top: 0; z-index: 50; }
    .sticky-sidebar { position: sticky; top: 100px; }
    .cursor-pointer { cursor: pointer; }
    
    /* Avatars */
    .avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #fff; }
    .bg-accent-1 { background-color: #3b82f6; } .bg-accent-2 { background-color: #8b5cf6; } 
    .bg-accent-3 { background-color: #ec4899; } .bg-accent-4 { background-color: #f59e0b; } .bg-accent-5 { background-color: #10b981; }

    /* Badges */
    .badge-pill { padding: 4px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.025em; }
    .bg-success-light { background-color: #dcfce7; } .text-success { color: #166534; }
    .bg-danger-light { background-color: #fee2e2; } .text-danger { color: #991b1b; }
    .bg-gray-light { background-color: #f1f5f9; } .text-gray { color: #64748b; }
    
    /* Segmented Control */
    .segmented-control { display: flex; background: #f1f5f9; padding: 4px; border-radius: 8px; }
    .segmented-control input { display: none; }
    .segmented-control label { flex: 1; text-align: center; padding: 8px; font-size: 0.85rem; border-radius: 6px; cursor: pointer; color: #64748b; font-weight: 500; transition: all 0.2s; margin: 0; }
    
    /* Checked States */
    input[value="Pending"]:checked + label { background: #fff; color: #64748b; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    input[value="Compliant"]:checked + label { background: #10b981; color: #fff; box-shadow: 0 1px 3px rgba(16, 185, 129, 0.3); }
    input[value="Non-Compliant"]:checked + label { background: #ef4444; color: #fff; box-shadow: 0 1px 3px rgba(239, 68, 68, 0.3); }

    /* Evidence List */
    .list-none { list-style: none; }
    .border-bottom-dashed { border-bottom: 1px dashed #e2e8f0; }
    .last-no-border:last-child { border-bottom: none; }
    .badge-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
    .btn-icon { background: none; border: none; font-size: 1.1rem; cursor: pointer; padding: 0; opacity: 0.7; transition: opacity 0.2s; }
    .btn-icon:hover { opacity: 1; }
    
    /* Doc Item */
    .doc-item:hover { border-color: #cbd5e1; background-color: #fff; }
    .text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .btn-white { background: #fff; }
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layout.php';
?>