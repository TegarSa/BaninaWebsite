@extends('dashboard.layouts.app')

@section('title', 'Pengaturan Toko')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row g-4">
        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-store me-2 text-secondary"></i>Profil Toko</h6>
                </div>
                <div class="card-body border-top">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Nama Toko</label>
                        <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Tagline</label>
                        <input type="text" name="site_tagline" class="form-control" value="{{ $settings['site_tagline'] ?? '' }}" placeholder="Men Wear Since 2019">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Deskripsi Singkat</label>
                        <textarea name="site_description" class="form-control" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Tentang Kami (Halaman About)</label>
                        <textarea name="about_text" class="form-control" rows="5">{{ $settings['about_text'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Gambar Halaman Tentang</label>
                        @if(!empty($settings['about_image']))
                            <div class="mb-2">
                                <img src="{{ asset('assets/images/' . $settings['about_image']) }}" class="img-fluid rounded border shadow-sm" style="max-height: 140px; width:100%; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" name="about_image" accept="image/*" class="form-control">
                        <div class="form-text text-muted">Gambar yang ditampilkan di halaman Tentang Kami.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Foto CTA WhatsApp <span class="badge bg-success ms-1" style="font-size:10px;">Baru</span></label>
                        @if(!empty($settings['cta_image']))
                            <div class="mb-2">
                                <img src="{{ asset('assets/images/' . $settings['cta_image']) }}" class="img-fluid rounded border shadow-sm" style="max-height: 140px; width:100%; object-fit: cover;">
                            </div>
                        @else
                            <div class="mb-2 p-3 bg-light rounded border text-center text-muted small">
                                <i class="fas fa-image me-1"></i> Belum ada foto, sisi kanan CTA akan tampil kosong.
                            </div>
                        @endif
                        <input type="file" name="cta_image" accept="image/*" class="form-control">
                        <div class="form-text text-muted">Foto yang tampil di sisi kanan kotak "Konsultasikan Gaya Modest Anda" di halaman beranda. Rekomendasi: foto portrait/square, min. 600×600px.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6 d-flex flex-column gap-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-address-book me-2 text-secondary"></i>Kontak & Media Sosial</h6>
                </div>
                <div class="card-body border-top">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp_number" class="form-control" value="{{ $settings['whatsapp_number'] ?? '' }}" placeholder="6281234567890">
                        <div class="form-text text-muted">Format internasional tanpa tanda + (contoh: 6281234567890)</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Pesan Sapaan WhatsApp Default</label>
                        <textarea name="whatsapp_greeting" class="form-control" rows="2">{{ $settings['whatsapp_greeting'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Alamat</label>
                        <textarea name="address" class="form-control" rows="2">{{ $settings['address'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Instagram</label>
                        <input type="text" name="instagram" class="form-control" value="{{ $settings['instagram'] ?? '' }}" placeholder="@banina.fact">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">TikTok</label>
                        <input type="text" name="tiktok" class="form-control" value="{{ $settings['tiktok'] ?? '' }}" placeholder="@banina">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Link Shopee</label>
                        <input type="url" name="shopee" class="form-control" value="{{ $settings['shopee'] ?? '' }}" placeholder="https://shopee.co.id/...">
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-image me-2 text-secondary"></i>Teks Hero / Banner Utama</h6>
                </div>
                <div class="card-body border-top">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Judul Hero</label>
                        <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Sub Judul Hero</label>
                        <input type="text" name="hero_subtitle" class="form-control" value="{{ $settings['hero_subtitle'] ?? '' }}">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-gold w-100 py-2.5 fw-bold shadow-sm mt-auto">
                <i class="fas fa-save me-1"></i> Simpan Semua Pengaturan
            </button>
        </div>
    </div>
</form>

@endsection