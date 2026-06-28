@extends('frontend.layouts.app')

@section('title', $heroTitle . ' - ' . config('app.name', 'BANINA'))

@section('content')

@php
    $indexWhatsapp = \App\Models\Setting::getValue('whatsapp_number');
    $indexGreeting = \App\Models\Setting::getValue('whatsapp_greeting');
    $catIcons = [
        'songkok' => 'fa-hat-cowboy',
        'kemeja'  => 'fa-shirt',
        'sarung'  => 'fa-scroll',
        'celana'  => 'fa-person',
        'sajadah' => 'fa-mosque',
    ];
@endphp

{{-- ============ HERO ============ --}}
<section class="relative h-[480px] sm:h-[560px] md:h-[640px] lg:h-[760px] xl:h-[860px] flex items-center overflow-hidden bg-primary">
    @if($banners->isNotEmpty())
        <div class="absolute inset-0 z-0">
            @foreach($banners as $i => $banner)
                <div class="hero-slide-elegant {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
                    <img src="{{ asset('assets/images/' . $banner->image) }}" alt="{{ $banner->title ?? config('app.name') }}">
                </div>
            @endforeach
            <div class="absolute inset-0 bg-gradient-to-r from-primary/80 via-primary/30 to-transparent"></div>
        </div>
    @else
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-primary to-primary-container"></div>
    @endif

    <div class="relative z-10 w-full container mx-auto px-4 md:px-8 text-white">
        <div class="max-w-xl">
            <span class="font-body text-xs uppercase tracking-[0.2em] text-secondary-container mb-3 block">Koleksi Eksklusif</span>
            <h1 class="font-display text-3xl md:text-5xl font-bold mb-4 leading-tight">
                {{ $heroTitle }}
            </h1>
            <p class="font-body text-base text-white/80 mb-8 max-w-md">{{ $heroSubtitle }}</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('catalog') }}" class="bg-primary-container text-white px-7 py-3 rounded font-body text-sm font-medium editorial-shadow hover:bg-primary transition-colors inline-flex items-center gap-2">
                    <i class="fas fa-th-large"></i> Lihat Koleksi
                </a>
                @if($indexWhatsapp)
                    <a href="https://wa.me/{{ $indexWhatsapp }}?text={{ urlencode($indexGreeting ?? '') }}" target="_blank"
                       class="border border-white/40 text-white px-7 py-3 rounded font-body text-sm font-medium hover:bg-white/10 transition-colors inline-flex items-center gap-2">
                        <i class="fab fa-whatsapp"></i> Konsultasi WhatsApp
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if($banners->count() > 1)
        <div class="absolute bottom-6 right-6 z-10 flex gap-3">
            @foreach($banners as $i => $b)
                <button class="hero-nav-item {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}">
                    <div class="hero-nav-bar"><div class="hero-nav-progress"></div></div>
                </button>
            @endforeach
        </div>
    @endif
</section>

{{-- ============ KATEGORI (ikon) ============ --}}
@if($categories->isNotEmpty())
<section class="bg-surface-container py-10">
    <div class="container mx-auto px-4 md:px-8">
        <div class="flex flex-wrap justify-center gap-x-10 gap-y-6">
            @foreach($categories as $cat)
                @php $icon = $catIcons[$cat->slug] ?? 'fa-tshirt'; @endphp
                <a href="{{ route('catalog', $cat->slug) }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-16 h-16 rounded-full bg-white border border-outline-variant group-hover:border-secondary transition-colors overflow-hidden flex items-center justify-center">
                        @if($cat->image)
                            <img src="{{ asset('assets/images/' . $cat->image) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover object-top">
                        @else
                            <i class="fas {{ $icon }} text-lg text-secondary"></i>
                        @endif
                    </div>
                    <span class="font-body text-xs text-on-surface-variant group-hover:text-secondary transition-colors">{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ PRODUK UNGGULAN ============ --}}
@if($featured->isNotEmpty())
<section class="py-16 container mx-auto px-4 md:px-8">
    <div class="flex flex-wrap items-end justify-between gap-4 mb-10">
        <div>
            <h2 class="font-display text-2xl md:text-3xl text-primary mb-2">Produk Unggulan</h2>
            <p class="font-body text-sm text-on-surface-variant">Kurasi terbaik kami yang menjadi favorit para pria yang mendambakan kenyamanan dalam balutan kemewahan yang rendah hati.</p>
        </div>
        <a href="{{ route('catalog') }}" class="font-body text-sm text-secondary underline underline-offset-4 whitespace-nowrap hover:decoration-2">Lihat Semua Produk →</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($featured as $product)
            @php
                $img = optional($product->images->where('is_primary', 1)->first())->image
                    ?? optional($product->images->first())->image;
            @endphp
            <div>
                <a href="{{ url('/product/' . $product->slug) }}" class="block">
                    <div class="relative overflow-hidden rounded mb-3 aspect-square bg-white">
                        @if($img)
                            <img class="w-full h-full object-cover transition-soft group-hover:scale-105" src="{{ asset('assets/images/' . $img) }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-secondary/30">
                                <i class="fas fa-tshirt text-3xl"></i>
                            </div>
                        @endif
                        <span class="absolute top-2 left-2 bg-secondary-container text-on-secondary-container text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded">
                            Unggulan
                        </span>
                    </div>
                    <p class="font-body text-[11px] uppercase tracking-wider text-on-surface-variant mb-1">{{ $product->category->name ?? '' }}</p>
                    <h3 class="font-display text-base text-primary mb-1 leading-snug">{{ $product->name }}</h3>
                    <p class="font-body text-sm text-secondary font-medium mb-3">
                        Rp {{ number_format($product->price_min) }}
                        @if($product->price_max > $product->price_min)
                            &ndash; Rp {{ number_format($product->price_max) }}
                        @endif
                    </p>
                </a>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- ============ MENGAPA MEMILIH BANINA ============ --}}
<section class="bg-primary py-16">
    <div class="container mx-auto px-4 md:px-8 text-center">
        <h2 class="font-display text-2xl md:text-3xl text-secondary-container mb-3">Mengapa Memilih {{ config('app.name', 'BANINA') }}?</h2>
        <p class="font-body text-sm text-white/60 max-w-lg mx-auto mb-12">Lebih dari sekadar pakaian, ini adalah pernyataan identitas dan ketaatan dalam bentuk karya seni busana.</p>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div class="w-12 h-12 rounded-full bg-secondary-container/20 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-award text-secondary-container"></i>
                </div>
                <h3 class="font-body text-white font-semibold mb-2">Kualitas Premium</h3>
                <p class="font-body text-sm text-white/60">Menggunakan material kain terbaik yang menjamin kenyamanan sepanjang hari</p>
            </div>
            <div>
                <div class="w-12 h-12 rounded-full bg-secondary-container/20 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-palette text-secondary-container"></i>
                </div>
                <h3 class="font-body text-white font-semibold mb-2">Desain Modern</h3>
                <p class="font-body text-sm text-white/60">Potongan kontemporer yang tetap menjaga marwah dan estetika pria muslim masa kini</p>
            </div>
            <div>
                <div class="w-12 h-12 rounded-full bg-secondary-container/20 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-mosque text-secondary-container"></i>
                </div>
                <h3 class="font-body text-white font-semibold mb-2">Sesuai Syariat</h3>
                <p class="font-body text-sm text-white/60">Dirancang khusus dengan memperhatikan batas-batas aurat dan kelayakan ibadah</p>
            </div>
            <div>
                <div class="w-12 h-12 rounded-full bg-secondary-container/20 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-store text-secondary-container"></i>
                </div>
                <h3 class="font-body text-white font-semibold mb-2">Toko Resmi Shopee</h3>
                <p class="font-body text-sm text-white/60">Belanja langsung di toko resmi kami di Shopee untuk kemudahan dan keamanan transaksi Anda</p>
            </div>
        </div>
    </div>
</section>

{{-- ============ CTA WHATSAPP ============ --}}
@if($indexWhatsapp)
<section class="py-16 container mx-auto px-4 md:px-8">
    <div class="bg-secondary-container rounded-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2 md:min-h-[480px]">
        <div class="p-10 md:p-14 flex flex-col justify-center">
            <h2 class="font-display text-2xl md:text-3xl text-primary mb-4 leading-tight">Konsultasikan Gaya<br>Modest Anda</h2>
            <p class="font-body text-sm text-on-secondary-container/80 mb-8">Bingung memilih ukuran atau model yang tepat? Tim {{ config('app.name', 'BANINA') }} siap membantu Anda memilih koleksi yang paling sesuai dengan karakter Anda.</p>
            <a href="https://wa.me/{{ $indexWhatsapp }}?text={{ urlencode($indexGreeting ?? '') }}" target="_blank"
               class="inline-flex items-center gap-2 bg-primary text-white px-7 py-3 rounded font-body text-sm font-medium hover:bg-primary-container transition-colors w-fit">
                <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
            </a>
        </div>
        <div class="block relative overflow-hidden min-h-[280px] md:min-h-[480px]">
            @if(!empty($ctaImage))
                <img src="{{ asset('assets/images/' . $ctaImage) }}"
                     alt="Konsultasi BANINA"
                     class="absolute inset-0 w-full h-full object-cover object-top">
            @else
                <div class="absolute inset-0 bg-primary/10"></div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- ============ POPUP PROMO (unchanged logic) ============ --}}
@if($popupBanner)
    <div id="customPromoModal" class="custom-popup-overlay">
        <div class="custom-popup-wrapper">
            <button type="button" class="custom-popup-close" id="closePromoBtn" aria-label="Close">&times;</button>
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