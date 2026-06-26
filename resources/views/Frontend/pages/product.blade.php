@extends('frontend.layouts.app')

@section('title', $product->name . ' - ' . config('app.name', 'BANINA'))

@section('content')

<div class="container mx-auto px-4 md:px-8 py-10">

    <div class="flex items-center gap-2 font-body text-xs text-on-surface-variant mb-8 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-secondary transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('catalog') }}" class="hover:text-secondary transition-colors">Produk</a>
        @if($product->category)
            <span>/</span>
            <a href="{{ route('catalog', $product->category->slug) }}" class="hover:text-secondary transition-colors">{{ $product->category->name }}</a>
        @endif
        <span>/</span>
        <span class="text-primary font-medium">{{ $product->name }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16">

        {{-- ============ GALERI ============ --}}
        <div class="flex flex-col md:flex-row gap-4">
            @if($images->count() > 1)
                <div class="flex md:flex-col gap-3 order-2 md:order-1">
                    @foreach($images as $i => $img)
                        <button type="button" class="thumb-detail w-16 h-16 md:w-20 md:h-20 rounded overflow-hidden border-2 {{ $i === 0 ? 'border-secondary' : 'border-outline-variant' }} flex-shrink-0"
                                data-src="{{ asset('assets/images/' . $img->image) }}">
                            <img src="{{ asset('assets/images/' . $img->image) }}" alt="Thumbnail {{ $product->name }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif

            <div class="relative flex-1 order-1 md:order-2 rounded overflow-hidden aspect-square bg-white editorial-shadow">
                @if($product->is_featured)
                    <span class="absolute top-3 left-3 z-10 bg-secondary-container text-on-secondary-container text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded">⭐ Unggulan</span>
                @endif
                @if($mainImg)
                    <img id="mainImageDetail" src="{{ asset('assets/images/' . $mainImg) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-secondary/30">
                        <i class="fas fa-tshirt text-6xl"></i>
                    </div>
                @endif
            </div>
        </div>

        {{-- ============ INFO ============ --}}
        <div class="flex flex-col">
            @if($product->category)
                <span class="font-body text-xs uppercase tracking-[0.15em] text-secondary mb-2">{{ $product->category->name }}</span>
            @endif

            <h1 class="font-display text-2xl md:text-3xl text-primary mb-4 leading-tight">{{ $product->name }}</h1>

            <div class="flex items-center gap-3 mb-6">
                <p class="font-display text-xl text-primary">
                    Rp {{ number_format($product->price_min) }}
                    @if(!empty($product->price_max) && $product->price_max > $product->price_min)
                        &ndash; Rp {{ number_format($product->price_max) }}
                    @endif
                </p>
                <span class="bg-secondary-container/30 text-on-secondary-container font-body text-[11px] uppercase tracking-wider px-3 py-1 rounded-full">Tersedia</span>
            </div>

            <div class="h-px bg-outline-variant mb-6"></div>

            @if($product->description)
                <div class="mb-8">
                    <h3 class="font-body text-sm font-semibold text-primary uppercase tracking-wider mb-3">Deskripsi Produk</h3>
                    <div class="font-body text-sm text-on-surface-variant leading-relaxed whitespace-pre-line">{{ $product->description }}</div>
                </div>
            @endif

            @if($product->shopee_url)
                <a href="{{ $product->shopee_url }}" target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center gap-3 bg-primary-container text-white px-10 py-3.5 rounded font-body text-sm font-medium editorial-shadow hover:bg-primary transition-colors w-full md:w-auto">
                    <i class="fas fa-shopping-bag"></i> Beli di Shopee
                </a>
            @endif

            <div class="flex flex-wrap gap-8 mt-10 pt-8 border-t border-outline-variant">
                <div class="flex items-center gap-3">
                    <i class="fas fa-truck text-secondary"></i>
                    <span class="font-body text-xs text-on-surface-variant">Pengiriman ke<br>Seluruh Indonesia</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-certificate text-secondary"></i>
                    <span class="font-body text-xs text-on-surface-variant">Bahan Pilihan<br>Berkualitas Premium</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ PRODUK LAINNYA ============ --}}
@if($relatedProducts->isNotEmpty())
<section class="bg-surface-container py-16">
    <div class="container mx-auto px-4 md:px-8">
        <div class="flex items-center justify-between mb-10">
            <h2 class="font-display text-2xl text-primary">Produk Lainnya</h2>
            @if($product->category)
                <a href="{{ route('catalog', $product->category->slug) }}" class="font-body text-sm text-secondary underline underline-offset-4 hover:decoration-2">Lihat Semua →</a>
            @endif
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($relatedProducts as $prod)
                @php
                    $rImg = optional($prod->images->where('is_primary', 1)->first())->image
                        ?? optional($prod->images->first())->image;
                @endphp
                <div>
                    <a href="{{ route('product.show', $prod->slug) }}" class="block">
                        <div class="relative overflow-hidden rounded mb-3 aspect-square bg-white">
                            @if($rImg)
                                <img class="w-full h-full object-cover transition-soft hover:scale-105" src="{{ asset('assets/images/' . $rImg) }}" alt="{{ $prod->name }}" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-secondary/30">
                                    <i class="fas fa-tshirt text-3xl"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="font-display text-base text-primary mb-1 leading-snug">{{ $prod->name }}</h3>
                        <p class="font-body text-sm text-secondary font-medium mb-3">Rp {{ number_format($prod->price_min) }}</p>
                    </a>
                    @if($prod->shopee_url)
                        <a href="{{ $prod->shopee_url }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 border border-outline-variant rounded px-3 py-2 font-body text-xs text-on-surface-variant hover:border-secondary hover:text-secondary transition-colors w-full justify-center">
                            <i class="fas fa-shopping-bag"></i> Beli di Shopee
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mainImg = document.getElementById('mainImageDetail');
        document.querySelectorAll('.thumb-detail').forEach(thumb => {
            thumb.addEventListener('click', function () {
                if (mainImg) mainImg.src = this.dataset.src;
                document.querySelectorAll('.thumb-detail').forEach(t => {
                    t.classList.remove('border-secondary');
                    t.classList.add('border-outline-variant');
                });
                this.classList.remove('border-outline-variant');
                this.classList.add('border-secondary');
            });
        });
    });
</script>
@endpush