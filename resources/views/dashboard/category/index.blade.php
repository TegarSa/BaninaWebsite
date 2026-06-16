@extends('dashboard.layouts.app')

@section('title', 'Kelola Kategori')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <div class="col-12 col-xl-4">
        <div class="card border-0 shadow-sm sticky-xl-top" style="top: 90px; z-index: 10;">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-dark">Tambah Kategori Baru</h6>
            </div>
            <div class="card-body border-top">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Nama Kategori *</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Kemeja Flanel">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Deskripsi</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Deskripsi singkat kategori..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Urutan Tampil</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small">Gambar Kategori</label>
                        <div class="mb-2">
                            <img id="catPreview" class="img-fluid rounded border shadow-sm" style="display:none; max-height: 150px; object-fit: cover;">
                        </div>
                        <input type="file" name="image" accept="image/*" class="form-control" id="imageInput">
                    </div>
                    <button type="submit" class="btn btn-gold w-100 py-2 fw-bold shadow-sm">
                        <i class="fas fa-save me-1"></i> Simpan Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-dark">Daftar Kategori ({{ $categories->total() }})</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4">Kategori</th>
                            <th>Total Produk</th>
                            <th>Status</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $cat)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($cat->image)
                                            <img src="{{ asset('assets/images/' . $cat->image) }}" class="rounded border shadow-sm" style="width: 44px; height: 44px; object-fit: cover;">
                                        @else
                                            <div class="bg-light border text-muted rounded d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; font-size: 1rem;">
                                                <i class="fas fa-tag text-secondary"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $cat->name }}</div>
                                            <small class="text-muted text-break d-block" style="font-size: 0.75rem;">{{ $cat->slug }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-secondary fw-semibold">{{ $cat->products_count }} produk</td>
                                <td>
                                    <span class="badge rounded-pill {{ $cat->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }} px-2.5 py-1">
                                        {{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('categories.edit', $cat->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="fas fa-edit"></i></a>
                                        
                                        <form action="{{ route('categories.toggle-active', $cat->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="Ubah Visibilitas"><i class="fas fa-toggle-{{ $cat->is_active ? 'on' : 'off' }}"></i></button>
                                        </form>

                                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Menghapus kategori ini tidak akan menghapus produk di dalamnya. Yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-white" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">Belum ada data kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-top py-3 d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
                <div class="text-muted small fw-medium">
                    Menampilkan <span class="text-dark fw-bold">{{ $categories->firstItem() ?? 0 }}</span> 
                    sampai <span class="text-dark fw-bold">{{ $categories->lastItem() ?? 0 }}</span> 
                    dari <span class="text-dark fw-bold">{{ $categories->total() }}</span> data
                </div>
                
                <div class="mb-0">
                    @if ($categories->total() <= $categories->perPage())
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
                        {{ $categories->links('pagination::bootstrap-5') }}
                    @endif
                </div>
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