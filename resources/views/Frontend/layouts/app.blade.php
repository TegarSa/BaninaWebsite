<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('app.name', 'BANINA') . ' - Busana Muslim Pria')</title>
    
    <meta name="description" content="@yield('meta_description', 'Koleksi busana muslim pria premium dan modern dari BANINA.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500;600&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- Tailwind CDN, preflight OFF so it never resets/conflicts with style.css on pages not yet redesigned --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    colors: {
                        primary: '#002819',
                        'primary-container': '#06402b',
                        secondary: '#775a19',
                        'secondary-container': '#fed488',
                        'on-secondary-container': '#785a1a',
                        background: '#fcf9f8',
                        'surface-container': '#f0eded',
                        'surface-container-low': '#f6f3f2',
                        'on-surface-variant': '#404943',
                        outline: '#717973',
                        'outline-variant': '#c0c9c1',
                    },
                    fontFamily: {
                        display: ['Playfair Display', 'serif'],
                        body: ['Montserrat', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --gold: #7a8c2a;
            --gold-light: #9aad3a;
            --gold-dim: #5a6820;
            --border-gold: rgba(122,140,42,0.3);
        }

        .editorial-shadow { box-shadow: 0px 10px 30px rgba(6, 44, 30, 0.08); }
        .transition-soft { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }

        .hero-slide-elegant {
            position: absolute; inset: 0; opacity: 0; transition: opacity 1.2s ease;
        }
        .hero-slide-elegant.active { opacity: 1; }
        .hero-slide-elegant img { width: 100%; height: 100%; object-fit: cover; }

        .hero-nav-bar { width: 40px; height: 2px; background: rgba(255,255,255,0.3); position: relative; overflow: hidden; }
        .hero-nav-progress { position: absolute; inset: 0; background: #e9c176; transform: scaleX(0); transform-origin: left; transition: transform 0.3s ease; }
        .hero-nav-item.active .hero-nav-progress { transform: scaleX(1); }

        .custom-popup-overlay {
            position: fixed; inset: 0; z-index: 100; background: rgba(0,21,12,0.7);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: opacity 0.3s ease;
        }
        .custom-popup-overlay.show { opacity: 1; visibility: visible; }
        .custom-popup-wrapper { position: relative; max-width: 420px; width: 90%; }
        .custom-popup-content img { width: 100%; border-radius: 0.5rem; }
        .custom-popup-close {
            position: absolute; top: -16px; right: -16px; width: 36px; height: 36px;
            border-radius: 50%; background: #fcf9f8; color: #002819; border: none;
            font-size: 1.25rem; cursor: pointer; display: flex; align-items: center; justify-content: center;
        }

        .back-to-top-btn {
            position: fixed;
            bottom: 100px;
            right: -60px;
            width: 48px;
            height: 48px;
            background-color: #0a0a0a;
            border: 1px solid rgba(122,140,42,0.4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 999;
            transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            opacity: 0;
        }

        .back-to-top-btn.show {
            right: 30px;
            opacity: 1;
            animation: pulseGlow 2s infinite ease-in-out;
        }

        .back-to-top-btn:hover {
            background-color: #141414;
            transform: translateY(-5px);
            border-color: #9aad3a;
            animation: pulseGlowHover 1.2s infinite ease-in-out; /* Berkedip lebih cepat saat di-hover */
        }

        .back-to-top-icon {
            color: #7a8c2a;
            font-size: 0.95rem;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .back-to-top-btn:hover .back-to-top-icon {
            color: #9aad3a;
            transform: translateY(-2px);
        }

        .progress-circle {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
            z-index: 1;
        }

        .progress-circle circle {
            fill: none;
            stroke: #7a8c2a;
            stroke-width: 2px;
            stroke-dasharray: 138.23;
            stroke-dashoffset: 138.23;
            transition: stroke-dashoffset 0.1s linear, stroke 0.3s ease;
        }

        .back-to-top-btn:hover .progress-circle circle {
            stroke: #9aad3a;
        }

        .shimmer-effect {
            position: absolute;
            top: 0;
            left: -150%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.15) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: skewX(-25deg);
            z-index: 1;
            transition: none;
        }

        .back-to-top-btn.show .shimmer-effect {
            animation: simmerSimmer 3.5s infinite ease-in-out;
        }

        @keyframes simmerSimmer {
            0% { left: -150%; }
            30% { left: 150%; }
            100% { left: 150%; }
        }

        @keyframes pulseGlow {
            0% {
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3), 0 0 0px rgba(154, 173, 58, 0);
            }
            50% {
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3), 0 0 15px rgba(154, 173, 58, 0.6);
            }
            100% {
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3), 0 0 0px rgba(154, 173, 58, 0);
            }
        }

        @keyframes pulseGlowHover {
            0% {
                box-shadow: 0 8px 25px rgba(122, 140, 42, 0.3), 0 0 4px rgba(154, 173, 58, 0.2);
            }
            50% {
                box-shadow: 0 8px 25px rgba(122, 140, 42, 0.3), 0 0 20px rgba(154, 173, 58, 0.8);
            }
            100% {
                box-shadow: 0 8px 25px rgba(122, 140, 42, 0.3), 0 0 4px rgba(154, 173, 58, 0.2);
            }
        }
    </style>

    @stack('css')
</head>

<body>

    @include('frontend.layouts.navbar')

    <main>
        @yield('content')
    </main>

    <div class="back-to-top-btn" id="backToTop">
        <span class="shimmer-effect"></span>
        <svg class="progress-circle" viewBox="0 0 48 48">
            <circle cx="24" cy="24" r="22"></circle>
        </svg>
        <i class="fas fa-chevron-up back-to-top-icon"></i>
    </div>

    @include('frontend.layouts.footer')

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const backToTopBtn = document.getElementById('backToTop');
            const progressCircle = document.querySelector('.progress-circle circle');
            const totalLength = 138.23; 

            if (backToTopBtn && progressCircle) {
                window.addEventListener('scroll', () => {
                    const scrollTop = window.scrollY;
                    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                    
                    if (scrollTop > 300) {
                        backToTopBtn.classList.add('show');
                    } else {
                        backToTopBtn.classList.remove('show');
                    }

                    if (docHeight > 0) {
                        const scrollPercent = scrollTop / docHeight;
                        const offset = totalLength - (scrollPercent * totalLength);
                        progressCircle.style.strokeDashoffset = offset;
                    }
                });

                backToTopBtn.addEventListener('click', (e) => {
                    e.preventDefault(); 
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth' 
                    });
                });
            }
        });
    </script>

    @stack('js')

</body>
</html>