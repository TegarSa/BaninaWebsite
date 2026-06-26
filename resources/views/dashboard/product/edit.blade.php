@extends('dashboard.layouts.app')

@section('title', 'Edit Produk')

@section('content')

<div class="mb-3">
    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <!-- Informasi Pokok Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3"><h6 class="fw-bold text-dark mb-0">Informasi Produk</h6></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">Nama Produk *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">Kategori *</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($allCats as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-secondary small">Harga Minimal (Rp) *</label>
                            <input type="number" name="price_min" value="{{ old('price_min', $product->price_min) }}" class="form-control" min="1" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-secondary small">Harga Maksimal (Rp) <span class="text-muted">(Opsional)</span></label>
                            <input type="number" name="price_max" value="{{ old('price_max', $product->price_max > 0 ? $product->price_max : '') }}" class="form-control" min="0">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">Deskripsi Produk</label>
                        <textarea name="description" rows="5" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold text-secondary small">Link Shopee <span class="text-muted">(Opsional)</span></label>
                        <input type="url" name="shopee_url" value="{{ old('shopee_url', $product->shopee_url) }}" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Galeri Foto Management Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3"><h6 class="fw-bold text-dark mb-0">Galeri Foto Produk</h6></div>
                <div class="card-body">
                    @if ($product->images->isNotEmpty())
                        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-2 mb-4">
                            @foreach ($product->images as $img)
                                <div class="col position-relative border p-1 rounded bg-white text-center shadow-sm">
                                    <img src="{{ asset('assets/images/' . $img->image) }}" class="img-fluid rounded mb-1" style="height: 120px; object-fit: cover; border: 2px solid {{ $img->is_primary ? '#775a19' : 'transparent' }};">
                                    
                                    <div class="d-flex justify-content-between p-1">
                                        @if (!$img->is_primary)
                                            <!-- Set Cover -->
                                            <button type="submit" form="setPrimary{{ $img->id }}" class="btn btn-sm btn-gold p-1 px-2" style="font-size: 0.7rem;" title="Jadikan Utama"><i class="fas fa-star"></i> Utama</button>
                                        @else
                                            <span class="badge bg-success-subtle text-success small pt-1.5"><i class="fas fa-check"></i> Cover</span>
                                        @endif

                                        <!-- Hapus Gambar Satuan -->
                                        @if(!$img->is_primary || $product->images->count() > 1)
                                            <button type="submit" form="delImg{{ $img->id }}" class="btn btn-sm btn-outline-danger p-1 px-2" style="font-size: 0.7rem;" onclick="return confirm('Hapus gambar ini?')" title="Hapus Gambar"><i class="fas fa-times"></i></button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mb-0">
                        <label class="form-label fw-bold text-secondary small">Tambahkan Gambar Tambahan (Bisa multi-upload)</label>
                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Aksi & Status -->
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3"><h6 class="fw-bold text-dark mb-0">Status & Visibilitas</h6></div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ $product->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-medium text-dark" for="isActive">Produk Aktif (Tampil di katalog)</label>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured" value="1" {{ $product->is_featured ? 'checked' : '' }}>
                        <label class="form-check-label fw-medium text-dark" for="isFeatured">Produk Unggulan (Masuk Beranda)</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-gold w-100 py-2.5 shadow-sm fw-bold mb-2">
                <i class="fas fa-save me-1"></i> Simpan Perubahan
            </button>
            <a href="{{ url('/product/' . $product->slug) }}" class="btn btn-light border text-dark w-100 py-2" target="_blank">
                <i class="fas fa-eye me-1 text-muted"></i> Lihat di Website
            </a>
        </div>
    </div>
</form>

<!-- Hidden Helper Forms untuk Aksi Tombol dalam Foreach Gambar -->
@foreach ($product->images as $img)
    <form id="setPrimary{{ $img->id }}" action="{{ route('products.image.set-primary', [$product->id, $img->id]) }}" method="POST">@csrf</form>
    <form id="delImg{{ $img->id }}" action="{{ route('products.image.destroy', [$product->id, $img->id]) }}" method="POST">@csrf @method('DELETE')</form>
@endforeach

@endsection