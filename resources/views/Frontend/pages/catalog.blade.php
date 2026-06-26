@extends('frontend.layouts.app')

@section('title', ($activeCategory ? $activeCategory->name : 'Katalog Produk') . ' - ' . config('app.name', 'BANINA'))

@section('content')

<div class="bg-surface-container py-14 text-center">
    <div class="container mx-auto px-4 md:px-8">
        <h1 class="font-display text-3xl md:text-4xl text-primary mb-3">
            {{ $activeCategory ? $activeCategory->name : 'Semua Produk' }}
        </h1>
        <p class="font-body text-sm text-on-surface-variant max-w-xl mx-auto italic">
            {{ $activeCategory
                ? 'Koleksi ' . $activeCategory->name . ' pilihan terbaik ' . config('app.name', 'BANINA')
                : 'Koleksi busana muslim pria yang menggabungkan kesantunan tradisi dengan ketajaman gaya modern. Diciptakan untuk pria muslim yang menghargai kualitas dan estetika.' }}
        </p>
    </div>
</div>

<div class="container mx-auto px-4 md:px-8 py-10">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-10">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('catalog') }}"
               class="px-4 py-2 rounded-full font-body text-sm font-medium transition-colors {{ !$categorySlug ? 'bg-primary-container text-white' : 'border border-outline-variant text-on-surface-variant hover:border-secondary hover:text-secondary' }}">
                Semua
            </a>
            @foreach($allCategories as $cat)
                <a href="{{ route('catalog', $cat->slug) }}"
                   class="px-4 py-2 rounded-full font-body text-sm font-medium transition-colors {{ $categorySlug === $cat->slug ? 'bg-primary-container text-white' : 'border border-outline-variant text-on-surface-variant hover:border-secondary hover:text-secondary' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('catalog', $categorySlug) }}" class="flex gap-2">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm"></i>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari koleksi kami..."
                       class="pl-9 pr-4 py-2 rounded-full border border-outline-variant font-body text-sm outline-none focus:border-secondary transition-colors w-48 md:w-64">
            </div>
            <button type="submit" class="bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 hover:bg-primary-container transition-colors">
                <i class="fas fa-arrow-right text-sm"></i>
            </button>
        </form>
    </div>

    <p class="font-body text-sm text-on-surface-variant mb-6">
        Menampilkan <strong class="text-primary">{{ $products->count() }}</strong> produk
        @if($activeCategory) kategori <strong class="text-primary">{{ $activeCategory->name }}</strong> @endif
        @if($search) untuk "<strong class="text-primary">{{ $search }}</strong>" @endif
    </p>

    @if($products->isNotEmpty())
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($products as $prod)
                @php
                    $img = optional($prod->images->where('is_primary', 1)->first())->image
                        ?? optional($prod->images->first())->image;
                    $isNew = $prod->created_at && \Carbon\Carbon::parse($prod->created_at)->gt(now()->subDays(30));
                @endphp
                <div>
                    <a href="{{ url('/product/' . $prod->slug) }}" class="block">
                        <div class="relative overflow-hidden rounded mb-3 aspect-square bg-white">
                            @if($img)
                                <img class="w-full h-full object-cover transition-soft hover:scale-105" src="{{ asset('assets/images/' . $img) }}" alt="{{ $prod->name }}" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-secondary/30">
                                    <i class="fas fa-tshirt text-3xl"></i>
                                </div>
                            @endif
                            @if($prod->is_featured)
                                <span class="absolute top-2 left-2 bg-secondary-container text-on-secondary-container text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded">Unggulan</span>
                            @elseif($isNew)
                                <span class="absolute top-2 left-2 bg-primary text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded">Baru</span>
                            @endif
                        </div>
                        <p class="font-body text-[11px] uppercase tracking-wider text-on-surface-variant mb-1">{{ $prod->category->name ?? '' }}</p>
                        <h3 class="font-display text-base text-primary mb-1 leading-snug">{{ $prod->name }}</h3>
                        <p class="font-body text-sm text-secondary font-medium mb-3">
                            Rp {{ number_format($prod->price_min) }}
                            @if($prod->price_max > $prod->price_min)
                                &ndash; Rp {{ number_format($prod->price_max) }}
                            @endif
                        </p>
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
    @else
        <div class="text-center py-20">
            <i class="fas fa-search text-4xl text-secondary/30 mb-4"></i>
            <h3 class="font-display text-xl text-primary mb-2">Produk tidak ditemukan</h3>
            <p class="font-body text-sm text-on-surface-variant mb-6">Coba filter atau pencarian yang berbeda</p>
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-primary-container text-white px-8 py-3 rounded-full font-body text-sm hover:bg-primary transition-colors">
                Lihat Semua Produk
            </a>
        </div>
    @endif
</div>

@endsection