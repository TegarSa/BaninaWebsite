@php
    $footerWhatsapp = \App\Models\Setting::getValue('whatsapp_number');
    $footerGreeting = \App\Models\Setting::getValue('whatsapp_greeting');
    $footerDesc = \App\Models\Setting::getValue('site_description') ?? 'Koleksi busana muslim pria premium dan modern.';
    $footerInstagram = \App\Models\Setting::getValue('instagram');
    $footerTiktok = \App\Models\Setting::getValue('tiktok');
    $footerShopee = \App\Models\Setting::getValue('shopee');
    $footerAddress = \App\Models\Setting::getValue('address');
    $footerEmail = \App\Models\Setting::getValue('email');
@endphp

@if($footerWhatsapp)
    <a href="https://wa.me/{{ $footerWhatsapp }}?text={{ urlencode($footerGreeting ?? '') }}"
       class="wa-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
@endif

<footer class="bg-primary text-white pt-16 pb-8">
    <div class="container mx-auto px-4 md:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">

            <div>
                <h3 class="font-display text-2xl text-secondary-container mb-4">{{ config('app.name', 'BANINA') }}</h3>
                <p class="font-body text-sm text-white/70 mb-6 max-w-xs">{{ $footerDesc }}</p>
                <div class="flex gap-3">
                    @if($footerInstagram)
                        <a href="https://instagram.com/{{ ltrim($footerInstagram, '@') }}" target="_blank" class="w-9 h-9 rounded-full border border-white/20 flex items-center justify-center hover:bg-secondary hover:border-secondary transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    @if($footerTiktok)
                        <a href="https://tiktok.com/@{{ ltrim($footerTiktok, '@') }}" target="_blank" class="w-9 h-9 rounded-full border border-white/20 flex items-center justify-center hover:bg-secondary hover:border-secondary transition-colors">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    @endif
                    @if($footerShopee)
                        <a href="{{ $footerShopee }}" target="_blank" class="w-9 h-9 rounded-full border border-white/20 flex items-center justify-center hover:bg-secondary hover:border-secondary transition-colors">
                            <i class="fas fa-store"></i>
                        </a>
                    @endif
                    @if($footerWhatsapp)
                        <a href="https://wa.me/{{ $footerWhatsapp }}" target="_blank" class="w-9 h-9 rounded-full border border-white/20 flex items-center justify-center hover:bg-secondary hover:border-secondary transition-colors">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    @endif
                </div>
            </div>

            <div>
                <h4 class="font-body text-sm font-semibold text-secondary-container uppercase tracking-wider mb-4">Navigasi</h4>
                <ul class="flex flex-col gap-2.5 font-body text-sm text-white/70">
                    <li><a href="{{ route('home') }}" class="hover:text-secondary-container transition-colors">Beranda</a></li>
                    <li><a href="{{ route('catalog') }}" class="hover:text-secondary-container transition-colors">Produk</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-secondary-container transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-secondary-container transition-colors">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-body text-sm font-semibold text-secondary-container uppercase tracking-wider mb-4">Koleksi</h4>
                <ul class="flex flex-col gap-2.5 font-body text-sm text-white/70">
                    @if(isset($categories) && $categories->isNotEmpty())
                        @foreach($categories as $cat)
                            <li><a href="{{ route('catalog', $cat->slug) }}" class="hover:text-secondary-container transition-colors">{{ $cat->name }}</a></li>
                        @endforeach
                    @else
                        <li><a href="{{ route('catalog') }}" class="hover:text-secondary-container transition-colors">Semua Produk</a></li>
                    @endif
                </ul>
            </div>

            <div>
                <h4 class="font-body text-sm font-semibold text-secondary-container uppercase tracking-wider mb-4">Hubungi Kami</h4>
                <ul class="flex flex-col gap-2.5 font-body text-sm text-white/70">
                    @if($footerAddress)
                        <li class="flex items-start gap-2"><i class="fas fa-map-marker-alt mt-1 text-secondary-container"></i> <span>{{ $footerAddress }}</span></li>
                    @endif
                    @if($footerEmail)
                        <li class="flex items-start gap-2"><i class="fas fa-envelope mt-1 text-secondary-container"></i> <span>{{ $footerEmail }}</span></li>
                    @endif
                    @if($footerWhatsapp)
                        <li class="flex items-start gap-2"><i class="fab fa-whatsapp mt-1 text-secondary-container"></i> <span>{{ $footerWhatsapp }}</span></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="pt-6 border-t border-white/10 text-center">
            <p class="font-body text-xs text-white/50">© {{ date('Y') }} {{ config('app.name', 'BANINA') }}. All rights reserved. | Men Wear Since 2019</p>
        </div>
    </div>
</footer>