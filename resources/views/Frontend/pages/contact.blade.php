@extends('frontend.layouts.app')

@section('title', 'Kontak Kami - ' . config('app.name', 'BANINA'))

@section('content')

<div class="bg-surface-container py-14 text-center">
    <div class="container mx-auto px-4 md:px-8">
        <h1 class="font-display text-3xl md:text-4xl text-primary mb-3">Kontak Kami</h1>
        <p class="font-body text-sm text-on-surface-variant max-w-xl mx-auto">Kami hadir untuk memastikan setiap kebutuhan busana Anda terpenuhi. Silakan hubungi tim kami untuk konsultasi atau bantuan lebih lanjut.</p>
    </div>
</div>

<div class="container mx-auto px-4 md:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

        {{-- ============ INFO KONTAK ============ --}}
        <div>
            <span class="font-body text-xs uppercase tracking-[0.2em] text-secondary mb-3 block">Hubungi Kami</span>
            <h2 class="font-display text-2xl text-primary mb-3">Ada yang bisa kami bantu?</h2>
            <p class="font-body text-sm text-on-surface-variant mb-8">Jangan ragu untuk menghubungi kami. Tim {{ config('app.name', 'BANINA') }} siap melayani pertanyaan dan pesanan Anda.</p>

            <div class="flex flex-col gap-4 mb-8">
                @if($whatsapp)
                    <div class="flex items-center gap-4 bg-surface-container-low rounded-lg p-4">
                        <div class="w-11 h-11 rounded-full bg-secondary-container/30 flex items-center justify-center shrink-0">
                            <i class="fab fa-whatsapp text-secondary"></i>
                        </div>
                        <div>
                            <h4 class="font-body text-xs uppercase tracking-wider text-secondary mb-0.5">WhatsApp</h4>
                            <p class="font-body text-sm text-primary font-medium">{{ $whatsapp }}</p>
                        </div>
                    </div>
                @endif

                @if($address)
                    <div class="flex items-center gap-4 bg-surface-container-low rounded-lg p-4">
                        <div class="w-11 h-11 rounded-full bg-secondary-container/30 flex items-center justify-center shrink-0">
                            <i class="fas fa-map-marker-alt text-secondary"></i>
                        </div>
                        <div>
                            <h4 class="font-body text-xs uppercase tracking-wider text-secondary mb-0.5">Alamat</h4>
                            <p class="font-body text-sm text-primary font-medium">{{ $address }}</p>
                        </div>
                    </div>
                @endif

                @if($email)
                    <div class="flex items-center gap-4 bg-surface-container-low rounded-lg p-4">
                        <div class="w-11 h-11 rounded-full bg-secondary-container/30 flex items-center justify-center shrink-0">
                            <i class="fas fa-envelope text-secondary"></i>
                        </div>
                        <div>
                            <h4 class="font-body text-xs uppercase tracking-wider text-secondary mb-0.5">Email</h4>
                            <p class="font-body text-sm text-primary font-medium">{{ $email }}</p>
                        </div>
                    </div>
                @endif

                @if($instagram)
                    <div class="flex items-center gap-4 bg-surface-container-low rounded-lg p-4">
                        <div class="w-11 h-11 rounded-full bg-secondary-container/30 flex items-center justify-center shrink-0">
                            <i class="fab fa-instagram text-secondary"></i>
                        </div>
                        <div>
                            <h4 class="font-body text-xs uppercase tracking-wider text-secondary mb-0.5">Instagram</h4>
                            <p class="font-body text-sm text-primary font-medium">{{ $instagram }}</p>
                        </div>
                    </div>
                @endif
            </div>

            @if($whatsapp)
                <a href="https://wa.me/{{ $whatsapp }}?text={{ urlencode($waGreeting ?? '') }}" target="_blank"
                   class="inline-flex items-center gap-2 bg-primary-container text-white px-7 py-3 rounded font-body text-sm font-medium hover:bg-primary transition-colors">
                    <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                </a>
            @endif
        </div>

        {{-- ============ MAP + JAM OPERASIONAL (data asli, tidak diubah) ============ --}}
        <div>
            <div class="rounded-lg overflow-hidden editorial-shadow border border-outline-variant">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.8868329685765!2d109.99815120000001!3d-7.695292600000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7aebeb6e5742c3%3A0xb31736b1a63696b9!2sOutlet%20Banina!5e0!3m2!1sid!2sid!4v1778668956874!5m2!1sid!2sid"
                    width="100%" height="360" style="border:0;display:block;"
                    allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <div class="mt-6 bg-surface-container rounded-lg p-7">
                <h3 class="font-display text-lg text-primary mb-4 flex items-center gap-2">
                    <i class="fas fa-clock text-secondary text-sm"></i> Jam Operasional
                </h3>
                <table class="w-full font-body text-sm">
                    <tr class="border-b border-outline-variant/50">
                        <td class="py-2.5 text-on-surface-variant">Setiap Hari</td>
                        <td class="py-2.5 text-right font-semibold text-primary">08.00 – 21.00 WIB</td>
                    </tr>
                    <tr>
                        <td class="py-2.5 text-secondary font-medium">WhatsApp</td>
                        <td class="py-2.5 text-right font-semibold text-secondary">08.00 – 21.00 WIB</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection