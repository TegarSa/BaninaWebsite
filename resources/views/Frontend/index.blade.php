@extends('frontend.layouts.app')

@section('title', $heroTitle . ' - ' . config('app.name', 'BANINA'))

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endpush

@section('content')

@php
    $indexWhatsapp = \App\Models\Setting::getValue('whatsapp_number');
@endphp

{{-- ===================== HERO ===================== --}}
<section class="hero-elegant">

    {{-- Slides --}}
    @if($banners->isNotEmpty())
        @foreach($banners as $i => $banner)
            <div class="hero-slide-elegant {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
                <img src="{{ asset('assets/images/' . $banner->image) }}" alt="{{ $banner->title }}">
            </div>
        @endforeach
    @else
        <div class="hero-no-img"></div>
    @endif

    {{-- Overlay --}}
    <div class="hero-overlay-elegant"></div>

    {{-- Content --}}
    <div class="hero-content-elegant">
        <div class="container">
            <div class="hero-eyebrow">
                <div class="hero-eyebrow-line"></div>
                <span class="hero-eyebrow-text">Men Wear Since 2019</span>
            </div>

            <h1 class="hero-title-elegant">
                {{ $heroTitle }}<br>
                <em>{{ config('app.name', 'BANINA') }}</em>
            </h1>

            <p class="hero-subtitle-elegant">{{ $heroSubtitle }}</p>

            <div class="hero-actions-elegant">
                <a href="{{ route('catalog') }}" class="btn-hero-primary">
                    <i class="fas fa-th-large"></i> Lihat Koleksi
                </a>
                @if($indexWhatsapp)
                    <a href="https://wa.me/{{ $indexWhatsapp }}" class="btn-hero-outline" target="_blank">
                        <i class="fab fa-whatsapp"></i> Tanya via WA
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Slide nav --}}
    @if($banners->count() > 1)
        <div class="hero-nav">
            @foreach($banners as $i => $b)
                <button class="hero-nav-item {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}">
                    <span class="hero-nav-number">0{{ $i + 1 }}</span>
                    <div class="hero-nav-bar"><div class="hero-nav-progress"></div></div>
                </button>
            @endforeach
        </div>
        <div class="hero-counter">
            <span id="currentSlide">01</span> / {{ str_pad($banners->count(), 2, '0', STR_PAD_LEFT) }}
        </div>
    @endif

    {{-- Scroll indicator --}}
    <div class="hero-scroll">
        <div class="hero-scroll-line"></div>
        <span>Scroll</span>
    </div>

</section>

{{-- ===================== FEATURED PRODUCTS ===================== --}}
@if($featured->isNotEmpty())
<section class="section section-bg-dark">
    <div class="container">

        <div class="section-header fade-in">
            <span class="section-label">Pilihan Terbaik</span>
            <h2 class="section-title">Produk Unggulan</h2>
            <div class="divider"><span class="divider-icon">✦</span></div>
            <p class="section-subtitle">Koleksi terpilih yang paling diminati pelanggan kami</p>
        </div>

        <div class="products-grid">
            @foreach($featured as $product)
                @php
                    $img = optional($product->images->where('is_primary', 1)->first())->image
                        ?? optional($product->images->first())->image;
                @endphp

                <div class="product-card fade-in">
                    <a href="{{ url('/product/' . $product->slug) }}" style="display:contents">
                        <div class="product-img-wrap">
                            @if($img)
                                <img src="{{ asset('assets/images/' . $img) }}" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="product-placeholder"><i class="fas fa-tshirt"></i></div>
                            @endif
                            <span class="product-badge">Unggulan</span>
                        </div>
                        <div class="product-info">
                            <div class="product-cat">{{ $product->category->name ?? '' }}</div>
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-price">
                                Rp {{ number_format($product->price_min) }}
                                @if($product->price_max > $product->price_min)
                                    <span>– Rp {{ number_format($product->price_max) }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @if($product->shopee_url)
                        <a href="{{ $product->shopee_url }}" class="shopee-btn" target="_blank" rel="noopener">
                            <i class="fas fa-shopping-bag"></i> Beli di Shopee
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:3.5rem" class="fade-in">
            <a href="{{ route('catalog') }}" class="btn-outline">
                Lihat Semua Produk <i class="fas fa-arrow-right" style="font-size:11px"></i>
            </a>
        </div>

    </div>
</section>
@endif

{{-- ===================== CATEGORIES ===================== --}}
@if($categories->isNotEmpty())
<section class="section">
    <div class="container">

        <div class="section-header fade-in">
            <span class="section-label">Koleksi {{ config('app.name', 'BANINA') }}</span>
            <h2 class="section-title">Jelajahi Kategori</h2>
            <div class="divider"><span class="divider-icon">✦</span></div>
            <p class="section-subtitle">Pilih kategori untuk menemukan koleksi busana muslim pria pilihan</p>
        </div>

        <div style="text-align:center;margin-bottom:2rem" class="fade-in">
            <a href="{{ route('catalog') }}" class="btn-cat-all active-cat">
                Tampilkan Semua
            </a>
        </div>

        <div class="cat-circle-row fade-in">
            @php
                $icons = [
                    'songkok' => 'fa-hat-cowboy',
                    'kemeja'  => 'fa-shirt',
                    'sarung'  => 'fa-scroll',
                    'celana'  => 'fa-person',
                    'sajadah' => 'fa-mosque',
                ];
            @endphp

            @foreach($categories as $cat)
                @php $icon = $icons[$cat->slug] ?? 'fa-tshirt'; @endphp
                <a href="{{ route('catalog', $cat->slug) }}" class="cat-circle-item">
                    <div class="cat-circle-img">
                        @if($cat->image)
                            <img src="{{ asset('assets/images/' . $cat->image) }}" alt="{{ $cat->name }}">
                        @else
                            <div class="cat-circle-placeholder"><i class="fas {{ $icon }}"></i></div>
                        @endif
                    </div>
                    <span class="cat-circle-label">{{ strtoupper($cat->name) }}</span>
                </a>
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- ===================== VALUE PROPOSITIONS ===================== --}}
<section class="section" style="padding-top:0">
    <div class="container">

        <div class="section-header fade-in">
            <span class="section-label">Keunggulan Kami</span>
            <h2 class="section-title">Mengapa Memilih {{ config('app.name', 'BANINA') }}?</h2>
            <div class="divider"><span class="divider-icon">✦</span></div>
        </div>

        <div class="values-grid">
            <div class="value-card fade-in">
                <div class="value-icon"><i class="fas fa-award"></i></div>
                <h3>Kualitas Premium</h3>
                <p>Bahan pilihan berkualitas tinggi untuk kenyamanan dan ketahanan produk terbaik</p>
            </div>
            <div class="value-card fade-in">
                <div class="value-icon"><i class="fas fa-mosque"></i></div>
                <h3>Sesuai Syariat</h3>
                <p>Desain elegan yang tetap memenuhi ketentuan busana muslim yang baik</p>
            </div>
            <div class="value-card fade-in">
                <div class="value-icon"><i class="fas fa-palette"></i></div>
                <h3>Desain Modern</h3>
                <p>Koleksi up-to-date mengikuti tren fashion muslim pria masa kini</p>
            </div>
            <div class="value-card fade-in">
                <div class="value-icon"><i class="fas fa-shipping-fast"></i></div>
                <h3>Layanan Cepat</h3>
                <p>Pemesanan mudah via WhatsApp dan pengiriman ke seluruh Indonesia</p>
            </div>
        </div>

    </div>
</section>

{{-- ===================== WA CTA ===================== --}}
<section class="wa-cta-section">
    <div class="container" style="position:relative;z-index:1">
        <span class="section-label">Butuh Bantuan?</span>
        <h2>Konsultasi Gratis via WhatsApp</h2>
        <p>Tim {{ config('app.name', 'BANINA') }} siap membantu Anda memilih busana muslim yang tepat</p>

        @if($indexWhatsapp)
            <a href="https://wa.me/{{ $indexWhatsapp }}?text={{ urlencode(\App\Models\Setting::getValue('whatsapp_greeting') ?? '') }}"
               class="btn-primary" target="_blank">
                <i class="fab fa-whatsapp"></i> Chat Sekarang
            </a>
        @endif
    </div>
</section>

{{-- ===================== POPUP BANNER ===================== --}}
@if($popupBanner)
    <div id="customPromoModal" class="custom-popup-overlay">
        <div class="custom-popup-wrapper">
            <button type="button" class="custom-popup-close" id="closePromoBtn" aria-label="Tutup">&times;</button>
            <div class="custom-popup-content">
                @if($popupBanner->link)
                    <a href="{{ $popupBanner->link }}" target="_blank" class="popup-img-link">
                        <img src="{{ asset('assets/images/' . $popupBanner->image) }}" alt="Promo">
                    </a>
                @else
                    <div class="popup-img-link">
                        <img src="{{ asset('assets/images/' . $popupBanner->image) }}" alt="Promo">
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

@endsection

@push('js')
    <script src="{{ asset('assets/js/home.js') }}"></script>
@endpush
