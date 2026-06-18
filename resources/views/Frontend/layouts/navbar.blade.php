@php
    $navbarWhatsapp = \App\Models\Setting::getValue('whatsapp_number');
    $navbarAddress  = \App\Models\Setting::getValue('address');
    $navCategories  = \App\Models\Category::where('is_active', 1)->orderBy('sort_order')->get();
@endphp

{{-- Topbar --}}
<div class="topbar">
    <div class="container topbar-content">
        <div class="topbar-left">
            @if($navbarAddress)
                <span class="topbar-item">
                    <i class="fas fa-map-marker-alt"></i> {{ $navbarAddress }}
                </span>
            @endif
        </div>
        <div class="topbar-right">
            <span class="topbar-item d-none-mobile">
                <i class="fas fa-clock"></i> Sen – Sab: 09.00 – 21.00
            </span>
        </div>
    </div>
</div>

{{-- Main Navbar --}}
<header class="navbar" id="mainNavbar">
    <div class="container nav-container">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="logo-wrap">
            <div class="logo-text">
                <span class="logo-main">{{ config('app.name', 'BANINA') }}</span>
                <span class="logo-sub">Men Wear Since 2019</span>
            </div>
        </a>

        {{-- Desktop nav links --}}
        <nav class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                Beranda
            </a>

            <div class="dropdown">
                <a href="{{ route('catalog') }}"
                   class="dropdown-toggle {{ request()->routeIs('catalog') ? 'active' : '' }}">
                    Produk <i class="fas fa-chevron-down" style="font-size:9px"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('catalog') }}">Semua Produk</a>
                    @foreach($navCategories as $cat)
                        <a href="{{ route('catalog', $cat->slug) }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
                Tentang
            </a>

            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                Kontak
            </a>
        </nav>

        {{-- WA button desktop --}}
        @if($navbarWhatsapp)
            <a href="https://wa.me/{{ $navbarWhatsapp }}" class="btn-wa" target="_blank">
                <i class="fab fa-whatsapp"></i> Hubungi Kami
            </a>
        @endif

        {{-- Mobile toggle --}}
        <button class="nav-toggle" id="navToggle" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

{{-- Mobile menu --}}
<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('home') }}">Beranda</a>
    <a href="{{ route('catalog') }}">Semua Produk</a>
    @foreach($navCategories as $cat)
        <a href="{{ route('catalog', $cat->slug) }}" style="padding-left:calc(var(--mg-mob) + 12px)">↳ {{ $cat->name }}</a>
    @endforeach
    <a href="{{ route('about') }}">Tentang Kami</a>
    <a href="{{ route('contact') }}">Kontak</a>
    @if($navbarWhatsapp)
        <a href="https://wa.me/{{ $navbarWhatsapp }}" target="_blank" style="color:var(--olive-mid)">
            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
        </a>
    @endif
</div>

<script>
    document.getElementById('navToggle').addEventListener('click', function () {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('open');
    });
</script>
