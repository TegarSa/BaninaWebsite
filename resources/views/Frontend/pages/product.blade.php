@extends('frontend.layouts.app')

@section('title', $product->name . ' - ' . config('app.name', 'BANINA'))

@section('content')

<div class="product-detail">
    <div class="container">
        <div class="detail-grid">
            <!-- Images -->
            <div class="detail-images">
                <div class="main-image">
                    @if($mainImg)
                        <img src="{{ asset('assets/images/' . $mainImg) }}" alt="{{ $product->name }}" id="mainImage">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f0ece4,#e8e0d0);font-size:5rem;color:var(--gold)">
                            <i class="fas fa-tshirt"></i>
                        </div>
                    @endif
                </div>
                
                @if($images->count() > 1)
                    <div class="thumb-row">
                        @foreach($images as $i => $img)
                            <div class="thumb {{ $i === 0 ? 'active' : '' }}" data-src="{{ asset('assets/images/' . $img->image) }}">
                                <img src="{{ asset('assets/images/' . $img->image) }}" alt="Thumbnail {{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="detail-info">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <i class="fas fa-chevron-right" style="font-size:0.65rem"></i>
                    <a href="{{ route('catalog') }}">Produk</a>
                    @if($product->category)
                        <i class="fas fa-chevron-right" style="font-size:0.65rem"></i>
                        <a href="{{ route('catalog', $product->category->slug) }}">{{ $product->category->name }}</a>
                    @endif
                </div>

                @if($product->category)
                    <span class="detail-cat-badge">{{ $product->category->name }}</span>
                @endif
                @if($product->is_featured)
                    <span class="detail-cat-badge" style="background:var(--gold);color:var(--black);border-color:var(--gold);margin-left:0.5rem">⭐ Unggulan</span>
                @endif

                <h1>{{ $product->name }}</h1>

                <div class="detail-price">
                    @if(!empty($product->price_max) && $product->price_max > $product->price_min)
                        Rp {{ number_format($product->price_min) }} - Rp {{ number_format($product->price_max) }}
                    @else
                        Rp {{ number_format($product->price_min) }}
                    @endif
                </div>

                <div class="detail-divider"></div>

                @if($product->description)
                    <div class="detail-section">
                        <h3 class="detail-subtitle">Deskripsi Produk</h3>
                        <div class="detail-desc">{!! nl2br(e($product->description)) !!}</div>
                    </div>
                @endif

                <div style="margin-top:1.5rem">
                    @if($product->shopee_url)
                        <a href="{{ $product->shopee_url }}" class="detail-wa-btn shopee-btn" target="_blank" rel="noopener">
                            <i class="fas fa-shopping-bag"></i> Beli di Shopee
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->isNotEmpty())
    <section class="section section-bg-dark">
        <div class="container">
            <div class="section-header fade-in">
                <span class="section-label">Kategori Sama</span>
                <h2 class="section-title">Produk Lainnya</h2>
                <div class="divider"><span class="divider-icon">✦</span></div>
            </div>
            <div class="products-grid">
                @foreach($relatedProducts as $prod)
                    @php
                        $rImg = optional($prod->images->where('is_primary', 1)->first())->image 
                            ?? optional($prod->images->first())->image;
                    @endphp
                    <div class="product-card fade-in">
                        <a href="{{ route('product.show', $prod->slug) }}" style="text-decoration:none;color:inherit;display:contents">
                            <div class="product-img-wrap">
                                @if($rImg)
                                    <img src="{{ asset('assets/images/' . $rImg) }}" alt="{{ $prod->name }}" loading="lazy">
                                @else
                                    <div class="product-placeholder"><i class="fas fa-tshirt"></i></div>
                                @endif
                            </div>
                            <div class="product-info">
                                <div class="product-name">{{ $prod->name }}</div>
                                <div class="product-price">Rp {{ number_format($prod->price_min) }}</div>
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
        </div>
    </section>
@endif

@endsection