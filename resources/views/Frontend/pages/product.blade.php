@extends('frontend.layouts.app')

@section('title', $product->name . ' - ' . config('app.name', 'BANINA'))

@section('content')

@php
    $waNumber  = \App\Models\Setting::getValue('whatsapp_number');
    $waGreeting = \App\Models\Setting::getValue('whatsapp_greeting');
    $waText = urlencode(($waGreeting ?? '') . ' Saya tertarik dengan produk: ' . $product->name);
@endphp

{{-- ============ BREADCRUMB ============ --}}
<div class="container mx-auto px-4 md:px-8 pt-6 pb-2">
    <div class="flex items-center gap-2 font-body text-xs text-on-surface-variant flex-wrap uppercase tracking-widest">
        <a href="{{ route('catalog') }}" class="hover:text-secondary transition-colors">Koleksi</a>
        @if($product->category)
            <span>›</span>
            <a href="{{ route('catalog', $product->category->slug) }}" class="hover:text-secondary transition-colors">{{ $product->category->name }}</a>
        @endif
        <span>›</span>
        <span class="text-primary">{{ $product->name }}</span>
    </div>
</div>

{{-- ============ MAIN DETAIL ============ --}}
<div class="container mx-auto px-4 md:px-8 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16">

        {{-- GALERI --}}
        <div>
            {{-- Foto Utama --}}
            <div class="relative overflow-hidden rounded-xl aspect-[3/4] bg-surface-container mb-4">
                @if($mainImg)
                    <img id="mainImageDetail"
                         src="{{ asset('assets/images/' . $mainImg) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-secondary/30">
                        <i class="fas fa-tshirt text-6xl"></i>
                    </div>
                @endif
            </div>

            {{-- Thumbnail --}}
            @if($images->count() > 1)
                <div class="grid grid-cols-4 gap-3">
                    @foreach($images as $i => $img)
                        <button type="button"
                                class="thumb-detail aspect-square rounded-lg overflow-hidden border-2 {{ $i === 0 ? 'border-secondary' : 'border-transparent' }} hover:border-secondary transition-colors"
                                data-src="{{ asset('assets/images/' . $img->image) }}">
                            <img src="{{ asset('assets/images/' . $img->image) }}"
                                 alt="Thumbnail {{ $i + 1 }}"
                                 class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- INFO PRODUK --}}
        <div class="flex flex-col pt-2">

            @if($product->category)
                <span class="font-body text-xs uppercase tracking-[0.2em] text-on-surface-variant mb-2">{{ $product->category->name }}</span>
            @endif

            <h1 class="font-display text-3xl md:text-4xl text-primary mb-4 leading-tight">{{ $product->name }}</h1>

            <p class="font-display text-2xl text-secondary mb-6">
                Rp {{ number_format($product->price_min) }}
                @if(!empty($product->price_max) && $product->price_max > $product->price_min)
                    &ndash; Rp {{ number_format($product->price_max) }}
                @endif
            </p>

            @if($product->description)
                <p class="font-body text-sm text-on-surface-variant leading-relaxed whitespace-pre-line mb-6 border-l-2 border-secondary pl-4">
                    {{ $product->description }}
                </p>
            @endif

            <div class="h-px bg-outline-variant mb-6"></div>

            {{-- Tombol Aksi --}}
            <div class="flex flex-col gap-3 mb-8">
                @if($waNumber)
                    <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-3 bg-primary text-white px-8 py-4 rounded font-body text-sm font-medium hover:bg-primary-container transition-colors">
                        <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                    </a>
                @endif
                @if($product->shopee_url)
                    <a href="{{ $product->shopee_url }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-3 bg-[#EE4D2D] text-white px-8 py-4 rounded font-body text-sm font-medium hover:bg-[#d93e20] transition-colors">
                        <i class="fas fa-shopping-bag"></i> Beli di Shopee
                    </a>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- ============ PRODUK LAINNYA ============ --}}
@if($relatedProducts->isNotEmpty())
<section class="py-16 bg-surface-container mt-8">
    <div class="container mx-auto px-4 md:px-8">
        <div class="mb-3">
            <p class="font-body text-xs uppercase tracking-widest text-on-surface-variant mb-1">Kurasi Pilihan</p>
            <div class="flex items-end justify-between">
                <h2 class="font-display text-2xl md:text-3xl text-primary">Lengkapi Penampilan</h2>
                @if($product->category)
                    <a href="{{ route('catalog', $product->category->slug) }}" class="font-body text-xs uppercase tracking-widest text-on-surface-variant hover:text-secondary transition-colors">Lihat Semua</a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-8">
            @foreach($relatedProducts->take(3) as $prod)
                @php
                    $rImg = optional($prod->images->where('is_primary', 1)->first())->image
                        ?? optional($prod->images->first())->image;
                @endphp
                <a href="{{ route('product.show', $prod->slug) }}" class="group block">
                    <div class="relative overflow-hidden rounded-xl aspect-[3/4] bg-white mb-4">
                        @if($rImg)
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 src="{{ asset('assets/images/' . $rImg) }}"
                                 alt="{{ $prod->name }}"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-secondary/30">
                                <i class="fas fa-tshirt text-3xl"></i>
                            </div>
                        @endif
                        @if($prod->category)
                            <span class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm font-body text-[10px] uppercase tracking-widest text-primary px-2.5 py-1 rounded">
                                {{ $prod->category->name }}
                            </span>
                        @endif
                    </div>
                    <h3 class="font-display text-base text-primary mb-1 leading-snug">{{ $prod->name }}</h3>
                    <p class="font-body text-sm text-secondary">Rp {{ number_format($prod->price_min) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Thumbnail switcher
    const mainImg = document.getElementById('mainImageDetail');
    document.querySelectorAll('.thumb-detail').forEach(thumb => {
        thumb.addEventListener('click', function () {
            if (mainImg) mainImg.src = this.dataset.src;
            document.querySelectorAll('.thumb-detail').forEach(t => {
                t.classList.remove('border-secondary');
                t.classList.add('border-transparent');
            });
            this.classList.remove('border-transparent');
            this.classList.add('border-secondary');
        });
    });

    // Accordion
    document.querySelectorAll('.accordion-trigger').forEach(trigger => {
        trigger.addEventListener('click', function () {
            const content = this.nextElementSibling;
            const icon = this.querySelector('i');
            const isOpen = !content.classList.contains('hidden');

            // Tutup semua
            document.querySelectorAll('.accordion-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.accordion-trigger i').forEach(i => i.style.transform = '');

            // Buka yang diklik (jika sebelumnya tertutup)
            if (!isOpen) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
});
</script>
@endpush