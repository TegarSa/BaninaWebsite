<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('app.name', 'BANINA') . ' - Busana Muslim Pria')</title>
    
    <meta name="description" content="@yield('meta_description', 'Koleksi busana muslim pria premium dan modern dari BANINA.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        :root {
            --gold: #7a8c2a;
            --gold-light: #9aad3a;
            --gold-dim: #5a6820;
            --border-gold: rgba(122,140,42,0.3);
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

        /* Modifikasi: Menambahkan animasi pulseGlow saat tombol muncul */
        .back-to-top-btn.show {
            right: 36px;
            opacity: 1;
            animation: pulseGlow 2s infinite ease-in-out;
        }

        /* Modifikasi: Hover efek shadow-nya disesuaikan agar tetap matching */
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
            /* Menambahkan multi-animation agar efek shimmer dan glow bisa jalan bareng */
            animation: simmerSimmer 3.5s infinite ease-in-out;
        }

        @keyframes simmerSimmer {
            0% { left: -150%; }
            30% { left: 150%; }
            100% { left: 150%; }
        }

        /* --- Tambahan Animasi Baru untuk Efek Menyala/Berkedip --- */
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

                backToTopBtn.addEventListener('click', () => {
                    const duration = 1000; 
                    const startPosition = window.scrollY;
                    const startTime = performance.now();

                    function easeOutCubic(t) {
                        return 1 - Math.pow(1 - t, 3);
                    }

                    function animation(currentTime) {
                        const timeElapsed = currentTime - startTime;
                        const progress = Math.min(timeElapsed / duration, 1);
                        
                        window.scrollTo(0, startPosition * (1 - easeOutCubic(progress)));

                        if (timeElapsed < duration) {
                            requestAnimationFrame(animation);
                        }
                    }

                    requestAnimationFrame(animation);
                });
            }
        });
    </script>

    @stack('js')

</body>
</html>