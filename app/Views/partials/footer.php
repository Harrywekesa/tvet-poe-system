</main>
<footer style="background: #1e293b; color: #94a3b8; padding: 40px 0; margin-top: 60px;">
    <div class="container">
        <div class="grid-3" style="align-items: start; margin-bottom: 20px;">
            <div>
                <h5 style="color: white; margin-bottom: 15px;">About <?= htmlspecialchars($systemName ?? 'System') ?>
                </h5>
                <p style="font-size: 0.9rem; line-height: 1.6;">
                    <?= nl2br(htmlspecialchars($systemSettings['about_text'] ?? 'A comprehensive Competency Based Education and Training (CBET) Portfolio of Evidence system.')) ?>
                </p>
            </div>
            <div>
                <h5 style="color: white; margin-bottom: 15px;">Contact Us</h5>
                <p style="font-size: 0.9rem;">
                    <strong>Email:</strong>
                    <?= htmlspecialchars($systemSettings['contact_email'] ?? 'admin@techex.edu') ?><br>
                    <strong>Phone:</strong>
                    <?= htmlspecialchars($systemSettings['contact_phone'] ?? '+254 700 000 000') ?><br>
                    <strong>Address:</strong><br>
                    <?= nl2br(htmlspecialchars($systemSettings['address'] ?? 'Tech Ex Institute')) ?>
                </p>
            </div>
            <div>
                <h5 style="color: white; margin-bottom: 15px;">Quick Links</h5>
                <ul style="list-style: none; padding: 0; font-size: 0.9rem;">
                    <li style="margin-bottom: 8px;"><a href="<?= APP_URL ?>"
                            style="color: #cbd5e1; text-decoration: none;">Home</a></li>
                    <li style="margin-bottom: 8px;"><a href="<?= APP_URL ?>/login"
                            style="color: #cbd5e1; text-decoration: none;">Login</a></li>
                </ul>
            </div>
        </div>
        <div style="border-top: 1px solid #334155; padding-top: 20px; text-align: center; font-size: 0.85rem;">
            &copy; <?= date('Y') ?> <?= htmlspecialchars($systemName ?? 'CBET POE System') ?>. All rights reserved.
        </div>
    </div>
</footer>
<script>
    function searchTable(inputId, tableId) {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(inputId);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);

        // Handle standard table/tbody
        var tbody = table.getElementsByTagName("tbody")[0];
        if (!tbody) tbody = table; // Fallback if no tbody

        tr = tbody.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            // Search all cells or specific one? Search all text content
            var rowContent = tr[i].textContent || tr[i].innerText;
            if (rowContent.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    // List Search (for UL/LI)
    function searchList(inputId, listId) {
        var input, filter, ul, li, i, txtValue;
        input = document.getElementById(inputId);
        filter = input.value.toUpperCase();
        ul = document.getElementById(listId);
        li = ul.getElementsByTagName("li");

        for (i = 0; i < li.length; i++) {
            var txt = li[i].textContent || li[i].innerText;
            if (txt.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
</script>
</body>

</html>