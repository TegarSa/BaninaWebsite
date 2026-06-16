@extends('dashboard.layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Row Statistik Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 p-3 d-flex flex-row align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center text-white bg-dark" style="width: 56px; height: 56px; font-size: 1.5rem;">
                <i class="fas fa-tshirt"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0 text-dark">{{ $totalProducts }}</h3>
                <span class="text-muted small">Total Produk</span>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 p-3 d-flex flex-row align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 56px; height: 56px; font-size: 1.5rem; background-color: var(--admin-gold);">
                <i class="fas fa-tags"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0 text-dark">{{ $totalCategories }}</h3>
                <span class="text-muted small">Kategori Aktif</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 p-3 d-flex flex-row align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center text-white bg-success" style="width: 56px; height: 56px; font-size: 1.5rem;">
                <i class="fas fa-images"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0 text-dark">{{ $totalBanners }}</h3>
                <span class="text-muted small">Banner Aktif</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 p-3 d-flex flex-row align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center text-white bg-primary" style="width: 56px; height: 56px; font-size: 1.5rem;">
                <i class="fas fa-star"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0 text-dark">{{ $featuredProducts }}</h3>
                <span class="text-muted small">Produk Unggulan</span>
            </div>
        </div>
    </div>
</div>

<!-- Menu Aksi Cepat -->
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ url('/admin/products/create') }}" class="btn btn-gold shadow-sm">
        <i class="fas fa-plus me-1"></i> Tambah Produk
    </a>
    <a href="{{ url('/admin/categories') }}" class="btn btn-light border shadow-sm text-dark">
        <i class="fas fa-tags me-1 text-muted"></i> Kelola Kategori
    </a>
    <a href="{{ url('/admin/banners') }}" class="btn btn-light border shadow-sm text-dark">
        <i class="fas fa-images me-1 text-muted"></i> Kelola Banner
    </a>
    <a href="{{ url('/admin/settings') }}" class="btn btn-light border shadow-sm text-dark">
        <i class="fas fa-cog me-1 text-muted"></i> Pengaturan
    </a>
</div>

<!-- Tabel Produk Terbaru Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-0">
        <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;"><i class="fas fa-history text-muted me-2"></i>Produk Terbaru</h5>
        <a href="{{ url('/admin/products') }}" class="btn btn-outline-dark btn-sm fw-medium">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle table-hover mb-0">
            <thead class="table-light text-secondary small text-uppercase">
                <tr>
                    <th class="ps-4">Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th class="text-center pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentProducts as $p)
                    @php
                        $thumb = optional($p->images->where('is_primary', 1)->first())->image 
                            ?? optional($p->images->first())->image;
                    @endphp
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                @if ($thumb)
                                    <img src="{{ asset('assets/images/' . $thumb) }}" class="rounded border" style="width: 44px; height: 44px; object-fit: cover;" alt="Product">
                                @else
                                    <div class="bg-light text-muted border rounded d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.1rem;">
                                        <i class="fas fa-tshirt"></i>
                                    </div>
                                @endif
                                <span class="fw-semibold text-dark">{{ $p->name }}</span>
                            </div>
                        </td>
                        <td class="text-secondary">{{ $p->category->name ?? '-' }}</td>
                        <td class="fw-medium text-dark">Rp {{ number_format($p->price_min) }}</td>
                        <td>
                            <span class="badge rounded-pill {{ $p->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }} px-2.5 py-1">
                                {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            @if ($p->is_featured)
                                <span class="badge rounded-pill badge-gold px-2.5 py-1 ms-1">Unggulan</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            <a href="{{ url('/admin/products/' . $p->id . '/edit') }}" class="btn btn-sm btn-outline-secondary px-2.5">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada produk yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection