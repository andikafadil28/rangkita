<nav class="navbar">
    <a href="/" class="brand">
        <img src="{{ asset('images/logo-rangkita.png') }}" alt="Logo Rangkita" class="brand-logo">

        <span class="logo">
            RANG<span class="k">K</span><span class="i">I</span><span class="t">T</span><span
                class="a">A</span>
        </span>
    </a>

    <div class="nav-menu">
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
