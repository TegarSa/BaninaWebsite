@extends('dashboard.layouts.app')

@section('title', 'Edit Banner')

@section('content')

<div class="mb-3">
    <a href="{{ route('banners.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-dark">Perbarui Data Banner</h6>
            </div>
            <div class="card-body border-top">
                <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Penempatan Banner *</label>
                        <select name="type" class="form-select" required>
                            <option value="hero" {{ old('type', $banner->type) == 'hero' ? 'selected' : '' }}>Hero Slider (Maks 5 Aktif)</option>
                            <option value="popup" {{ old('type', $banner->type) == 'popup' ? 'selected' : '' }}>Pop-up Promo (Maks 1 Aktif)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Judul Banner</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Sub Judul</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $banner->subtitle) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Link URL (Opsional)</label>
                        <input type="url" name="link" class="form-control" value="{{ old('link', $banner->link) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Urutan Tampil</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $banner->sort_order) }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small">Gambar Banner</label>
                        <div class="mb-2">
                            <img id="bannerPreview" src="{{ asset('assets/images/' . $banner->image) }}" class="img-fluid rounded border shadow-sm" style="max-height: 150px; width:100%; object-fit: cover;">
                        </div>
                        <input type="file" name="image" accept="image/*" class="form-control" id="imageInput">
                        <div class="form-text text-muted">Kosongkan saja jika tidak ingin mengganti gambar banner. Rekomendasi Hero: 1920x600px. Pop-up: 600x600px.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gold px-4 fw-bold shadow-sm">Simpan Perubahan</button>
                        <a href="{{ route('banners.index') }}" class="btn btn-light border px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('imageInput').onchange = function (evt) {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('bannerPreview');
            preview.src = URL.createObjectURL(file);
        }
    }
</script>

@endsection