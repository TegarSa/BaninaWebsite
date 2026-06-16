@extends('dashboard.layouts.app')

@section('title', 'Kelola Banner')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <div class="col-12 col-xl-4">
        <div class="card border-0 shadow-sm sticky-xl-top" style="top: 90px; z-index: 10;">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark">Tambah Banner Baru</h6>
            </div>
            
            <div class="bg-light px-3 py-2 border-top border-bottom small d-flex justify-content-between">
                <div>Hero Aktif: <span class="fw-bold {{ $activeHeroCount >= 5 ? 'text-danger' : 'text-success' }}">{{ $activeHeroCount }}/5</span></div>
                <div>Pop-up Aktif: <span class="fw-bold {{ $activePopupCount >= 1 ? 'text-danger' : 'text-success' }}">{{ $activePopupCount }}/1</span></div>
            </div>

            <div class="card-body">
                <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Penempatan Banner *</label>
                        <select name="type" class="form-select" required>
                            <option value="hero" {{ old('type') == 'hero' ? 'selected' : '' }}>Hero Slider (Maks 5 Aktif)</option>
                            <option value="popup" {{ old('type') == 'popup' ? 'selected' : '' }}>Pop-up Promo (Maks 1 Aktif)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Judul Banner</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Opsional">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Sub Judul</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}" placeholder="Opsional">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Link URL (Opsional)</label>
                        <input type="url" name="link" class="form-control" value="{{ old('link') }}" placeholder="https://shopee.co.id/...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Urutan Tampil</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small">Gambar Banner *</label>
                        <div class="mb-2">
                            <img id="bannerPreview" class="img-fluid rounded border shadow-sm" style="display:none; max-height: 150px; width: 100%; object-fit: cover;">
                        </div>
                        <input type="file" name="image" accept="image/*" class="form-control" id="imageInput" required>
                        <div class="form-text text-muted">Rekomendasi Hero: 1920x600px. Pop-up: 600x600px.</div>
                    </div>
                    <button type="submit" class="btn btn-gold w-100 py-2 fw-bold shadow-sm">
                        <i class="fas fa-save me-1"></i> Simpan Banner
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-dark">Daftar Banner ({{ $banners->total() }})</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4">Preview</th>
                            <th>Info Banner</th>
                            <th>Penempatan</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($banners as $b)
                            <tr>
                                <td class="ps-4">
                                    <img src="{{ asset('assets/images/' . $b->image) }}" class="rounded border shadow-sm" style="width: 90px; height: 45px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $b->title ?: '(Tanpa Judul)' }}</div>
                                    @if($b->link)
                                        <small class="text-muted d-block text-truncate" style="max-width: 180px;">{{ $b->link }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $b->type === 'hero' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-warning' }} px-2 py-1">
                                        {{ $b->type === 'hero' ? 'Hero Slider' : 'Pop-up' }}
                                    </span>
                                </td>
                                <td class="text-secondary fw-semibold">{{ $b->sort_order }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $b->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }} px-2.5 py-1">
                                        {{ $b->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('banners.edit', $b->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="fas fa-edit"></i></a>
                                        
                                        <form action="{{ route('banners.toggle-active', $b->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-{{ $b->is_active ? 'success' : 'secondary' }}" title="{{ $b->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-toggle-{{ $b->is_active ? 'on' : 'off' }}"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('banners.destroy', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus banner ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Belum ada data banner.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-top py-3 d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
                <div class="text-muted small fw-medium">
                    Menampilkan <span class="text-dark fw-bold">{{ $banners->firstItem() ?? 0 }}</span> 
                    sampai <span class="text-dark fw-bold">{{ $banners->lastItem() ?? 0 }}</span> 
                    dari <span class="text-dark fw-bold">{{ $banners->total() }}</span> data
                </div>
                
                <div class="mb-0">
                    @if ($banners->total() <= $banners->perPage())
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
                        {{ $banners->links('pagination::bootstrap-5') }}
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
            const preview = document.getElementById('bannerPreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>

@endsection