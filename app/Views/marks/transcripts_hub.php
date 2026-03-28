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
            <span class="badge badge-primary">Academic Reporting</span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">&bull;</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; font-family: monospace;">Registrar Endpoints</span>
        </div>
        <h1 class="page-title" style="margin-bottom: 5px;">Transcripts Hub</h1>
        <p class="text-muted" style="margin: 0; font-size: 1.05rem;">Select an active class program to generate and batch-print official transcripts.</p>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; margin-top: 20px;">
        
        <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
            <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                <i data-feather="layers" style="color: var(--secondary);"></i> Select Program Directory
            </h3>
            
            <div style="position: relative; flex: 1; max-width: 350px; min-width: 250px;">
                <i data-feather="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); width: 14px;"></i>
                <input type="text" id="classSearch" class="form-control" onkeyup="searchClass()" placeholder="Fuzzy search class or course hash..." style="padding-left: 32px; border-radius: var(--radius-sm); font-size: 0.85rem; padding-top: 8px; padding-bottom: 8px; border-color: var(--border-color); width: 100%;">
            </div>
        </div>

        <div style="padding: 20px; background: white;">
            <div id="classList" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                <?php foreach ($classes as $c): ?>
                    <div class="class-card popup-card" style="padding: 20px; border: 1px solid var(--border-color); border-radius: var(--radius-md); transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s; display: flex; flex-direction: column; justify-content: space-between; background: var(--bg-app); cursor: pointer;"
                         onmouseover="this.style.boxShadow='var(--shadow-md)'; this.style.borderColor='var(--primary)'; this.style.transform='translateY(-2px)';" 
                         onmouseout="this.style.boxShadow='none'; this.style.borderColor='var(--border-color)'; this.style.transform='translateY(0)';">
                        
                        <div style="margin-bottom: 25px;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                <div style="width: 40px; height: 40px; border-radius: 8px; background: white; border: 1px solid rgba(37,99,235,0.1); display: flex; align-items: center; justify-content: center; color: var(--primary); box-shadow: var(--shadow-sm);">
                                    <i data-feather="book" style="width: 18px;"></i>
                                </div>
                                <span class="badge" style="background: rgba(37,99,235,0.05); color: var(--primary); border: 1px solid rgba(37,99,235,0.15); font-family: monospace;">Valid Roster</span>
                            </div>
                            
                            <h3 style="margin: 0; font-size: 1.15rem; color: var(--text-primary); font-weight: 700; margin-bottom: 6px;">
                                <?= htmlspecialchars($c['class_code']) ?>
                            </h3>
                            <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0; line-height: 1.5; font-weight: 500;">
                                <?= htmlspecialchars($c['course_title']) ?>
                            </p>
                        </div>
                        
                        <div>
                            <?= component('button', [
                                'href' => APP_URL . "/marks/class_transcripts/{$c['id']}", 
                                'label' => 'View Transcripts', 
                                'icon' => 'printer',
                                'class' => 'w-100',
                                'style' => 'font-weight: 600;'
                            ]) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (empty($classes)): ?>
                <div class="text-center text-muted" style="padding: 60px 20px; background: var(--bg-app); border-radius: var(--radius-sm); border: 1px dashed var(--border-color); margin-top: 20px;">
                    <i data-feather="inbox" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                    <p style="margin: 0; font-size: 1.05rem;">No active classes found.</p>
                    <p style="font-size: 0.85rem; color: #94a3b8; margin-top: 5px;">Ensure cohorts are initialized and classes are provisioned.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function searchClass() {
        const input = document.getElementById('classSearch');
        const filter = input.value.toUpperCase();
        const list = document.getElementById('classList');
        const cards = list.getElementsByClassName('class-card');

        for (let i = 0; i < cards.length; i++) {
            const txtValue = cards[i].textContent || cards[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                cards[i].style.display = "flex";
            } else {
                cards[i].style.display = "none";
            }
        }
    }
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>