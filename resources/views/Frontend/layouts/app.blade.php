<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('app.name', 'BANINA') . ' - Busana Muslim Pria')</title>
    <meta name="description" content="@yield('meta_description', 'Koleksi busana muslim pria premium dan modern dari BANINA.')">

    {{-- Google Fonts: Libre Caslon Text + Libre Franklin --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&family=Libre+Franklin:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Main stylesheet --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @stack('css')
</head>

<body>

    @include('frontend.layouts.navbar')

    <main>
        @yield('content')
    </main>

    {{-- Back to top --}}
    <div class="back-to-top-btn" id="backToTop">
        <svg class="progress-circle" viewBox="0 0 48 48">
            <circle cx="24" cy="24" r="22"></circle>
        </svg>
        <i class="fas fa-chevron-up back-to-top-icon"></i>
    </div>

    @include('frontend.layouts.footer')

    {{-- Main JS --}}
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- Back to top script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btn = document.getElementById('backToTop');
            const circle = document.querySelector('.progress-circle circle');
            const totalLength = 138.23;

            if (btn && circle) {
                window.addEventListener('scroll', () => {
                    const scrollTop = window.scrollY;
                    const docHeight = document.documentElement.scrollHeight - window.innerHeight;

                    btn.classList.toggle('show', scrollTop > 300);

                    if (docHeight > 0) {
                        const pct = scrollTop / docHeight;
                        circle.style.strokeDashoffset = totalLength - (pct * totalLength);
                    }
                });

                btn.addEventListener('click', () => {
                    const duration = 900;
                    const start = window.scrollY;
                    const startTime = performance.now();
                    const ease = t => 1 - Math.pow(1 - t, 3);
                    const step = now => {
                        const elapsed = now - startTime;
                        const p = Math.min(elapsed / duration, 1);
                        window.scrollTo(0, start * (1 - ease(p)));
                        if (elapsed < duration) requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                });
            }

            // Fade-in observer
            const observer = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('visible');
                        observer.unobserve(e.target);
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                window.addEventListener('scroll', () => {
                    navbar.classList.toggle('scrolled', window.scrollY > 60);
                });
            }
        });
    </script>

    @stack('js')

</body>
</html>
