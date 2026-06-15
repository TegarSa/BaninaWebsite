@extends('frontend.layouts.app')

@section('title', $heroTitle . ' - ' . config('app.name', 'BANINA'))

@section('content')

@php
    // Ambil nomor whatsapp langsung agar aman dan konsisten di halaman index
    $indexWhatsapp = \App\Models\Setting::getValue('whatsapp_number');
@endphp

<style>
/* ===== HERO ELEGANT SLIDER ===== */
.hero-elegant {
    position: relative;
    height: 100vh;
    min-height: 600px;
    overflow: hidden;
    background: #0a0a0a;
}

.hero-slide-elegant {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 1.2s ease;
    z-index: 1;
}
.hero-slide-elegant.active {
    opacity: 1;
    z-index: 2;
}

.hero-slide-elegant img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: scale(1.08);
    transition: transform 7s ease;
}
.hero-slide-elegant.active img {
    transform: scale(1);
}

/* Multi-layer overlay */
.hero-overlay-elegant {
    position: absolute;
    inset: 0;
    background:
        linear-gradient(to right, rgba(0,0,0,0.82) 0%, rgba(0,0,0,0.45) 55%, rgba(0,0,0,0.15) 100%),
        linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 50%);
    z-index: 3;
}

/* No banner fallback */
.hero-no-img {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #111800 100%);
    z-index: 1;
}
.hero-no-img::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%237a8c2a' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* Content */
.hero-content-elegant {
    position: absolute;
    inset: 0;
    z-index: 4;
    display: flex;
    align-items: center;
}
.hero-content-elegant .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 3rem;
}

.hero-eyebrow {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.hero-eyebrow-line {
    width: 40px;
    height: 1px;
    background: var(--gold);
}
.hero-eyebrow-text {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.3em;
    text-transform: uppercase;
    color: var(--gold);
}

.hero-title-elegant {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.8rem, 6vw, 5rem);
    font-weight: 700;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 1.25rem;
}
.hero-title-elegant em {
    font-style: italic;
    background: linear-gradient(135deg, #8f9aaa 0%, #c0c0c0 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    display: block;
}

.hero-subtitle-elegant {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.2rem;
    color: rgba(255,255,255,0.7);
    margin-bottom: 2.5rem;
    max-width: 480px;
    line-height: 1.7;
}

.hero-actions-elegant {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-hero-primary {
    background: var(--gold);
    color: #0a0a0a;
    padding: 0.9rem 2.2rem;
    border-radius: 2px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.88rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: 2px solid var(--gold);
}
.btn-hero-primary:hover {
    background: transparent;
    color: var(--gold);
}

.btn-hero-outline {
    border: 2px solid rgba(255,255,255,0.4);
    color: #fff;
    padding: 0.9rem 2.2rem;
    border-radius: 2px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.88rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}
.btn-hero-outline:hover {
    border-color: var(--gold);
    color: var(--gold);
}

/* Progress bar navigation */
.hero-nav {
    position: absolute;
    bottom: 3rem;
    left: 3rem;
    z-index: 5;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.hero-nav-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    cursor: pointer;
    opacity: 0.4;
    transition: opacity 0.3s;
    background: none;
    border: none;
    padding: 0;
}
.hero-nav-item.active { opacity: 1; }
.hero-nav-item:hover { opacity: 0.8; }

.hero-nav-number {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    color: #fff;
}
.hero-nav-bar {
    width: 40px;
    height: 2px;
    background: rgba(255,255,255,0.3);
    border-radius: 2px;
    overflow: hidden;
    position: relative;
}
.hero-nav-progress {
    position: absolute;
    inset: 0;
    background: var(--gold);
    transform: scaleX(0);
    transform-origin: left;
    border-radius: 2px;
}
.hero-nav-item.active .hero-nav-progress {
    animation: progress-bar 5s linear forwards;
}
@keyframes progress-bar {
    from { transform: scaleX(0); }
    to { transform: scaleX(1); }
}

/* Slide counter */
.hero-counter {
    position: absolute;
    bottom: 3rem;
    right: 3rem;
    z-index: 5;
    color: rgba(255,255,255,0.5);
    font-size: 0.78rem;
    letter-spacing: 0.1em;
}
.hero-counter span { color: #fff; font-weight: 600; }

/* Scroll indicator */
.hero-scroll {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 5;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255,255,255,0.4);
    font-size: 0.65rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    animation: bounce 2s infinite;
}
.hero-scroll-line {
    width: 1px;
    height: 40px;
    background: linear-gradient(to bottom, rgba(255,255,255,0.4), transparent);
}
@keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50% { transform: translateX(-50%) translateY(6px); }
}

@media (max-width: 768px) {
    .hero-elegant { height: 85vh; }
    .hero-content-elegant .container { padding: 0 1.5rem; }
    .hero-title-elegant { font-size: 2.2rem; }
    .hero-nav { bottom: 1.5rem; left: 1.5rem; }
    .hero-counter { bottom: 1.5rem; right: 1.5rem; }
    .hero-scroll { display: none; }
}
</style>

<section class="hero-elegant">
    @if($banners->isNotEmpty())
        @foreach($banners as $i => $banner)
            <div class="hero-slide-elegant {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
                {{-- Mengambil gambar banner langsung dari folder public/assets/images/ --}}
                <img src="{{ asset('assets/images/banners' . $banner->image) }}" alt="{{ $banner->title }}">
            </div>
        @endforeach

        <div class="hero-overlay-elegant"></div>

        <div class="hero-content-elegant">
            <div class="container">
                <div class="hero-eyebrow">
                    <div class="hero-eyebrow-line"></div>
                    <span class="hero-eyebrow-text">Men Wear Since 2019</span>
                </div>
                <h1 class="hero-title-elegant">
                    {{ $heroTitle }}
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

    @else
        <div class="hero-no-img"></div>
        <div class="hero-overlay-elegant" style="z-index:2"></div>
        <div class="hero-content-elegant">
            <div class="container">
                <div class="hero-eyebrow">
                    <div class="hero-eyebrow-line"></div>
                    <span class="hero-eyebrow-text">Men Wear Since 2019</span>
                </div>
                <h1 class="hero-title-elegant">
                    {{ $heroTitle }}
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
    @endif

    <div class="hero-scroll">
        <div class="hero-scroll-line"></div>
        <span>Scroll</span>
    </div>
</section>

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
                    <a href="{{ url('/product/' . $product->slug) }}" style="text-decoration:none;color:inherit;display:contents">
                        <div class="product-img-wrap">
                            @if($img)
                                {{-- Mengambil gambar produk langsung dari folder public/assets/images/ --}}
                                <img src="{{ asset('assets/images/products.' . $img) }}" alt="{{ $product->name }}" loading="lazy">
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
                    <div style="padding:0 1.25rem 1.25rem">
                        @if($product->shopee_url)
                            <a href="{{ $product->shopee_url }}" class="product-wa-btn shopee-btn" target="_blank" rel="noopener">
                                <i class="fas fa-shopping-bag"></i> Beli di Shopee
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:3rem">
            <a href="{{ route('catalog') }}" class="btn-primary">
                Lihat Semua Produk <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

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
            <a href="{{ route('catalog') }}" class="btn-cat-all active-cat" id="btnTampilSemua">
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
                    'sajadah' => 'fa-mosque'
                ];
            @endphp
            
            @foreach($categories as $cat)
                @php 
                    $icon = $icons[$cat->slug] ?? 'fa-tshirt';
                @endphp
                
                {{-- Tautan diperbarui menggunakan route('catalog', slug) --}}
                <a href="{{ route('catalog', $cat->slug) }}" class="cat-circle-item">
                    <div class="cat-circle-img">
                        @if($cat->image)
                            {{-- Pastikan path sudah sesuai dengan lokasi folder images kamu --}}
                            <img src="{{ asset('assets/images/categories/' . $cat->image) }}" alt="{{ $cat->name }}">
                        @else
                            <div class="cat-circle-placeholder">
                                <i class="fas {{ $icon }}"></i>
                            </div>
                        @endif
                    </div>
                    <span class="cat-circle-label">{{ strtoupper($cat->name) }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section">
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

<section style="background:linear-gradient(135deg,var(--black) 0%,#111800 100%);padding:5rem 0;text-align:center;position:relative;overflow:hidden;border-top:1px solid rgba(122,140,42,0.2)">
    <div style="position:absolute;inset:0;background-image:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%237a8c2a\' fill-opacity=\'0.06\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
    <div class="container fade-in" style="position:relative;z-index:1">
        <span class="section-label">Butuh Bantuan?</span>
        <h2 style="font-family:'Playfair Display',serif;font-size:2.5rem;color:#fff;margin:0.75rem 0 1rem">Konsultasi Gratis via WhatsApp</h2>
        <p style="color:rgba(255,255,255,0.6);font-family:'Cormorant Garamond',serif;font-size:1.1rem;margin-bottom:2rem">Tim {{ config('app.name', 'BANINA') }} siap membantu Anda memilih busana muslim yang tepat</p>
        
        @if($indexWhatsapp)
            <a href="https://wa.me/{{ $indexWhatsapp }}?text={{ urlencode(\App\Models\Setting::getValue('whatsapp_greeting') ?? '') }}"
               class="btn-primary" target="_blank" style="font-size:1.1rem;padding:1rem 2.5rem">
                <i class="fab fa-whatsapp"></i> Chat Sekarang
            </a>
        @endif
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.hero-slide-elegant');
    const navItems = document.querySelectorAll('.hero-nav-item');
    const counter = document.getElementById('currentSlide');
    if (!slides.length || slides.length < 2) return;

    let current = 0;
    let timer;

    function goTo(n) {
        slides[current].classList.remove('active');
        navItems[current]?.classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        if (navItems[current]) navItems[current].classList.add('active');
        if (counter) counter.textContent = String(current + 1).padStart(2, '0');
    }

    function next() { goTo(current + 1); }

    function startTimer() {
        clearInterval(timer);
        timer = setInterval(next, 5000);
    }

    navItems.forEach((btn, i) => {
        btn.addEventListener('click', () => { goTo(i); startTimer(); });
    });

    startTimer();
});
</script>

@endsection