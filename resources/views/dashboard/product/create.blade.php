@extends('dashboard.layouts.app')

@section('title', 'Tambah Produk')

@section('content')

<div class="mb-3">
    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <!-- Kolom Kiri: Form Isian Pokok -->
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3"><h6 class="fw-bold text-dark mb-0">Informasi Produk</h6></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">Nama Produk *</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">Kategori *</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($allCats as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-secondary small">Harga Minimal (Rp) *</label>
                            <input type="number" name="price_min" value="{{ old('price_min') }}" class="form-control" min="1" placeholder="Contoh: 185000" required>
                            <div class="form-text text-muted">Wajib diisi sebagai nilai acuan terendah.</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-secondary small">Harga Maksimal (Rp) <span class="text-muted">(Opsional)</span></label>
                            <input type="number" name="price_max" value="{{ old('price_max') }}" class="form-control" min="0" placeholder="Kosongkan jika harga tunggal">
                            <div class="form-text text-muted">Isi jika item memiliki varian ukuran/tipe mahal.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">Deskripsi Produk</label>
                        <textarea name="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold text-secondary small">Link Shopee <span class="text-muted">(Opsional)</span></label>
                        <input type="url" name="shopee_url" value="{{ old('shopee_url') }}" class="form-control" placeholder="https://shopee.co.id/product/...">
                        <div class="form-text text-warning"><i class="fas fa-exclamation-triangle me-1"></i> Jika dikosongkan, tombol beli Shopee otomatis tidak tampil di website publik.</div>
                    </div>
                </div>
            </div>

            <!-- Upload Gambar Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3"><h6 class="fw-bold text-dark mb-0">Gambar Produk</h6></div>
                <div class="card-body">
                    <div class="mb-0">
                        <label class="form-label fw-bold text-secondary small">Upload Gambar Baru (Bisa langsung pilih banyak file)</label>
                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                        <div class="form-text text-muted">Rekomendasi rasio gambar 4:5, format JPG/PNG/WebP, maksimal 5MB per file. Berkas pertama otomatis diset menjadi cover utama.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Status & Publikasi -->
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3"><h6 class="fw-bold text-dark mb-0">Status & Visibilitas</h6></div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" checked>
                        <label class="form-check-label fw-medium text-dark" for="isActive">Produk Aktif (Tampil di katalog)</label>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured" value="1">
                        <label class="form-check-label fw-medium text-dark" for="isFeatured">Produk Unggulan (Masuk Beranda)</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-gold w-100 py-2.5 shadow-sm fw-bold">
                <i class="fas fa-save me-1"></i> Simpan Produk Baru
            </button>
        </div>
    </div>
</form>

@endsection