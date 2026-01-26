</main>
<footer style="background: #1e293b; color: #94a3b8; padding: 40px 0; margin-top: 60px;">
    <div class="container" style="text-align: center;">
        <p>&copy;
            <?= date('Y') ?> CBET POE System. Internal Use Only.
        </p>
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