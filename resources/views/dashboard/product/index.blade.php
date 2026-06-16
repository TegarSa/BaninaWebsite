@extends('dashboard.layouts.app')

@section('title', 'Kelola Produk')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex flex-wrap align-items-center justify-content-between gap-2 border-0">
        <span class="fw-bold text-dark" style="font-size: 1.1rem;">Daftar Produk ({{ count($products) }})</span>
        <a href="{{ route('products.create') }}" class="btn btn-gold btn-sm shadow-sm"><i class="fas fa-plus me-1"></i> Tambah Produk</a>
    </div>

    <!-- Filter Form -->
    <div class="p-3 bg-light border-bottom border-top">
        <form method="GET" action="{{ route('products.index') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0 text-muted">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="q" value="{{ $search }}" class="form-control border-start-0 ps-0" placeholder="Cari nama produk..." style="box-shadow: none;">
                </div>
            </div>

            <div class="col-12 col-md-3">
                <select name="cat" class="form-select form-select-sm" style="box-shadow: none;">
                    <option value="">Semua Kategori</option>
                    @foreach ($allCats as $cat)
                        <option value="{{ $cat->id }}" {{ $catFilter == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-auto d-flex gap-2">
                <button type="submit" class="btn btn-sm px-3 text-white fw-medium rounded-2" style="background-color: #1a1e21; border: 1px solid #1a1e21;">
                    <i class="fas fa-sliders-h me-1"></i> Filter
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-2 fw-medium">
                    <i class="fas fa-sync-alt me-1" style="font-size: 0.75rem;"></i> Reset
                </a>
            </div>
        </form>
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
                @forelse ($products as $p)
                    @php
                        $thumb = optional($p->images->where('is_primary', 1)->first())->image ?? optional($p->images->first())->image;
                    @endphp
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                @if ($thumb)
                                    <img src="{{ asset('assets/images/' . $thumb) }}" class="rounded border" style="width: 48px; height: 48px; object-fit: cover;">
                                @else
                                    <div class="bg-light border text-muted rounded d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.2rem;">
                                        <i class="fas fa-tshirt"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark mb-0" style="font-size:0.9rem;">{{ $p->name }}</div>
                                    <small class="text-muted text-break d-block" style="font-size:0.75rem;">{{ $p->slug }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-secondary fw-medium">{{ $p->category->name ?? '-' }}</td>
                        <td class="text-dark fw-medium">
                            Rp {{ number_format($p->price_min) }}
                            @if ($p->price_max > $p->price_min)
                                <span class="text-muted fw-normal" style="font-size: 0.85rem;"> – Rp {{ number_format($p->price_max) }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="badge rounded-pill {{ $p->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }} px-2 py-1">
                                    {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                @if ($p->is_featured)
                                    <span class="badge rounded-pill badge-gold border px-2 py-1">Unggulan</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('products.edit', $p->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="fas fa-edit"></i></a>
                                
                                <form action="{{ route('products.toggle-feature', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="Unggulan"><i class="fas fa-star" style="color: {{ $p->is_featured ? '#7a8c2a' : 'inherit' }}"></i></button>
                                </form>

                                <form action="{{ route('products.toggle-active', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="Toggle Aktif"><i class="fas fa-toggle-{{ $p->is_active ? 'on' : 'off' }}"></i></button>
                                </form>

                                <a href="{{ url('/product/' . $p->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank" title="Lihat"><i class="fas fa-eye"></i></a>

                                <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger text-white" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Data produk tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white border-top py-3 d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
        <div class="text-muted small fw-medium">
            Menampilkan <span class="text-dark fw-bold">{{ $products->firstItem() ?? 0 }}</span> 
            sampai <span class="text-dark fw-bold">{{ $products->lastItem() ?? 0 }}</span> 
            dari <span class="text-dark fw-bold">{{ $products->total() }}</span> data
        </div>
        
        <div class="mb-0">
            @if ($products->total() <= $products->perPage())
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0 gap-1">
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link rounded-2 border-0 bg-light text-muted d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fas fa-chevron-left" style="font-size: 0.75rem;"></i>
                            </span>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <span class="page-link rounded-2 border-0 d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; background-color: #4e5d6c; color: #fff;">1</span>
                        </li>
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link rounded-2 border-0 bg-light text-muted d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fas fa-chevron-right" style="font-size: 0.75rem;"></i>
                            </span>
                        </li>
                    </ul>
                </nav>
            @else
                {{ $products->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>
</div>

@endsection