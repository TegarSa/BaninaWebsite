@extends('frontend.layouts.app')

@section('title', 'Tentang Kami - ' . config('app.name', 'BANINA'))

@section('content')

@php
    $aboutWhatsapp = \App\Models\Setting::getValue('whatsapp_number');
    $aboutText = \App\Models\Setting::getValue('about_text') ?? 'Kami berkomitmen untuk menghadirkan pilihan busana muslim pria berkualitas tinggi yang memadukan keindahan estetika dengan nilai-nilai islami.';
    $aboutImg = \App\Models\Setting::getValue('about_image');
    $shopeeRating = trim((string) \App\Models\Setting::getValue('shopee_rating')) ?: '4.9';
    $aboutCategoryCount = \App\Models\Category::where('is_active', 1)->count();
@endphp

<div class="bg-surface-container py-14 text-center">
    <div class="container mx-auto px-4 md:px-8">
        <span class="inline-block bg-secondary-container text-on-secondary-container font-body text-[11px] font-semibold uppercase tracking-wider px-3 py-1 rounded-full mb-4">Modern Modesty</span>
        <h1 class="font-display text-3xl md:text-4xl text-primary mb-3">Tentang {{ config('app.name', 'BANINA') }}</h1>
        <p class="font-body text-sm text-on-surface-variant max-w-xl mx-auto">Mengenal kami lebih dekat — komitmen kualitas dan kesantunan dalam setiap jahitan.</p>
    </div>
</div>

<div class="container mx-auto px-4 md:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <div class="rounded-lg overflow-hidden editorial-shadow aspect-[4/5] bg-primary/5">
            @if($aboutImg)
                <img src="{{ asset('assets/images/' . $aboutImg) }}" alt="Tentang {{ config('app.name', 'BANINA') }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-secondary/30">
                    <i class="fas fa-store text-6xl"></i>
                </div>
            @endif
        </div>

        <div>
            <span class="font-body text-xs uppercase tracking-[0.2em] text-secondary mb-3 block">Kisah Kami</span>
            <h2 class="font-display text-2xl md:text-3xl text-primary mb-5 leading-tight">
                Busana Muslim Pria <em class="text-secondary">Premium</em> Sejak 2019
            </h2>
            <p class="font-body text-sm text-on-surface-variant leading-relaxed mb-4 whitespace-pre-line">{{ $aboutText }}</p>
            <p class="font-body text-sm text-on-surface-variant leading-relaxed mb-6">
                Kami berkomitmen untuk menghadirkan pilihan busana muslim pria berkualitas tinggi yang memadukan keindahan estetika dengan nilai-nilai islami, sehingga setiap pria bisa tampil percaya diri dan elegan.
            </p>
            @if($aboutWhatsapp)
                <a href="https://wa.me/{{ $aboutWhatsapp }}" target="_blank"
                   class="inline-flex items-center gap-2 bg-primary-container text-white px-7 py-3 rounded font-body text-sm font-medium hover:bg-primary transition-colors">
                    <i class="fab fa-whatsapp"></i> Hubungi Kami
                </a>
            @endif
        </div>
    </div>
</div>

{{-- ============ NILAI KAMI ============ --}}
<div class="bg-surface-container py-16">
    <div class="container mx-auto px-4 md:px-8 text-center">
        <span class="font-body text-xs uppercase tracking-[0.2em] text-secondary mb-3 block">Nilai Kami</span>
        <h2 class="font-display text-2xl md:text-3xl text-primary mb-12">Komitmen {{ config('app.name', 'BANINA') }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg p-7 border border-outline-variant">
                <div class="w-12 h-12 rounded-full bg-secondary-container/30 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-award text-secondary"></i>
                </div>
                <h3 class="font-body font-semibold text-primary mb-2">Kualitas Terjamin</h3>
                <p class="font-body text-sm text-on-surface-variant">Setiap produk melalui seleksi ketat untuk memastikan kualitas terbaik sampai ke tangan Anda</p>
            </div>
            <div class="bg-white rounded-lg p-7 border border-outline-variant">
                <div class="w-12 h-12 rounded-full bg-secondary-container/30 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-mosque text-secondary"></i>
                </div>
                <h3 class="font-body font-semibold text-primary mb-2">Islami & Elegan</h3>
                <p class="font-body text-sm text-on-surface-variant">Desain yang memadukan nilai kesopanan islami dengan tampilan modern dan stylish</p>
            </div>
            <div class="bg-white rounded-lg p-7 border border-outline-variant">
                <div class="w-12 h-12 rounded-full bg-secondary-container/30 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-secondary"></i>
                </div>
                <h3 class="font-body font-semibold text-primary mb-2">Kepuasan Pelanggan</h3>
                <p class="font-body text-sm text-on-surface-variant">Kepuasan Anda adalah prioritas utama kami dalam setiap pelayanan</p>
            </div>
            <div class="bg-white rounded-lg p-7 border border-outline-variant">
                <div class="w-12 h-12 rounded-full bg-secondary-container/30 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-secondary"></i>
                </div>
                <h3 class="font-body font-semibold text-primary mb-2">Terpercaya</h3>
                <p class="font-body text-sm text-on-surface-variant">Telah melayani pelanggan setia sejak 2019 dengan reputasi terbaik</p>
            </div>
        </div>
    </div>
</div>

{{-- ============ STATISTIK ============ --}}
<div class="bg-primary py-14">
    <div class="container mx-auto px-4 md:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <p class="font-display text-3xl md:text-4xl font-bold text-secondary-container">2019</p>
                <p class="font-body text-xs text-white/60 uppercase tracking-wider mt-2">Berdiri Sejak</p>
            </div>
            <div>
                <p class="font-display text-3xl md:text-4xl font-bold text-secondary-container">{{ $aboutCategoryCount }}+</p>
                <p class="font-body text-xs text-white/60 uppercase tracking-wider mt-2">Kategori Produk</p>
            </div>
            <div>
                <p class="font-display text-3xl md:text-4xl font-bold text-secondary-container">1000+</p>
                <p class="font-body text-xs text-white/60 uppercase tracking-wider mt-2">Pelanggan Puas</p>
            </div>
            <div>
                <p class="font-display text-3xl md:text-4xl font-bold text-secondary-container">⭐ {{ $shopeeRating }}</p>
                <p class="font-body text-xs text-white/60 uppercase tracking-wider mt-2">Rating Toko</p>
            </div>
        </div>
    </div>
</div>

@endsection