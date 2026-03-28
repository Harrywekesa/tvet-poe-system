<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4" style="max-width: 1200px;">
    
    <!-- Top Nav & Header -->
    <div class="flex-between align-center" style="margin-bottom: 24px;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <span class="badge badge-primary">Evidence Review Grid</span>
                <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
                <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;"><?= htmlspecialchars($class['class_code']) ?></span>
            </div>
            <h1 class="page-title" style="margin-bottom: 5px;"><?= htmlspecialchars($unit['unit_title']) ?></h1>
            <p class="text-muted">Evaluate candidate evidence and approve assessments.</p>
        </div>
        <div>
            <?= component('button', ['href' => APP_URL . "/academic/class/{$class['id']}", 'label' => '&larr; Back to Class', 'variant' => 'outline']) ?>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid-3" style="gap: 20px; margin-bottom: 30px;">
        <div class="card" style="display: flex; align-items: center; gap: 15px; padding: 20px;">
            <div style="background: var(--bg-app); padding: 12px; border-radius: 12px;">
                <i data-feather="users" style="color: var(--primary); width: 24px;"></i>
            </div>
            <div>
                <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Total Candidates</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary); margin-top: 4px;"><?= count($students) ?></div>
            </div>
        </div>
        
        <div class="card" style="display: flex; align-items: center; gap: 15px; padding: 20px;">
            <div style="background: var(--bg-app); padding: 12px; border-radius: 12px;">
                <i data-feather="layers" style="color: var(--secondary); width: 24px;"></i>
            </div>
            <div>
                <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Required Slots</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary); margin-top: 4px;"><?= count($slots) ?></div>
            </div>
        </div>

        <div class="card" style="padding: 20px; display: flex; flex-direction: column; justify-content: center;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Filter Candidates</label>
            <div style="position: relative;">
                <i data-feather="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); width: 16px;"></i>
                <input type="text" id="reviewScan" class="form-control" onkeyup="searchCards('reviewScan', 'studentCardsContainer')" placeholder="Search student name or reg..." style="padding-left: 36px; border-radius: var(--radius-md);">
            </div>
        </div>
    </div>

    <!-- Responsive Student Grid -->
    <?php if (empty($students)): ?>
        <div class="text-center card" style="padding: 60px 20px; background: var(--bg-app); border: 2px dashed var(--border-color); box-shadow: none;">
            <i data-feather="users" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
            <h4 style="font-size: 1.2rem; margin-bottom: 8px; color: var(--text-primary);">No Students Enrolled</h4>
            <p style="color: var(--text-muted); max-width: 400px; margin: 0 auto;">There are no candidates registered for this class assessment yet.</p>
        </div>
    <?php else: ?>
        <div class="grid-2" style="gap: 24px;" id="studentCardsContainer">
            <?php foreach ($students as $student): 
                // Calculate completion progress for this student
                $approved_count = 0;
                $submitted_count = 0;
                $total_slots = count($slots);
                
                foreach ($slots as $slot) {
                    $sub = $matrix[$student['id']][$slot['id']] ?? null;
                    if ($sub) {
                        if ($sub['status'] === 'Approved') $approved_count++;
                        if ($sub['status'] === 'Submitted') $submitted_count++;
                    }
                }
                $progress_pct = $total_slots > 0 ? round(($approved_count / $total_slots) * 100) : 0;
            ?>
                <!-- Student Card -->
                <div class="card student-card" data-search="<?= strtolower(htmlspecialchars($student['full_name']) . ' ' . ($student['identifier'] ?? '')) ?>" style="padding: 0; display: flex; flex-direction: column;">
                    
                    <!-- Card Header (Student Info) -->
                    <div style="padding: 20px; border-bottom: 1px solid var(--border-color); background: #f8fafc; border-top-left-radius: var(--radius-lg); border-top-right-radius: var(--radius-lg);">
                        <div class="flex-between align-start" style="margin-bottom: 15px;">
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <div style="width: 48px; height: 48px; background: white; border: 1px solid var(--border-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--primary); font-size: 1.2rem; box-shadow: var(--shadow-sm);">
                                    <?= substr(htmlspecialchars($student['full_name']), 0, 1) ?>
                                </div>
                                <div>
                                    <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary); line-height: 1.2; padding-bottom: 4px;"><?= htmlspecialchars($student['full_name']) ?></h3>
                                    <div style="font-family: monospace; font-size: 0.85rem; color: var(--secondary); background: var(--border-color); padding: 2px 6px; border-radius: 4px; display: inline-block;">
                                        <?= htmlspecialchars($student['identifier'] ?? 'NO-REG') ?>
                                    </div>
                                </div>
                            </div>
                            <?php if ($submitted_count > 0): ?>
                                <span class="badge badge-warning" style="display: flex; gap: 4px; align-items: center;"><div class="pulsing-dot" style="width: 6px; height: 6px; border-radius: 50%; background: #ea580c;"></div> Action Req</span>
                            <?php endif; ?>
                        </div>

                        <!-- Progress Bar -->
                        <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">
                            <span>Completion Target</span>
                            <span style="color: <?= $progress_pct === 100 ? 'var(--success)' : 'var(--primary)' ?>"><?= $approved_count ?> / <?= $total_slots ?> Approved</span>
                        </div>
                        <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; width: <?= $progress_pct ?>%; background: <?= $progress_pct === 100 ? 'var(--success)' : 'var(--primary)' ?>; transition: width 0.4s ease;"></div>
                        </div>
                    </div>

                    <!-- Slots Vertical Stack -->
                    <div style="flex: 1; padding: 0; background: white; border-bottom-left-radius: var(--radius-lg); border-bottom-right-radius: var(--radius-lg);">
                        <?php if (empty($slots)): ?>
                             <div style="padding: 20px; text-align: center; color: var(--text-muted); font-size: 0.9rem; font-style: italic;">No assessment slots configured for this unit.</div>
                        <?php else: ?>
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                <?php foreach ($slots as $slot): 
                                    $sub = $matrix[$student['id']][$slot['id']] ?? null;
                                    $status = $sub ? $sub['status'] : 'Missing';
                                    
                                    $variant = match ($status) {
                                        'Approved' => 'success',
                                        'Rejected' => 'danger',
                                        'Submitted' => 'primary',
                                        'Missing' => 'secondary',
                                        default => 'warning'
                                    };
                                    
                                    // Row styling adjustments
                                    $rowBg = $status === 'Missing' ? '#fcfcfc' : 'white';
                                    $top_border = $slot === $slots[0] ? 'none' : '1px solid var(--border-color)';
                                ?>
                                    <li style="padding: 16px 20px; border-top: <?= $top_border ?>; background: <?= $rowBg ?>; transition: background 0.2s;">
                                        
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 15px; margin-bottom: 10px;">
                                            <div>
                                                <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-primary); line-height: 1.3; margin-bottom: 6px;">
                                                    <?= htmlspecialchars($slot['title']) ?>
                                                </div>
                                                <?= component('badge', ['label' => $status, 'variant' => $variant]) ?>
                                            </div>

                                            <?php if ($sub): ?>
                                                <a href="<?= APP_URL ?>/preview/submission/<?= htmlspecialchars($sub['id']) ?>" target="_blank" class="btn btn-outline" style="padding: 4px 10px; font-size: 0.8rem; background: white; color: var(--primary); border-color: #bfdbfe;">
                                                    <i data-feather="external-link" style="width: 14px;"></i> View File
                                                </a>
                                            <?php else: ?>
                                                <span style="font-size: 0.75rem; color: #cbd5e1; font-style: italic; border: 1px dashed #cbd5e1; padding: 2px 6px; border-radius: 4px;">No Upload</span>
                                            <?php endif; ?>
                                        </div>

                                        <?php if (!empty($sub['latest_comment'])): ?>
                                            <div style="font-size: 0.8rem; color: var(--text-muted); background: var(--bg-app); padding: 8px 12px; border-radius: 6px; border-left: 3px solid var(--border-color); margin-bottom: 10px;">
                                                <i data-feather="message-circle" style="width: 12px; margin-right: 4px; color: var(--secondary);"></i> <em>"<?= htmlspecialchars($sub['latest_comment']) ?>"</em>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($sub): ?>
                                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                                
                                                <!-- Trainer Actions -->
                                                <?php if ($status === 'Submitted' && $_SESSION['role'] === 'Trainer'): ?>
                                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 5px;">
                                                        <form action="<?= APP_URL ?>/review/status" method="POST" style="margin: 0;">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="submission_id" value="<?= htmlspecialchars($sub['id']) ?>">
                                                            <input type="hidden" name="status" value="Approved">
                                                            <input type="hidden" name="comments" value="Quick Approval by Assessor">
                                                            <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>#std_<?= $student['id'] ?>">
                                                            <button type="submit" class="btn w-100" style="background: #f0fdf4; border: 1px solid var(--success); color: var(--success); font-weight: 600; font-size: 0.8rem; padding: 6px;"><i data-feather="check" style="width: 14px; margin-right: 4px;"></i> Approve</button>
                                                        </form>
                                                        <form action="<?= APP_URL ?>/review/status" method="POST" style="margin: 0;">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="submission_id" value="<?= htmlspecialchars($sub['id']) ?>">
                                                            <input type="hidden" name="status" value="Rejected">
                                                            <input type="hidden" name="comments" value="Rejected (Requires Resubmission)">
                                                            <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>#std_<?= $student['id'] ?>">
                                                            <button type="submit" class="btn w-100" style="background: #fef2f2; border: 1px solid var(--danger); color: var(--danger); font-weight: 600; font-size: 0.8rem; padding: 6px;"><i data-feather="x" style="width: 14px; margin-right: 4px;"></i> Reject</button>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- IV Quality Assurance Actions -->
                                                <?php if ($_SESSION['role'] === 'InternalVerifier' && $status === 'Approved'): ?>
                                                    
                                                    <div style="margin-top: 4px; padding: 12px; background: rgba(37,99,235,0.03); border: 1px solid rgba(37,99,235,0.1); border-radius: var(--radius-md);">
                                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                                            <span style="font-size: 0.75rem; color: var(--primary); font-weight: 700; text-transform: uppercase;">IV Audit Layer</span>
                                                            <?php 
                                                                $iv_status = $sub['verification_status'] ?? 'None'; 
                                                                $iv_bg = $iv_status === 'Verified' ? '#10b981' : ($iv_status === 'IV_Rejected' ? '#ef4444' : ($iv_status === 'Sampled' ? '#3b82f6' : '#94a3b8'));
                                                            ?>
                                                            <span style="font-size: 0.70rem; font-weight: 700; color: white; background: <?= $iv_bg ?>; padding: 2px 8px; border-radius: 20px;">
                                                                <?= $iv_status === 'None' ? 'Not Sampled' : htmlspecialchars($iv_status) ?>
                                                            </span>
                                                        </div>

                                                        <?php if ($iv_status === 'None'): ?>
                                                            <form action="<?= APP_URL ?>/review/verify" method="POST" style="margin: 0;">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="submission_id" value="<?= htmlspecialchars($sub['id']) ?>">
                                                                <input type="hidden" name="status" value="Sampled">
                                                                <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                                                <button type="submit" class="btn btn-outline w-100" style="font-size: 0.8rem; padding: 6px;"><i data-feather="target" style="width: 14px; margin-right: 4px;"></i> Select as Sample for IV Audit</button>
                                                            </form>
                                                        <?php elseif ($iv_status === 'Sampled'): ?>
                                                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                                                <form action="<?= APP_URL ?>/review/verify" method="POST" style="margin: 0;">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="submission_id" value="<?= htmlspecialchars($sub['id']) ?>">
                                                                    <input type="hidden" name="status" value="Verified">
                                                                    <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                                                    <button type="submit" class="btn w-100" style="background: var(--success); color: white; font-weight: 600; font-size: 0.8rem; border: none; padding: 6px;"><i data-feather="check-circle" style="width: 14px; margin-right: 4px;"></i> Verify</button>
                                                                </form>
                                                                <form action="<?= APP_URL ?>/review/verify" method="POST" style="margin: 0;">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="submission_id" value="<?= htmlspecialchars($sub['id']) ?>">
                                                                    <input type="hidden" name="status" value="IV_Rejected">
                                                                    <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                                                    <button type="submit" class="btn w-100" style="background: var(--danger); color: white; font-weight: 600; font-size: 0.8rem; border: none; padding: 6px;"><i data-feather="x-circle" style="width: 14px; margin-right: 4px;"></i> Invalid</button>
                                                                </form>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Bulk Finalize Module -->
    <?php if ($_SESSION['role'] === 'Trainer' && !empty($students)): ?>
        <div class="card mt-4" style="background: var(--accent); color: white; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
            <div>
                <h3 style="color: white; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="command"></i> Batch Processing
                </h3>
                <p style="color: #cbd5e1; margin: 0; font-size: 0.95rem;">If all evidence looks complete offline, you can mass-approve all submitted files instantly.</p>
            </div>
            <!-- Stubbed form for future bulk finalize logic -->
            <form action="<?= APP_URL ?>/review/bulk" method="POST" style="margin: 0;">
                 <?= csrf_field() ?>
                 <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
                 <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">
                 <button type="submit" class="btn btn-primary" style="background: white; color: var(--accent); padding: 12px 24px; font-weight: 700; border: none;" onclick="return confirm('Are you sure you want to Mass-Approve all submitted documentation?')">
                     Mass-Approve Submitted
                 </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
    function searchCards(inputId, containerId) {
        let input = document.getElementById(inputId).value.toLowerCase();
        let cards = document.querySelectorAll('#' + containerId + ' .student-card');
        
        cards.forEach(card => {
            let searchable = card.getAttribute('data-search');
            if (searchable && searchable.includes(input)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Animation Keyframes Injection
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes pulseDot {
            0% { transform: scale(0.95); opacity: 0.7; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.7; }
        }
        .pulsing-dot { animation: pulseDot 1.5s infinite ease-in-out; }
    `;
    document.head.appendChild(style);
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>