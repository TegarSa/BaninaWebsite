@extends('dashboard.layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<div class="mb-3">
    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="row">
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-dark">Perbarui Data Kategori</h6>
            </div>
            <div class="card-body border-top">
                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Nama Kategori *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Deskripsi</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Urutan Tampil</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small">Gambar Kategori</label>
                        <div class="mb-2">
                            @if ($category->image)
                                <img id="catPreview" src="{{ asset('assets/images/' . $category->image) }}" class="img-fluid rounded border shadow-sm" style="max-height: 150px; object-fit: cover;">
                            @else
                                <img id="catPreview" class="img-fluid rounded border shadow-sm" style="display:none; max-height: 150px; object-fit: cover;">
                            @endif
                        </div>
                        <input type="file" name="image" accept="image/*" class="form-control" id="imageInput">
                        <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar utama kategori.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gold px-4 fw-bold shadow-sm">Simpan Perubahan</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-light border px-4">Batal</a>
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
            const preview = document.getElementById('catPreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>

@endsection