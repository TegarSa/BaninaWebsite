@extends('frontend.layouts.app')

@section('title', ($activeCategory ? $activeCategory->name : 'Katalog Produk') . ' - ' . config('app.name', 'BANINA'))

@section('content')

<div class="catalog-header">
    <div class="container">
        <h1>{{ $activeCategory ? $activeCategory->name : 'Semua Produk' }}</h1>
        <p>{{ $activeCategory ? 'Koleksi ' . $activeCategory->name . ' pilihan terbaik ' . config('app.name', 'BANINA') : 'Temukan koleksi busana muslim pria terbaik kami' }}</p>
    </div>
</div>

<div class="filter-bar">
    <div class="container filter-container">
        <span class="filter-label"><i class="fas fa-filter"></i> Filter:</span>
        <div class="filter-tags">
            <a href="{{ route('catalog') }}" class="filter-tag {{ !$categorySlug ? 'active' : '' }}">Semua</a>
            @foreach($allCategories as $cat)
                {{-- Memanggil route dengan menyematkan slug kategori langsung sebagai parameter URL clean --}}
                <a href="{{ route('catalog', $cat->slug) }}"
                   class="filter-tag {{ $categorySlug === $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
        
        {{-- Form action diarahkan langsung ke URL kategori aktif saat ini agar pencarian tetap berada di lingkup kategori tersebut --}}
        <form method="GET" action="{{ route('catalog', $categorySlug) }}" style="display:flex;gap:0.5rem">
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari produk..."
                   style="padding:0.4rem 0.8rem;border:1.5px solid #d8d0c0;border-radius:50px;font-size:0.82rem;outline:none;width:160px;font-family:inherit;color:var(--text)">
            <button type="submit" style="background:var(--black);color:var(--gold);border:none;padding:0.4rem 0.9rem;border-radius:50px;cursor:pointer;font-size:0.82rem">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<section class="section" style="padding-top:2rem">
    <div class="container">
        <p class="products-count">
            Menampilkan <strong>{{ $products->count() }}</strong> produk
            @if($activeCategory) kategori <strong>{{ $activeCategory->name }}</strong> @endif
            @if($search) untuk "<strong>{{ $search }}</strong>" @endif
        </p>

        @if($products->isNotEmpty())
            <div class="products-grid">
                @foreach($products as $prod)
                    @php
                        // Prioritaskan gambar utama, jika tidak ada pakai gambar urutan pertama
                        $img = optional($prod->images->where('is_primary', 1)->first())->image 
                            ?? optional($prod->images->first())->image;
                    @endphp
                    
                    <div class="product-card fade-in">
                        <a href="{{ url('/product/' . $prod->slug) }}" style="text-decoration:none;color:inherit;display:contents">
                            <div class="product-img-wrap">
                                @if($img)
                                    <img src="{{ asset('assets/images/' . $img) }}" alt="{{ $prod->name }}" loading="lazy">
                                @else
                                    <div class="product-placeholder"><i class="fas fa-tshirt"></i></div>
                                @endif
                                
                                @if($prod->is_featured)
                                    <span class="product-badge">Unggulan</span>
                                @endif
                            </div>
                            <div class="product-info">
                                <div class="product-cat">{{ $prod->category->name ?? '' }}</div>
                                <div class="product-name">{{ $prod->name }}</div>
                                <div class="product-price">
                                    Rp {{ number_format($prod->price_min) }}
                                    @if($prod->price_max > $prod->price_min)
                                        <span>– Rp {{ number_format($prod->price_max) }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        <div style="padding:0 1.25rem 1.25rem">
                            @if($prod->shopee_url)
                                <a href="{{ $prod->shopee_url }}" class="product-wa-btn shopee-btn" target="_blank" rel="noopener">
                                    <i class="fas fa-shopping-bag"></i> Beli di Shopee
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-search"></i>
                <h3>Produk tidak ditemukan</h3>
                <p>Coba filter atau pencarian yang berbeda</p>
                <br>
                <a href="{{ route('catalog') }}" class="btn-primary">Lihat Semua Produk</a>
            </div>
        @endif
    </div>
</section>

@endsection