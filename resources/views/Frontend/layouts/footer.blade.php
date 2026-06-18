@php
    $footerWhatsapp  = \App\Models\Setting::getValue('whatsapp_number');
    $footerGreeting  = \App\Models\Setting::getValue('whatsapp_greeting');
    $footerDesc      = \App\Models\Setting::getValue('site_description') ?? 'Koleksi busana muslim pria premium dan modern.';
    $footerInstagram = \App\Models\Setting::getValue('instagram');
    $footerTiktok    = \App\Models\Setting::getValue('tiktok');
    $footerShopee    = \App\Models\Setting::getValue('shopee_url');
    $footerAddress   = \App\Models\Setting::getValue('address');
    $footerEmail     = \App\Models\Setting::getValue('email');
    $footerCats      = \App\Models\Category::where('is_active', 1)->orderBy('sort_order')->get();
@endphp

{{-- WhatsApp float button --}}
@if($footerWhatsapp)
    <a href="https://wa.me/{{ $footerWhatsapp }}?text={{ urlencode($footerGreeting ?? '') }}"
       class="wa-float" target="_blank" aria-label="Chat WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
@endif

<footer class="footer">
    <div class="footer-pattern"></div>

    <div class="container">
        <div class="footer-grid">

            {{-- Brand column --}}
            <div class="footer-brand">
                <h3>{{ config('app.name', 'BANINA') }}</h3>
                <p>{{ $footerDesc }}</p>

                <div class="social-links">
                    @if($footerInstagram)
                        <a href="https://instagram.com/{{ ltrim($footerInstagram, '@') }}" target="_blank" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    @if($footerTiktok)
                        <a href="https://tiktok.com/@{{ ltrim($footerTiktok, '@') }}" target="_blank" aria-label="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    @endif
                    @if($footerShopee)
                        <a href="{{ $footerShopee }}" target="_blank" aria-label="Shopee">
                            <i class="fas fa-store"></i>
                        </a>
                    @endif
                    @if($footerWhatsapp)
                        <a href="https://wa.me/{{ $footerWhatsapp }}" target="_blank" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Kategori --}}
            <div class="footer-links">
                <h4>Kategori</h4>
                <ul>
                    @if($footerCats->isNotEmpty())
                        @foreach($footerCats as $cat)
                            <li><a href="{{ route('catalog', $cat->slug) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    @else
                        <li><a href="{{ route('catalog') }}">Semua Produk</a></li>
                    @endif
                </ul>
            </div>

            {{-- Informasi --}}
            <div class="footer-links">
                <h4>Informasi</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('catalog') }}">Katalog</a></li>
                    <li><a href="{{ route('about') }}">Tentang</a></li>
                    <li><a href="{{ route('contact') }}">Kontak</a></li>
                </ul>
            </div>

            {{-- Kontak --}}
            <div class="footer-contact">
                <h4>Kontak</h4>
                @if($footerAddress)
                    <p><i class="fas fa-map-marker-alt"></i> {{ $footerAddress }}</p>
                @endif
                @if($footerEmail)
                    <p><i class="fas fa-envelope"></i> {{ $footerEmail }}</p>
                @endif
                @if($footerWhatsapp)
                    <p><i class="fab fa-whatsapp"></i> {{ $footerWhatsapp }}</p>
                @endif
            </div>

        </div>

        <div class="footer-bottom">
            <p>© {{ date('Y') }} {{ config('app.name', 'BANINA') }}. All rights reserved. &nbsp;|&nbsp; Men Wear Since 2019</p>
        </div>
    </div>
</footer>
