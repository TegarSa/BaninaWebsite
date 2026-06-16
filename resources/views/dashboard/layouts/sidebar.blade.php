<style>
    #sidebar {
        min-width: 260px;
        max-width: 260px;
        background: var(--admin-black);
        color: #fff;
        transition: all 0.3s;
        min-height: 100vh;
        z-index: 999;
    }

    #sidebar .sidebar-header {
        padding: 1.5rem;
        background: #000;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    #sidebar .sidebar-header h3 {
        font-family: 'Playfair Display', serif;
        color: var(--admin-gold-light);
        margin-bottom: 0;
        font-size: 1.5rem;
    }

    #sidebar ul.components {
        padding: 1rem 0;
    }

    #sidebar ul li a {
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #b3b3b3;
        text-decoration: none;
        transition: all 0.2s;
        border-left: 4px solid transparent;
    }

    #sidebar ul li a:hover, 
    #sidebar ul li.active a {
        color: #fff !important;
        background: rgba(255, 255, 255, 0.05) !important;
        border-left: 4px solid var(--admin-gold-light) !important;
    }

    #sidebar ul li a i {
        width: 20px;
        text-align: center;
    }

    @media (min-width: 768.01px) {
        #sidebar.active {
            margin-left: -260px;
        }
    }

    @media (max-width: 768px) {
        #sidebar {
            margin-left: -260px;
            position: fixed;
            height: 100vh;
        }
        #sidebar.active {
            margin-left: 0;
        }
    }
</style>

<nav id="sidebar">
    <div class="sidebar-header d-flex align-items-center justify-content-between">
        <h3>BANINA</h3>
        <small class="text-uppercase tracking-wider px-2 py-1 rounded bg-secondary text-white" style="font-size: 0.6rem;">Admin</small>
    </div>

    <ul class="list-unstyled components">
        <li class="{{ request()->is('admin') || request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}"><i class="fas fa-chart-pie"></i> Dashboard</a>
        </li>
        <li class="{{ request()->is('admin/products*') ? 'active' : '' }}">
            <a href="{{ url('/admin/products') }}"><i class="fas fa-tshirt"></i> Kelola Produk</a>
        </li>
        <li class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
            <a href="{{ url('/admin/categories') }}"><i class="fas fa-tags"></i> Kelola Kategori</a>
        </li>
        <li class="{{ request()->is('admin/banners*') ? 'active' : '' }}">
            <a href="{{ url('/admin/banners') }}"><i class="fas fa-images"></i> Kelola Banner</a>
        </li>
        <li class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
            <a href="{{ url('/admin/settings') }}"><i class="fas fa-sliders"></i> Pengaturan Toko</a>
        </li>
        <li class="mt-4 border-top border-secondary pt-2">
            <a href="{{ route('home') }}" target="_blank"><i class="fas fa-globe"></i> Lihat Website</a>
        </li>
    </ul>
</nav>