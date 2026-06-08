<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    
    
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog.Inc – Catalogs that bring money</title>
    <link rel="manifest" href="/manifest.json">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #efeae2;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d4cdc2' fill-opacity='0.6'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3Ccircle cx='60' cy='60' r='2'/%3E%3Ccircle cx='40' cy='10' r='1.5'/%3E%3Ccircle cx='10' cy='50' r='1.5'/%3E%3Ccircle cx='70' cy='30' r='1.5'/%3E%3Ccircle cx='30' cy='70' r='1'/%3E%3Ccircle cx='50' cy='40' r='1'/%3E%3Ccircle cx='15' cy='35' r='1'/%3E%3Ccircle cx='65' cy='15' r='1'/%3E%3Ccircle cx='45' cy='55' r='1'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 80px 80px;
            margin: 0;
            scroll-behavior: smooth;
            color: #1e293b;
        }
        .btn-primary {
            background-color: #0A8F3C;
            color: white;
            border-radius: 14px;
            padding: 16px 32px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            display: inline-block;
            box-shadow: 0 4px 14px rgba(10,143,60,0.3);
            text-decoration: none;
        }
        .btn-primary:hover {
            background-color: #047A2D;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(10,143,60,0.4);
        }
        .btn-secondary {
            background-color: white;
            color: #0A8F3C;
            border: 2px solid #0A8F3C;
            border-radius: 14px;
            padding: 14px 30px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            display: inline-block;
            text-decoration: none;
        }
        .btn-secondary:hover {
            background-color: #f0fdf4;
            transform: translateY(-2px);
        }
        .sticky-mobile-cta {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: white; border-top: 1px solid #e5e7eb;
            padding: 12px 16px; z-index: 40;
            display: none;
        }
        @media (max-width: 768px) { .sticky-mobile-cta { display: block; } }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; }
        .faq-answer.open { max-height: 200px; }
        .carousel-wrapper { overflow: hidden; position: relative; max-width: 900px; margin: 0 auto; }
        .carousel-track { display: flex; transition: transform 0.5s ease; }
        .carousel-card {
            min-width: 280px; flex-shrink: 0; padding: 0 16px;
            transform: scale(0.92); opacity: 0.5;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }
        .carousel-card.active { transform: scale(1.05); opacity: 1; z-index: 2; }
        .carousel-dots { display: flex; justify-content: center; gap: 10px; margin-top: 24px; }
        .carousel-dot { width: 12px; height: 12px; border-radius: 50%; background: #d1d5db; cursor: pointer; transition: all 0.3s; }
        .carousel-dot.active { background: #0A8F3C; width: 32px; border-radius: 6px; }
        .star { color: #f59e0b; }
        .back-to-top {
            position: fixed; bottom: 90px; right: 30px; z-index: 49;
            background: white; border-radius: 50%; width: 44px; height: 44px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15); cursor: pointer;
            opacity: 0; transition: opacity 0.3s;
        }
        .back-to-top.visible { opacity: 1; }
        @media (max-width: 640px) {
            .carousel-card { min-width: 240px; }
            .back-to-top { bottom: 80px; right: 16px; }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Nav -->
    <nav class="bg-[#1e2a3a] shadow-card sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <span class="text-2xl font-bold tracking-tight">
                <span class="text-white">Catalog.</span><span class="text-green-400">Inc</span>
            </span>
            <a href="/login" class="text-sm text-gray-300 hover:text-white font-medium transition">Admin Login</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="max-w-5xl mx-auto px-6 py-16 md:py-24 text-center relative">
        <!-- Floating illustration (lightweight CSS shape) -->
        <div class="absolute top-10 left-10 w-24 h-24 bg-green-200 rounded-full opacity-20 blur-xl hidden md:block"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-green-300 rounded-full opacity-20 blur-xl hidden md:block"></div>

        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 tracking-tight">
            Turn your <span id="typewriter-text" class="text-[#0A8F3C]">WhatsApp</span> into a beautiful online store
        </h1>
        <p class="text-lg md:text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
            Accept EcoCash payments instantly. No website needed. We build it for you.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="/apply" class="btn-primary">Get Your Catalog</a>
            <a href="/lusso-boutique" class="btn-secondary">View Demo Store</a>
        </div>
        <p class="mt-8 text-sm text-gray-500">Already trusted by 15+ businesses</p>
    </section>

    <!-- How it works – Carousel -->
    <section class="py-12 md:py-16">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-10">How it works</h2>
        <div class="carousel-wrapper" id="carousel-wrapper">
            <div class="carousel-track" id="carousel-track">
                <div class="carousel-card">
                    <div class="bg-white p-8 rounded-2xl shadow-card text-center h-full border border-gray-100">
                        <div class="text-4xl mb-4 text-[#0A8F3C] font-bold">1.</div>
                        <h3 class="font-semibold text-xl mb-3">Apply with your products</h3>
                        <p class="text-gray-600 leading-relaxed">Fill a simple form with your business name, products, and photos.</p>
                    </div>
                </div>
                <div class="carousel-card">
                    <div class="bg-white p-8 rounded-2xl shadow-card text-center h-full border border-gray-100">
                        <div class="text-4xl mb-4 text-[#0A8F3C] font-bold">2.</div>
                        <h3 class="font-semibold text-xl mb-3">We build your catalog</h3>
                        <p class="text-gray-600 leading-relaxed">We create a beautiful catalog with EcoCash checkout just for you.</p>
                    </div>
                </div>
                <div class="carousel-card">
                    <div class="bg-white p-8 rounded-2xl shadow-card text-center h-full border border-gray-100">
                        <div class="text-4xl mb-4 text-[#0A8F3C] font-bold">3.</div>
                        <h3 class="font-semibold text-xl mb-3">Share & get paid</h3>
                        <p class="text-gray-600 leading-relaxed">Share your catalog link on WhatsApp and receive payments instantly.</p>
                    </div>
                </div>
                <div class="carousel-card">
                    <div class="bg-white p-8 rounded-2xl shadow-card text-center h-full border border-gray-100">
                        <div class="text-4xl mb-4 text-[#0A8F3C] font-bold">1.</div>
                        <h3 class="font-semibold text-xl mb-3">Apply with your products</h3>
                        <p class="text-gray-600 leading-relaxed">Fill a simple form with your business name, products, and photos.</p>
                    </div>
                </div>
                <div class="carousel-card">
                    <div class="bg-white p-8 rounded-2xl shadow-card text-center h-full border border-gray-100">
                        <div class="text-4xl mb-4 text-[#0A8F3C] font-bold">2.</div>
                        <h3 class="font-semibold text-xl mb-3">We build your catalog</h3>
                        <p class="text-gray-600 leading-relaxed">We create a beautiful catalog with EcoCash checkout just for you.</p>
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
    <section class="max-w-5xl mx-auto px-6 py-12 md:py-16">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-10">What our clients say</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-card text-center border border-gray-100">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-2xl">T</div>
                </div>
                <div class="flex justify-center gap-1 mb-3 text-xl">
                    <span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span>
                </div>
                <p class="text-gray-600 italic mb-4 leading-relaxed">"My customers love how easy it is to browse and pay. I get more orders now."</p>
                <p class="font-semibold text-lg">Tinashe</p>
                <p class="text-sm text-gray-400">Harare</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-card text-center border border-gray-100">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-2xl">R</div>
                </div>
                <div class="flex justify-center gap-1 mb-3 text-xl">
                    <span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span>
                </div>
                <p class="text-gray-600 italic mb-4 leading-relaxed">"I was just using WhatsApp. Now I have a real store my customers trust."</p>
                <p class="font-semibold text-lg">Rumbi</p>
                <p class="text-sm text-gray-400">Bulawayo</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-card text-center border border-gray-100">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-2xl">F</div>
                </div>
                <div class="flex justify-center gap-1 mb-3 text-xl">
                    <span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span><span class="star">&#9733;</span>
                </div>
                <p class="text-gray-600 italic mb-4 leading-relaxed">"Catalog.Inc set up my catalog in one day. It is exactly what I needed."</p>
                <p class="font-semibold text-lg">Farai</p>
                <p class="text-sm text-gray-400">Mutare</p>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="max-w-3xl mx-auto px-6 py-12 md:py-16">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-10">Frequently asked questions</h2>
        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow-card border border-gray-100 faq-item">
                <button class="faq-toggle w-full text-left px-6 py-5 font-semibold flex justify-between items-center text-lg" data-target="faq0">
                    How long does it take to get my catalog? <span class="text-[#0A8F3C] transform transition-transform duration-300 text-2xl">+</span>
                </button>
                <div id="faq0" class="faq-answer px-6 text-gray-600">
                    <p class="pb-5 leading-relaxed">We usually deliver your catalog within 2 business hours after you submit your products.</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-card border border-gray-100 faq-item">
                <button class="faq-toggle w-full text-left px-6 py-5 font-semibold flex justify-between items-center text-lg" data-target="faq1">
                    Can I update my catalog later? <span class="text-[#0A8F3C] transform transition-transform duration-300 text-2xl">+</span>
                </button>
                <div id="faq1" class="faq-answer px-6 text-gray-600">
                    <p class="pb-5 leading-relaxed">Yes. Just send us your new products or changes via WhatsApp and we update it for free.</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-card border border-gray-100 faq-item">
                <button class="faq-toggle w-full text-left px-6 py-5 font-semibold flex justify-between items-center text-lg" data-target="faq2">
                    How do I receive payments? <span class="text-[#0A8F3C] transform transition-transform duration-300 text-2xl">+</span>
                </button>
                <div id="faq2" class="faq-answer px-6 text-gray-600">
                    <p class="pb-5 leading-relaxed">Customers pay directly to your EcoCash number. The catalog shows your number and order reference. You confirm payment manually.</p>
                </div>
            </div>
        </div>
        <p class="text-center mt-8 text-sm text-gray-500">Still have questions? <a href="https://wa.me/263715670833" class="text-[#0A8F3C] font-medium hover:underline">Chat with us on WhatsApp</a></p>
    </section>

    <!-- Newsletter -->
    <section class="max-w-xl mx-auto px-6 py-12 text-center">
        <h3 class="text-2xl font-semibold mb-3">Not ready to apply?</h3>
        <p class="text-gray-500 mb-6">Leave your email and we'll send you more information.</p>
        <form class="flex flex-col sm:flex-row gap-3" onsubmit="event.preventDefault(); alert('Thanks! We will be in touch.'); this.reset();">
            <input type="email" placeholder="your@email.com" class="flex-1 border rounded-xl px-5 py-3 text-base focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
            <button type="submit" class="btn-primary whitespace-nowrap">Notify me</button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="text-center py-8 text-gray-400 text-sm border-t">
        <p>&copy; {{ date('Y') }} Catalog.Inc. All rights reserved.</p>
        <p class="mt-2">
            <a href="https://wa.me/263715670833" class="text-[#0A8F3C] hover:underline">Contact us</a> &middot;
            <a href="/privacy" class="text-[#0A8F3C] hover:underline">Privacy</a> &middot;
            <a href="/terms" class="text-[#0A8F3C] hover:underline">Terms</a>
        </p>
    </footer>

    <!-- Sticky mobile CTA -->
    <div class="sticky-mobile-cta">
        <a href="/apply" class="btn-primary w-full text-center block">Get Your Catalog</a>
    </div>

    <!-- Back to top -->
    <div class="back-to-top" id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
    </div>

    <script>
        // Back to top
        const btt = document.getElementById('btt');
        window.addEventListener('scroll', () => btt.classList.toggle('visible', window.scrollY > 300));

        // Typewriter effect with colors (Instagram = red)
        const words = [
            { text: 'WhatsApp', color: 'text-[#0A8F3C]' },
            { text: 'Facebook', color: 'text-blue-600' },
            { text: 'Instagram', color: 'text-red-600' }
        ];
        let wordIndex = 0;
        const typewriter = document.getElementById('typewriter-text');
        setInterval(() => {
            wordIndex = (wordIndex + 1) % words.length;
            typewriter.style.opacity = '0';
            setTimeout(() => {
                typewriter.textContent = words[wordIndex].text;
                typewriter.className = words[wordIndex].color + ' transition-colors duration-300';
                typewriter.style.opacity = '1';
            }, 200);
        }, 2500);
        typewriter.style.transition = 'opacity 0.2s';

        // FAQ
        document.querySelectorAll('.faq-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const target = document.getElementById(btn.dataset.target);
                const isOpen = target.classList.contains('open');
                document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('open'));
                document.querySelectorAll('.faq-toggle span').forEach(s => s.textContent = '+');
                if (!isOpen) { target.classList.add('open'); btn.querySelector('span').textContent = '-'; }
            });
        });

        // Carousel
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
                    track.style.transform = 'translateX(0px)';
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

        dots.forEach(dot => dot.addEventListener('click', () => updateCarousel(parseInt(dot.dataset.index))));

        let touchStartX = 0;
        track.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; });
        track.addEventListener('touchend', e => {
            const diff = e.changedTouches[0].screenX - touchStartX;
            if (Math.abs(diff) > 50) { stopAutoSlide(); updateCarousel(diff < 0 ? currentIndex + 1 : currentIndex - 1); startAutoSlide(); }
        });

        window.addEventListener('resize', () => {
            track.style.transition = 'none';
            updateCarousel(currentIndex);
            setTimeout(() => { track.style.transition = 'transform 0.5s ease'; }, 50);
        });
    </script>
</body>
</html>




