<nav class="navbar">
    <a href="/" class="brand">
        <img src="{{ asset('images/logo-rangkita.png') }}" alt="Logo Rangkita" class="brand-logo">

        <span class="logo">
            RANG<span class="k">K</span><span class="i">I</span><span class="t">T</span><span
                class="a">A</span>
        </span>
    </a>

    <button type="button" class="menu-toggle" id="menuToggle" aria-label="Buka menu navigasi" aria-controls="navMenu"
        aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="nav-menu" id="navMenu">
        <a href="/produk" class="{{ request()->is('produk*') ? 'active' : '' }}">
            Produk
        </a>

        <a href="/undangan" class="{{ request()->is('undangan*') ? 'active' : '' }}">
            Undangan
        </a>

        <a href="/cpns" class="{{ request()->is('cpns*') ? 'active' : '' }}">
            CPNS
        </a>

        <a href="/artikel" class="{{ request()->is('artikel*') ? 'active' : '' }}">
            Artikel
        </a>

        <a href="/kontak" class="{{ request()->is('kontak*') ? 'active' : '' }}">
            Kontak
        </a>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');

        if (!menuToggle || !navMenu) {
            return;
        }

        function closeMobileMenu() {
            navMenu.classList.remove('is-open');
            menuToggle.classList.remove('is-open');
            menuToggle.setAttribute('aria-expanded', 'false');
        }

        menuToggle.addEventListener('click', function() {
            const isOpen = navMenu.classList.toggle('is-open');

            menuToggle.classList.toggle('is-open', isOpen);
            menuToggle.setAttribute('aria-expanded', String(isOpen));
        });

        navMenu.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', closeMobileMenu);
        });

        document.addEventListener('click', function(event) {
            const clickedInsideNavbar = event.target.closest('.navbar');

            if (!clickedInsideNavbar) {
                closeMobileMenu();
            }
        });
    });
</script>
