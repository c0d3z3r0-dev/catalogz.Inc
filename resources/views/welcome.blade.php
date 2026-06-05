<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog.Inc – Catalogs that bring money</title>
    <link rel="manifest" href="/manifest.json">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #efeae2;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d4cdc2' fill-opacity='0.6'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3Ccircle cx='60' cy='60' r='2'/%3E%3Ccircle cx='40' cy='10' r='1.5'/%3E%3Ccircle cx='10' cy='50' r='1.5'/%3E%3Ccircle cx='70' cy='30' r='1.5'/%3E%3Ccircle cx='30' cy='70' r='1'/%3E%3Ccircle cx='50' cy='40' r='1'/%3E%3Ccircle cx='15' cy='35' r='1'/%3E%3Ccircle cx='65' cy='15' r='1'/%3E%3Ccircle cx='45' cy='55' r='1'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 80px 80px;
            margin: 0;
            scroll-behavior: smooth;
        }
        .btn-dark-green {
            background-color: #0A8F3C;
            color: white;
            border-radius: 12px;
            padding: 14px 28px;
            font-weight: 600;
            transition: all 0.2s ease;
            display: inline-block;
        }
        .btn-dark-green:hover { background-color: #047A2D; transform: translateY(-1px); }
        .sticky-mobile-cta {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: white; border-top: 1px solid #e5e7eb;
            padding: 12px 16px; z-index: 40;
        }
        @media (min-width: 768px) { .sticky-mobile-cta { display: none; } }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; }
        .faq-answer.open { max-height: 200px; }
        .carousel-wrapper { overflow: hidden; position: relative; max-width: 900px; margin: 0 auto; }
        .carousel-track { display: flex; transition: transform 0.5s ease; }
        .carousel-card {
            min-width: 260px; flex-shrink: 0; padding: 0 12px;
            transform: scale(0.9); opacity: 0.6;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }
        .carousel-card.active { transform: scale(1.08); opacity: 1; z-index: 2; }
        .carousel-dots { display: flex; justify-content: center; gap: 8px; margin-top: 20px; }
        .carousel-dot { width: 10px; height: 10px; border-radius: 50%; background: #d1d5db; cursor: pointer; transition: background 0.3s; }
        .carousel-dot.active { background: #0A8F3C; width: 24px; border-radius: 5px; }
        .star { color: #f59e0b; }
        .back-to-top {
            position: fixed; bottom: 80px; right: 24px; z-index: 49;
            background: white; border-radius: 50%; width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15); cursor: pointer;
            opacity: 0; transition: opacity 0.3s;
        }
        .back-to-top.visible { opacity: 1; }
        @media (min-width: 768px) { .carousel-card { min-width: 320px; } }
        @media (max-width: 640px) {
            .back-to-top { bottom: 70px; right: 16px; }
            .carousel-card { min-width: 220px; }
        }
    </style>
</head>
<body class="text-gray-800">

    <!-- Nav -->
    <nav class="bg-[#1e2a3a] shadow-sm p-4 w-full">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <span class="text-xl md:text-2xl font-bold">
                <span class="text-white">Catalog.</span><span class="text-green-500">Inc</span>
            </span>
            <a href="/login" class="text-sm md:text-base text-gray-300 hover:text-green-400 font-medium">Admin Login</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="max-w-4xl mx-auto px-4 py-20 md:py-32 text-center">
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">
            Turn your <span id="typewriter-text">WhatsApp</span> into a beautiful online store
        </h1>
        <p class="text-base sm:text-lg md:text-xl text-gray-600 mb-10 max-w-2xl mx-auto">Accept EcoCash payments instantly. No website needed. We build it for you.</p>
        <a href="/apply" class="btn-dark-green text-lg md:text-xl px-8 py-4 hidden md:inline-block">Get Your Catalog</a>
        <div class="mt-6 text-sm md:text-base text-gray-500">Demo: <a href="/lusso-boutique" class="text-green-600 hover:underline">Lusso Boutique</a></div>
    </section>

    <!-- How it works – Carousel -->
    <section class="py-16 md:py-24">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-10 md:mb-16">How it works</h2>
        <div class="carousel-wrapper" id="carousel-wrapper">
            <div class="carousel-track" id="carousel-track">
                <div class="carousel-card">
                    <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center h-full">
                        <div class="text-3xl md:text-4xl mb-3 text-green-600">1.</div>
                        <h3 class="font-semibold text-base md:text-lg mb-2">Apply with your products</h3>
                        <p class="text-sm md:text-base text-gray-600">Fill a simple form with your business name, products, and photos.</p>
                    </div>
                </div>
                <div class="carousel-card">
                    <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center h-full">
                        <div class="text-3xl md:text-4xl mb-3 text-green-600">2.</div>
                        <h3 class="font-semibold text-base md:text-lg mb-2">We build your catalog</h3>
                        <p class="text-sm md:text-base text-gray-600">We create a beautiful catalog with EcoCash checkout just for you.</p>
                    </div>
                </div>
                <div class="carousel-card">
                    <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center h-full">
                        <div class="text-3xl md:text-4xl mb-3 text-green-600">3.</div>
                        <h3 class="font-semibold text-base md:text-lg mb-2">Share & get paid</h3>
                        <p class="text-sm md:text-base text-gray-600">Share your catalog link on WhatsApp and receive payments instantly.</p>
                    </div>
                </div>
                <div class="carousel-card">
                    <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center h-full">
                        <div class="text-3xl md:text-4xl mb-3 text-green-600">1.</div>
                        <h3 class="font-semibold text-base md:text-lg mb-2">Apply with your products</h3>
                        <p class="text-sm md:text-base text-gray-600">Fill a simple form with your business name, products, and photos.</p>
                    </div>
                </div>
                <div class="carousel-card">
                    <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center h-full">
                        <div class="text-3xl md:text-4xl mb-3 text-green-600">2.</div>
                        <h3 class="font-semibold text-base md:text-lg mb-2">We build your catalog</h3>
                        <p class="text-sm md:text-base text-gray-600">We create a beautiful catalog with EcoCash checkout just for you.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-dots">
            <span class="carousel-dot active" data-index="0"></span>
            <span class="carousel-dot" data-index="1"></span>
            <span class="carousel-dot" data-index="2"></span>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="max-w-5xl mx-auto px-4 py-16 md:py-24">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-10 md:mb-16">What our clients say</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-10">
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-2xl">T</div>
                </div>
                <div class="flex justify-center gap-1 mb-3">
                    <span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span>
                </div>
                <p class="text-gray-600 italic text-sm md:text-base">"My customers love how easy it is to browse and pay. I get more orders now."</p>
                <p class="mt-4 font-semibold md:text-lg">Tinashe</p>
                <p class="text-sm text-gray-400">Harare</p>
            </div>
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-2xl">R</div>
                </div>
                <div class="flex justify-center gap-1 mb-3">
                    <span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span>
                </div>
                <p class="text-gray-600 italic text-sm md:text-base">"I was just using WhatsApp. Now I have a real store my customers trust."</p>
                <p class="mt-4 font-semibold md:text-lg">Rumbi</p>
                <p class="text-sm text-gray-400">Bulawayo</p>
            </div>
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-2xl">F</div>
                </div>
                <div class="flex justify-center gap-1 mb-3">
                    <span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span>
                </div>
                <p class="text-gray-600 italic text-sm md:text-base">"Catalog.Inc set up my catalog in one day. It is exactly what I needed."</p>
                <p class="mt-4 font-semibold md:text-lg">Farai</p>
                <p class="text-sm text-gray-400">Mutare</p>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="max-w-3xl mx-auto px-4 py-16 md:py-24">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-10">Frequently asked questions</h2>
        <div class="mb-6">
            <input type="text" id="faq-search" placeholder="Search questions..." class="w-full max-w-md mx-auto block border rounded-xl px-4 py-3 text-sm md:text-base">
        </div>
        <div class="space-y-4" id="faq-list">
            <div class="bg-white rounded-xl shadow-sm faq-item">
                <button class="faq-toggle w-full text-left px-6 py-5 font-semibold flex justify-between items-center text-sm md:text-base" data-target="faq0">
                    How long does it take to get my catalog? <span class="text-green-600 transform transition-transform duration-300">+</span>
                </button>
                <div id="faq0" class="faq-answer px-6 text-gray-600 text-sm md:text-base">
                    <p class="pb-4">We usually deliver your catalog within 2 business hours after you submit your products.</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm faq-item">
                <button class="faq-toggle w-full text-left px-6 py-5 font-semibold flex justify-between items-center text-sm md:text-base" data-target="faq1">
                    Can I update my catalog later? <span class="text-green-600 transform transition-transform duration-300">+</span>
                </button>
                <div id="faq1" class="faq-answer px-6 text-gray-600 text-sm md:text-base">
                    <p class="pb-4">Yes. Just send us your new products or changes via WhatsApp and we update it for free.</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm faq-item">
                <button class="faq-toggle w-full text-left px-6 py-5 font-semibold flex justify-between items-center text-sm md:text-base" data-target="faq2">
                    How do I receive payments? <span class="text-green-600 transform transition-transform duration-300">+</span>
                </button>
                <div id="faq2" class="faq-answer px-6 text-gray-600 text-sm md:text-base">
                    <p class="pb-4">Customers pay directly to your EcoCash number. The catalog shows your number and order reference. You confirm payment manually.</p>
                </div>
            </div>
        </div>
        <p class="text-center mt-6 text-sm md:text-base text-gray-500">Still have questions? <a href="https://wa.me/263715670833" class="text-green-600 hover:underline">Chat with us on WhatsApp</a></p>
    </section>

    <!-- Newsletter -->
    <section class="max-w-xl mx-auto px-4 py-16 text-center">
        <h3 class="text-xl md:text-2xl font-semibold mb-3">Not ready to apply?</h3>
        <p class="text-sm md:text-base text-gray-500 mb-6">Leave your email and we'll send you more information.</p>
        <form class="flex flex-col sm:flex-row gap-3 justify-center" onsubmit="event.preventDefault(); alert('Thanks! We will be in touch.'); this.reset();">
            <input type="email" placeholder="your@email.com" class="flex-1 border rounded-xl px-4 py-3 text-sm md:text-base">
            <button type="submit" class="bg-[#0A8F3C] text-white px-6 py-3 rounded-xl text-sm md:text-base font-medium hover:bg-green-700">Notify me</button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="text-center py-8 text-gray-400 text-sm border-t mb-16 md:mb-0">
        &copy; {{ date('Y') }} Catalog.Inc. All rights reserved.
        <a href="https://wa.me/263715670833" class="text-green-600 hover:underline">Contact us</a> &middot;
        <a href="/privacy" class="text-green-600 hover:underline">Privacy</a> &middot;
        <a href="/terms" class="text-green-600 hover:underline">Terms</a>
    </footer>

    <!-- Sticky mobile CTA -->
    <div class="sticky-mobile-cta">
        <a href="/apply" class="btn-dark-green w-full text-center block">Get Your Catalog</a>
    </div>

    <!-- Back to top -->
    <div class="back-to-top" id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
    </div>

    <script>
        const btt = document.getElementById('btt');
        window.addEventListener('scroll', () => btt.classList.toggle('visible', window.scrollY > 300));

        const words = ['WhatsApp', 'Facebook', 'Instagram'];
        let wordIndex = 0;
        const typewriter = document.getElementById('typewriter-text');
        setInterval(() => {
            wordIndex = (wordIndex + 1) % words.length;
            typewriter.style.opacity = '0';
            setTimeout(() => {
                typewriter.textContent = words[wordIndex];
                typewriter.style.opacity = '1';
            }, 200);
        }, 2500);
        typewriter.style.transition = 'opacity 0.2s';

        document.querySelectorAll('.faq-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const target = document.getElementById(btn.dataset.target);
                const isOpen = target.classList.contains('open');
                document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('open'));
                document.querySelectorAll('.faq-toggle span').forEach(s => s.textContent = '+');
                if (!isOpen) {
                    target.classList.add('open');
                    btn.querySelector('span').textContent = '-';
                }
            });
        });
        document.getElementById('faq-search').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('.faq-item').forEach(item => {
                const question = item.querySelector('.faq-toggle').textContent.toLowerCase();
                item.style.display = question.includes(filter) ? '' : 'none';
            });
        });

        const track = document.getElementById('carousel-track');
        const cards = track.querySelectorAll('.carousel-card');
        const dots = document.querySelectorAll('.carousel-dot');
        const totalOriginals = 3;
        let currentIndex = 0;
        let autoSlideInterval;

        function updateCarousel(index) {
            const offset = -index * cards[0].offsetWidth;
            track.style.transform = `translateX(${offset}px)`;
            cards.forEach((card, i) => card.classList.toggle('active', i === index));
            dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
            if (index === totalOriginals) {
                setTimeout(() => {
                    track.style.transition = 'none';
                    currentIndex = 0;
                    track.style.transform = `translateX(0px)`;
                    cards.forEach((card, i) => card.classList.toggle('active', i === 0));
                    dots.forEach((dot, i) => dot.classList.toggle('active', i === 0));
                    setTimeout(() => { track.style.transition = 'transform 0.5s ease'; }, 50);
                }, 500);
            }
            currentIndex = index;
        }

        function autoSlide() { updateCarousel(currentIndex + 1); }
        function startAutoSlide() { autoSlideInterval = setInterval(autoSlide, 3000); }
        function stopAutoSlide() { clearInterval(autoSlideInterval); }

        updateCarousel(0);
        startAutoSlide();

        document.getElementById('carousel-wrapper').addEventListener('mouseenter', stopAutoSlide);
        document.getElementById('carousel-wrapper').addEventListener('mouseleave', startAutoSlide);

        dots.forEach(dot => {
            dot.addEventListener('click', () => updateCarousel(parseInt(dot.dataset.index)));
        });

        let touchStartX = 0;
        track.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; });
        track.addEventListener('touchend', e => {
            const diff = e.changedTouches[0].screenX - touchStartX;
            if (Math.abs(diff) > 50) {
                stopAutoSlide();
                updateCarousel(diff < 0 ? currentIndex + 1 : currentIndex - 1);
                startAutoSlide();
            }
        });

        window.addEventListener('resize', () => {
            track.style.transition = 'none';
            updateCarousel(currentIndex);
            setTimeout(() => { track.style.transition = 'transform 0.5s ease'; }, 50);
        });
    </script>
</body>
</html>
