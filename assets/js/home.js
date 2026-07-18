document.addEventListener('DOMContentLoaded', function () {
    // 1. Logic Slider Hero
    const slides = document.querySelectorAll('.hero-slide-elegant');
    const navItems = document.querySelectorAll('.hero-nav-item');
    const counter = document.getElementById('currentSlide');
    
    if (slides.length >= 2) {
        let current = 0;
        let timer;

        function goTo(n) {
            slides[current].classList.remove('active');
            navItems[current]?.classList.remove('active');
            current = (n + slides.length) % slides.length;
            slides[current].classList.add('active');
            if (navItems[current]) navItems[current].classList.add('active');
            if (counter) counter.textContent = String(current + 1).padStart(2, '0');
        }

        function next() { 
            goTo(current + 1); 
        }

        function startTimer() {
            clearInterval(timer);
            timer = setInterval(next, 5000);
        }

        navItems.forEach((btn, i) => {
            btn.addEventListener('click', () => { 
                goTo(i); 
                startTimer(); 
            });
        });

        startTimer();
    }

    // 2. Logic Pop-up Promo Murni JavaScript
    const modalOverlay = document.getElementById('customPromoModal');
    const closeBtn = document.getElementById('closePromoBtn');

    if (modalOverlay && closeBtn) {
        setTimeout(() => {
            modalOverlay.classList.add('show');
        }, 1200);

        closeBtn.addEventListener('click', function() {
            modalOverlay.classList.remove('show');
        });

        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) {
                modalOverlay.classList.remove('show');
            }
        });
    }
});