</main>

<footer style="background: var(--bg-sidebar); color: #94a3b8; padding: 30px 0; margin-top: auto; border-top: 1px solid rgba(255,255,255,0.05); width: 100%;">
    <div class="container" style="padding-top: 0; padding-bottom: 0;">
        <div style="text-align: center; font-size: 0.85rem; display: flex; flex-direction: column; align-items: center; gap: 8px;">
            <div style="font-weight: 600; color: #cbd5e1;">&copy; <?= date('Y') ?> <?= htmlspecialchars($systemName ?? 'CBET POE System') ?>. All rights reserved.</div>
            <div style="color: #64748b;">Enterprise Competency Assessment Framework</div>
        </div>
    </div>
</footer>

<?php if (isset($_SESSION['user_id'])): ?>
    </div> <!-- Close main-content -->
    </div> <!-- Close app-layout -->
<?php endif; ?>
<script>
    function searchTable(inputId, tableId) {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(inputId);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);

        if(!table) return;

        var tbody = table.getElementsByTagName("tbody")[0];
        if (!tbody) tbody = table;

        tr = tbody.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            var rowContent = tr[i].textContent || tr[i].innerText;
            if (rowContent.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    function searchList(inputId, listId) {
        var input, filter, ul, li, i, txtValue;
        input = document.getElementById(inputId);
        filter = input.value.toUpperCase();
        ul = document.getElementById(listId);
        
        if(!ul) return;
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

    document.addEventListener("DOMContentLoaded", function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        // Setup Toast Auto-Hide
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(function() {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s ease';
                setTimeout(() => toast.remove(), 500);
            }, 6000);
        }
    });

    // Sidebar overlay click close handler
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            if (typeof toggleSidebar === 'function') toggleSidebar();
        });
    }
</script>
</body>

</html>