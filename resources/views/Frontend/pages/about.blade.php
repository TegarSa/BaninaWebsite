@extends('frontend.layouts.app')

@section('title', 'Tentang Kami - ' . config('app.name', 'BANINA'))

@section('content')

@php
    $aboutWhatsapp = \App\Models\Setting::getValue('whatsapp_number');
    $aboutText     = \App\Models\Setting::getValue('about_text') ?? 'Kami berkomitmen untuk menghadirkan pilihan busana muslim pria berkualitas tinggi yang memadukan keindahan estetika dengan nilai-nilai islami.';
    $aboutImg      = \App\Models\Setting::getValue('about_image');
    $shopeeRating  = trim(\App\Models\Setting::getValue('shopee_rating')) ?: '4.9';
@endphp

{{-- Page header --}}
<div class="about-header">
    <div class="container">
        <span class="section-label" style="display:block;margin-bottom:12px">Kisah Kami</span>
        <h1>Tentang {{ config('app.name', 'BANINA') }}</h1>
        <p>Mengenal kami lebih dekat — busana muslim pria premium sejak 2019</p>
    </div>
</div>

{{-- Main about section --}}
<section class="section">
    <div class="container">
        <div class="about-grid">

            {{-- Image --}}
            <div class="about-img-wrap fade-in">
                @if($aboutImg)
                    <img src="{{ asset('assets/images/' . $aboutImg) }}" alt="Tentang {{ config('app.name', 'BANINA') }}">
                @else
                    <div style="width:100%;height:100%;min-height:400px;display:flex;align-items:center;justify-content:center;background:var(--ivory-mid);font-size:5rem;color:var(--outline)">
                        <i class="fas fa-store"></i>
                    </div>
                @endif
            </div>

            {{-- Text --}}
            <div class="about-content fade-in">
                <span class="section-label" style="display:block;margin-bottom:14px">Busana Muslim Pria Premium</span>
                <h2>Kenyamanan Beribadah, Keanggunan Penampilan</h2>

                <p style="margin-top:20px">{!! nl2br(e($aboutText)) !!}</p>

                <p>Kami berkomitmen untuk menghadirkan pilihan busana muslim pria berkualitas tinggi yang memadukan keindahan estetika dengan nilai-nilai islami, sehingga setiap pria bisa tampil percaya diri dan elegan.</p>

                @if($aboutWhatsapp)
                    <a href="https://wa.me/{{ $aboutWhatsapp }}" class="btn-primary"
                       target="_blank" style="display:inline-flex;margin-top:2rem">
                        <i class="fab fa-whatsapp"></i> Hubungi Kami
                    </a>
                @endif
            </div>

        </div>
    </div>
</section>

{{-- Values --}}
<section class="section section-bg-dark">
    <div class="container">
        <div class="section-header fade-in">
            <span class="section-label">Nilai Kami</span>
            <h2 class="section-title">Komitmen {{ config('app.name', 'BANINA') }}</h2>
            <div class="divider"><span class="divider-icon">✦</span></div>
        </div>

        <div class="values-grid">
            <div class="value-card fade-in">
                <div class="value-icon"><i class="fas fa-award"></i></div>
                <h3>Kualitas Terjamin</h3>
                <p>Setiap produk melalui seleksi ketat untuk memastikan kualitas terbaik sampai ke tangan Anda</p>
            </div>
            <div class="value-card fade-in">
                <div class="value-icon"><i class="fas fa-mosque"></i></div>
                <h3>Islami & Elegan</h3>
                <p>Desain yang memadukan nilai kesopanan islami dengan tampilan modern dan stylish</p>
            </div>
            <div class="value-card fade-in">
                <div class="value-icon"><i class="fas fa-heart"></i></div>
                <h3>Kepuasan Pelanggan</h3>
                <p>Kepuasan Anda adalah prioritas utama kami dalam setiap pelayanan</p>
            </div>
            <div class="value-card fade-in">
                <div class="value-icon"><i class="fas fa-handshake"></i></div>
                <h3>Terpercaya</h3>
                <p>Telah melayani ribuan pelanggan setia sejak 2019 dengan reputasi terbaik</p>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="section" style="background:var(--onyx);padding:4rem 0">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:2rem;text-align:center">
            <div class="fade-in">
                <div style="font-family:var(--font-serif);font-size:3rem;font-weight:700;color:var(--olive-light)">2019</div>
                <div style="color:rgba(255,255,255,0.5);font-size:11px;font-weight:600;letter-spacing:0.15em;text-transform:uppercase;margin-top:6px">Berdiri Sejak</div>
            </div>
            <div class="fade-in">
                <div style="font-family:var(--font-serif);font-size:3rem;font-weight:700;color:var(--olive-light)">5+</div>
                <div style="color:rgba(255,255,255,0.5);font-size:11px;font-weight:600;letter-spacing:0.15em;text-transform:uppercase;margin-top:6px">Kategori Produk</div>
            </div>
            <div class="fade-in">
                <div style="font-family:var(--font-serif);font-size:3rem;font-weight:700;color:var(--olive-light)">1000+</div>
                <div style="color:rgba(255,255,255,0.5);font-size:11px;font-weight:600;letter-spacing:0.15em;text-transform:uppercase;margin-top:6px">Pelanggan Puas</div>
            </div>
            <div class="fade-in">
                <div style="font-family:var(--font-serif);font-size:3rem;font-weight:700;color:var(--olive-light)">⭐ {{ $shopeeRating }}</div>
                <div style="color:rgba(255,255,255,0.5);font-size:11px;font-weight:600;letter-spacing:0.15em;text-transform:uppercase;margin-top:6px">Rating Toko</div>
            </div>
        </div>
    </div>
</section>

@endsection
