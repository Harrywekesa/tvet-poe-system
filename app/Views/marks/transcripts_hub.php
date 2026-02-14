<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container" style="margin-top: 40px;">
    <h1>Transcripts Hub</h1>
    <p class="text-secondary">Select a class to view and print student transcripts.</p>

    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 20px;">
        <input type="text" id="classSearch" onkeyup="searchClass()" placeholder="Search class or course..."
            style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; margin-bottom: 20px;">

        <div class="grid-3" id="classList">
            <?php foreach ($classes as $c): ?>
                <div class="class-card"
                    style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; background: #f8fafc;">
                    <h3 style="margin: 0 0 5px 0; font-size: 1.1rem; color: #1e293b;">
                        <?= htmlspecialchars($c['class_code']) ?>
                    </h3>
                    <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 10px;">
                        <?= htmlspecialchars($c['course_title']) ?>
                    </p>
                    <a href="<?= APP_URL ?>/marks/class_transcripts/<?= $c['id'] ?>" class="btn btn-primary"
                        style="display: block; text-align: center; font-size: 0.9rem;">
                        View Transcripts
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($classes)): ?>
            <p>No classes found.</p>
        <?php endif; ?>
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
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>