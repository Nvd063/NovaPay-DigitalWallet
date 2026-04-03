<script>
    // 1. Page load hotay hi saved theme check krna
    document.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('nova_theme');
        if (savedTheme) {
            applyTheme(savedTheme);
        } else {
            // Default theme agar pehli bar visit kiya ho
            applyTheme('midnight');
        }
    });

    // 2. Theme apply krny ka helper function
    function applyTheme(theme) {
        // Purani sari themes remove krna
        document.body.classList.remove('theme-midnight', 'theme-ocean', 'theme-forest', 'theme-rose');
        // Nayi theme add krna
        document.body.classList.add('theme-' + theme);

        // Sidebar swatches ko active dikhanay k liye (Optional logic)
        document.querySelectorAll('.swatch').forEach(s => {
            s.classList.remove('active');
            if (s.classList.contains(theme)) s.classList.add('active');
        });
    }

    // 3. User jab click kry ga tab ye function chalay ga
    function setTheme(theme) {
        applyTheme(theme);
        localStorage.setItem('nova_theme', theme);
    }

    // --- Baki functions wese hi rahen gy ---
    function openModal(id) {
        document.querySelectorAll('.moverlay').forEach(m => m.style.display = 'none');
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function toggleSidebar(show) {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (show) {
            sidebar.classList.add('active');
            overlay.style.display = 'block';
        } else {
            sidebar.classList.remove('active');
            overlay.style.display = 'none';
        }
    }

    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = 'flex';
        } else {
            console.error("Modal with ID " + id + " not found!");
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Modal ke bahar click karne se band ho jaye (Optional)
    window.onclick = function (event) {
        if (event.target.classList.contains('moverlay')) {
            event.target.style.display = "none";
        }
    }
</script>