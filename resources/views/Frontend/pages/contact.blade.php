@extends('frontend.layouts.app')

@section('title', 'Kontak Kami - ' . config('app.name', 'BANINA'))

@section('content')

{{-- Page header --}}
<div class="contact-header">
    <div class="container">
        <h1>Kontak Kami</h1>
        <p>Tim {{ config('app.name', 'BANINA') }} siap membantu Anda</p>
    </div>
</div>

{{-- Contact grid --}}
<div class="container">
    <div class="contact-grid">

        {{-- Info column --}}
        <div class="contact-info fade-in">
            <span class="section-label" style="display:block;margin-bottom:14px">Hubungi Kami</span>
            <h2>Ada yang bisa kami bantu?</h2>
            <p style="margin:14px 0 28px;color:var(--onyx-muted);font-size:15px;line-height:1.7">
                Jangan ragu untuk menghubungi kami. Tim BANINA siap melayani pertanyaan dan pesanan Anda.
            </p>

            @if($whatsapp)
                <div class="contact-item">
                    <div class="contact-item-icon"><i class="fab fa-whatsapp"></i></div>
                    <div class="contact-item-text">
                        <strong>WhatsApp</strong>
                        <span>{{ $whatsapp }}</span>
                    </div>
                </div>
            @endif

            @if($address)
                <div class="contact-item">
                    <div class="contact-item-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="contact-item-text">
                        <strong>Alamat</strong>
                        <span>{{ $address }}</span>
                    </div>
                </div>
            @endif

            @if($email)
                <div class="contact-item">
                    <div class="contact-item-icon"><i class="fas fa-envelope"></i></div>
                    <div class="contact-item-text">
                        <strong>Email</strong>
                        <span>{{ $email }}</span>
                    </div>
                </div>
            @endif

            @if($instagram)
                <div class="contact-item">
                    <div class="contact-item-icon"><i class="fab fa-instagram"></i></div>
                    <div class="contact-item-text">
                        <strong>Instagram</strong>
                        <span>{{ $instagram }}</span>
                    </div>
                </div>
            @endif

            {{-- WA CTA block --}}
            @if($whatsapp)
                <div class="contact-wa-block">
                    <h3>Chat Langsung via WhatsApp</h3>
                    <p>Respons cepat, ramah, dan siap membantu Anda menemukan produk yang tepat.</p>
                    <a href="https://wa.me/{{ $whatsapp }}?text={{ urlencode($waGreeting ?? '') }}"
                       class="contact-wa-btn" target="_blank">
                        <i class="fab fa-whatsapp"></i> Mulai Chat
                    </a>
                </div>
            @endif
        </div>

        {{-- Map + hours column --}}
        <div class="fade-in">

            {{-- Google Maps embed --}}
            <div style="border:1px solid var(--outline);overflow:hidden;line-height:0">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.8868329685765!2d109.99815120000001!3d-7.695292600000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7aebeb6e5742c3%3A0xb31736b1a63696b9!2sOutlet%20Banina!5e0!3m2!1sid!2sid!4v1778668956874!5m2!1sid!2sid"
                    width="100%" height="360" style="border:0;display:block;"
                    allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            {{-- Operating hours --}}
            <div style="margin-top:1.5rem;background:var(--ivory-mid);border:1px solid var(--outline);padding:2rem">
                <h3 style="font-family:var(--font-serif);font-size:20px;font-weight:400;color:var(--onyx);margin-bottom:1.25rem">
                    Jam Operasional
                </h3>
                <table style="width:100%;font-family:var(--font-sans);font-size:14px;border-collapse:collapse">
                    <tr style="border-bottom:1px solid var(--outline)">
                        <td style="padding:10px 0;color:var(--onyx-muted)">Senin – Sabtu</td>
                        <td style="text-align:right;font-weight:600;color:var(--onyx)">08.00 – 21.00 WIB</td>
                    </tr>
                    <tr style="border-bottom:1px solid var(--outline)">
                        <td style="padding:10px 0;color:var(--onyx-muted)">Minggu</td>
                        <td style="text-align:right;font-weight:600;color:var(--onyx)">09.00 – 18.00 WIB</td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;color:var(--olive-mid);font-weight:600">WhatsApp</td>
                        <td style="text-align:right;font-weight:700;color:var(--olive-mid)">24 Jam Aktif</td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
