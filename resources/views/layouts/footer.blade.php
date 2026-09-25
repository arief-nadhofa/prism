</div>
</div>







<!-- Toggle Script Sederhana untuk Mobile Sidebar -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');

        const isClosed = sidebar.classList.contains('-translate-x-full');
        if (isClosed) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }
    }
</script>
</body>

</html>