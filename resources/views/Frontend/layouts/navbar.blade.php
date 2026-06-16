@php
    $currentPage = request()->path();
    $navbarWhatsapp = \App\Models\Setting::getValue('whatsapp_number');
    $navbarAddress = \App\Models\Setting::getValue('address'); // Sesuaikan key di databasemu jika berbeda
@endphp

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
                <i class="fas fa-clock"></i> Mon - Sat: 09.00 - 21.00
            </span>
        </div>
    </div>
</div>

<header class="navbar">
    <div class="container nav-container">

        <a href="{{ route('home') }}" class="logo-wrap">

            <div class="logo-text">
                <span class="logo-main">{{ config('app.name', 'BANINA') }}</span>
                <span class="logo-sub">Men Wear Since 2019</span>
            </div>
        </a>

        <nav class="nav-links">

            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                Beranda
            </a>

            <div class="dropdown">
                <a href="{{ route('catalog') }}" class="dropdown-toggle {{ request()->routeIs('catalog') ? 'active' : '' }}">
                    Produk <i class="fas fa-chevron-down"></i>
                </a>

                <div class="dropdown-menu">
                    <a href="{{ route('catalog') }}">Semua Produk</a>

                    @if(isset($categories) && $categories->isNotEmpty())
                        @foreach($categories as $cat)
                            <a href="{{ route('catalog', $cat->slug) }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
                Tentang
            </a>

            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                Kontak
            </a>

        </nav>

        @if($navbarWhatsapp)
            <a href="https://wa.me/{{ $navbarWhatsapp }}" class="btn-wa" target="_blank">
                <i class="fab fa-whatsapp"></i> Hubungi Kami
            </a>
        @endif

        <button class="nav-toggle" id="navToggle">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

<div class="mobile-menu" id="mobileMenu">

    <a href="{{ route('home') }}">Beranda</a>
    <a href="{{ route('catalog') }}">Semua Produk</a>

    @if(isset($categories) && $categories->isNotEmpty())
        @foreach($categories as $cat)
            <a href="{{ route('catalog', $cat->slug) }}">
                ↳ {{ $cat->name }}
            </a>
        @endforeach
    @endif

    <a href="{{ route('about') }}">Tentang Kami</a>
    <a href="{{ route('contact') }}">Kontak</a>

</div>