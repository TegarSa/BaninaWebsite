<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-3 py-2 sticky-top shadow-sm">
    <div class="container-fluid p-0">
        <!-- Burger Menu Button -->
        <button type="button" id="sidebarToggle" class="btn btn-outline-dark border-0 me-2">
            <i class="fas fa-bars"></i>
        </button>

        <span class="navbar-text d-none d-sm-inline-block fw-medium text-secondary">
            Selamat Datang, <strong>{{ Auth::user()->name }}</strong>
        </span>

        <!-- Right Side Dropdown -->
        <div class="ms-auto">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.85rem;">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <span class="fw-semibold d-none d-md-inline-block text-dark" style="font-size: 0.9rem;">{{ Auth::user()->username }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                    <li><a class="dropdown-menu-item dropdown-item py-2" href="{{ url('/admin/settings') }}"><i class="fas fa-cog fa-sm fa-fw text-muted me-2"></i> Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <!-- Logout Terintegrasi Laravel Auth -->
                        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar?');">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>