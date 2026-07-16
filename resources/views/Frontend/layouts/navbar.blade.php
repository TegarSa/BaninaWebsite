@php
    $navbarWhatsapp = \App\Models\Setting::getValue('whatsapp_number');
    $navbarAddress = \App\Models\Setting::getValue('address');
@endphp

<div class="bg-primary text-white text-xs">
    <div class="container mx-auto px-4 md:px-8 flex justify-between items-center py-2">
        <div class="flex items-center gap-2">
            @if($navbarAddress)
                <span class="flex items-center gap-1.5"><i class="fas fa-map-marker-alt text-secondary-container"></i> {{ $navbarAddress }}</span>
            @endif
        </div>
        <div class="hidden md:flex items-center gap-1.5">
            <i class="fas fa-clock text-secondary-container"></i> Jam Operasional: 08:00 - 21:00
        </div>
    </div>
</div>

<header class="bg-background/90 backdrop-blur-md sticky top-0 z-50 border-b border-outline-variant">
    <div class="container mx-auto px-4 md:px-8 flex items-center justify-between h-20">

        <a href="{{ route('home') }}" class="font-display text-2xl tracking-wide text-primary">
            {{ config('app.name', 'BANINA') }}
        </a>

        <nav class="hidden md:flex items-center gap-8 font-body text-sm font-medium">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-secondary' : 'text-on-surface-variant hover:text-primary' }} transition-colors">
                Beranda
            </a>

            <div class="relative group">
                <a href="{{ route('catalog') }}" class="{{ request()->routeIs('catalog') ? 'text-secondary' : 'text-on-surface-variant hover:text-primary' }} transition-colors flex items-center gap-1">
                    Produk <i class="fas fa-chevron-down text-[10px]"></i>
                </a>
                <div class="absolute left-0 top-full pt-3 hidden group-hover:block z-50">
                    <div class="bg-white rounded-lg shadow-xl border border-outline-variant py-2 w-48 editorial-shadow">
                        <a href="{{ route('catalog') }}" class="block px-4 py-2 text-sm hover:bg-surface-container hover:text-secondary transition-colors">Semua Produk</a>
                        @if(isset($categories) && $categories->isNotEmpty())
                            @foreach($categories as $cat)
                                <a href="{{ route('catalog', $cat->slug) }}" class="block px-4 py-2 text-sm hover:bg-surface-container hover:text-secondary transition-colors">{{ $cat->name }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-secondary' : 'text-on-surface-variant hover:text-primary' }} transition-colors">
                Tentang
            </a>

            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-secondary' : 'text-on-surface-variant hover:text-primary' }} transition-colors">
                Kontak
            </a>
        </nav>

        <div class="flex items-center gap-4">
            @if($navbarWhatsapp)
                <a href="https://wa.me/{{ $navbarWhatsapp }}" target="_blank"
                   class="hidden sm:inline-flex items-center gap-2 bg-primary-container text-white px-5 py-2.5 rounded-full font-body text-sm font-medium hover:bg-primary transition-colors">
                    <i class="fab fa-whatsapp"></i> Hubungi Kami
                </a>
            @endif

            <button class="nav-toggle md:hidden" id="navToggle">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>

<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('home') }}">Beranda</a>
    <a href="{{ route('catalog') }}">Semua Produk</a>

    @if(isset($categories) && $categories->isNotEmpty())
        @foreach($categories as $cat)
            <a href="{{ route('catalog', $cat->slug) }}">↳ {{ $cat->name }}</a>
        @endforeach
    @endif

    <a href="{{ route('about') }}">Tentang Kami</a>
    <a href="{{ route('contact') }}">Kontak</a>
</div>