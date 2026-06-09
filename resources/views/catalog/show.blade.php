<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $client->name }} - Catalog.Inc</title>
    <meta property="og:title" content="{{ $client->name }} - Catalog.Inc">
    <meta property="og:description" content="Shop online with {{ $client->name }}. Pay with EcoCash.">
    @if($client->logo_path)
    <meta property="og:image" content="{{ secure_asset('storage/' . $client->logo_path) }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --green-600: #0A8F3C; --green-700: #047A2D; }
        body {
            background-color: #efeae2;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d4cdc2' fill-opacity='0.6'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3Ccircle cx='60' cy='60' r='2'/%3E%3Ccircle cx='40' cy='10' r='1.5'/%3E%3Ccircle cx='10' cy='50' r='1.5'/%3E%3Ccircle cx='70' cy='30' r='1.5'/%3E%3Ccircle cx='30' cy='70' r='1'/%3E%3Ccircle cx='50' cy='40' r='1'/%3E%3Ccircle cx='15' cy='35' r='1'/%3E%3Ccircle cx='65' cy='15' r='1'/%3E%3Ccircle cx='45' cy='55' r='1'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 80px 80px;
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
            color: #333;
            margin: 0; padding-bottom: 40px;
        }
        .card-float { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: all 0.2s; overflow: hidden; }
        .card-float:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,0,0,0.10); }
        .btn-dark-green { background: #0A8F3C; color: white; border-radius: 12px; padding: 8px 16px; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; min-height: 48px; }
        .btn-dark-green:hover { background: #047A2D; transform: translateY(-1px); }
        .sticky-cart { position: fixed; bottom: 80px; right: 24px; z-index: 50; background: #0A8F3C; color: white; width: 56px; height: 56px; border-radius: 50%; box-shadow: 0 4px 20px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; }
        .sticky-whatsapp { position: fixed; bottom: 80px; left: 24px; z-index: 50; background: #25D366; color: white; width: 56px; height: 56px; border-radius: 50%; box-shadow: 0 4px 20px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center; }
        .modal.active { display: flex; }
        .modal-content { background: white; border-radius: 16px; padding: 1.5rem; max-width: 95vw; width: 500px; max-height: 90vh; overflow-y: auto; }
        .top-bar { background: #0A8F3C !important; color: white; }
        .image-container { position: relative; width: 100%; padding-top: 100%; overflow: hidden; background: #e5e7eb; }
        .image-container img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
        .sold-out-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.2rem; text-transform: uppercase; }
        .skeleton { background: linear-gradient(90deg, #e5e7eb 25%, #d1d5db 50%, #e5e7eb 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        /* Toast animation */
        @keyframes slideIn { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }
        .animate-slide-in { animation: slideIn 0.3s ease; }
        /* Responsive */
        @media (max-width: 640px) {
            .sticky-cart, .sticky-whatsapp { bottom: 56px; width: 48px; height: 48px; }
            .sticky-cart { right: 16px; } .sticky-whatsapp { left: 16px; }
        }
    </style>
</head>
<body>

    <header class="top-bar fixed top-0 left-0 right-0 z-30">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if($client->logo_path)
                    <img src="{{ secure_asset('storage/' . $client->logo_path) }}" alt="{{ $client->name }}" class="h-8 w-8 sm:h-10 sm:w-10 rounded-full object-cover">
                @endif
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold text-white">{{ $client->name }}</h1>
                    @if($client->address)
                        <p class="text-xs sm:text-sm text-white/80">{{ $client->address }}{{ $client->city ? ', '.$client->city : '' }}</p>
                    @endif
                </div>
            </div>
            <a href="{{ route('catalog.cart', $client->slug) }}" class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" /></svg>
                <span id="cart-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 pt-20 pb-6 sm:pt-24 sm:pb-8">
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">{{ session('success') }}</div>
        @endif
        <div class="mb-6">
            <input type="text" id="productSearch" placeholder="Search products..."
                   class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0A8F3C] focus:border-transparent text-sm">
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            @forelse ($products as $product)
            <div class="card-float product-card" data-name="{{ strtolower($product->name) }}">
                @php
                    $imgUrl = $product->image_path ? (Str::startsWith($product->image_path, 'http') ? $product->image_path : secure_asset('storage/' . $product->image_path)) : null;
                @endphp
                <div class="quick-view-trigger cursor-pointer image-container"
                     data-name="{{ $product->name }}" data-description="{{ $product->description }}"
                     data-price="{{ number_format($product->price, 2) }}" data-image="{{ $imgUrl }}"
                     data-product-id="{{ $product->id }}">
                    <div class="skeleton absolute inset-0"></div>
                    @if ($imgUrl)
                        <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="product-image relative z-10" loading="lazy" onload="this.previousElementSibling.style.display='none'">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400 text-sm">No image</div>
                    @endif
                    @if (!$product->is_available)
                        <div class="sold-out-overlay z-20">Sold out</div>
                    @endif
                </div>
                <div class="p-4 sm:p-6">
                    <h3 class="font-semibold text-gray-800 text-sm sm:text-lg mb-2 line-clamp-2">{{ $product->name }}</h3>
                    <p class="text-xs sm:text-sm text-gray-500 mb-3 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-base sm:text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        @if($product->is_available)
                        <button onclick="addToBasket({{ $product->id }})" class="btn-dark-green px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm">Add to Basket</button>
                        @else
                        <span class="text-sm text-gray-400">Unavailable</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-gray-400">No products available yet.</div>
            @endforelse
        </div>
        <!-- Recently Viewed -->
        <div id="recently-viewed" class="mt-10 hidden">
            <h3 class="text-lg font-semibold mb-4">Recently Viewed</h3>
            <div id="recently-viewed-list" class="flex gap-4 overflow-x-auto pb-2"></div>
        </div>
    </main>

    <!-- Floating Buttons -->
    <a href="https://wa.me/{{ $client->whatsapp_number }}?text=Hello%2C%20I%27m%20interested%20in%20your%20products" target="_blank" class="sticky-whatsapp" title="Chat on WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>
    <a href="{{ route('catalog.cart', $client->slug) }}" class="sticky-cart">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" /></svg>
    </a>

    <!-- Quick-View Modal -->
    <div id="quick-view-modal" class="modal">
        <div class="modal-content relative">
            <button id="close-modal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl leading-none z-10">&times;</button>
            <div class="image-container rounded-lg mb-4">
                <img id="modal-image" src="" class="product-image" alt="">
            </div>
            <h3 id="modal-name" class="text-lg sm:text-xl font-bold"></h3>
            <p id="modal-description" class="text-gray-600 my-2 text-sm sm:text-base"></p>
            <p id="modal-price" class="text-xl sm:text-2xl font-bold text-green-600 mb-4"></p>
            <div class="border-t pt-3">
                <form onsubmit="return false;" class="flex gap-2">
                    <input type="hidden" id="modal-product-id">
                    <input type="number" id="modal-quantity" value="1" min="1" class="w-16 sm:w-20 border rounded-xl px-2 py-2 text-center">
                    <button onclick="addToBasketFromModal()" class="btn-dark-green flex-1 py-2">Add to Basket</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });
        const modal = document.getElementById('quick-view-modal');
        const modalProductId = document.getElementById('modal-product-id');
        const modalImage = document.getElementById('modal-image');
        const modalName = document.getElementById('modal-name');
        const modalDesc = document.getElementById('modal-description');
        const modalPrice = document.getElementById('modal-price');
        const cartBadge = document.getElementById('cart-badge');
        const slug = '{{ $client->slug }}';

        // Quick View
        document.querySelectorAll('.quick-view-trigger').forEach(el => {
            el.addEventListener('click', (e) => {
                e.stopPropagation();
                modalImage.src = el.dataset.image || '';
                modalImage.style.display = el.dataset.image ? '' : 'none';
                modalName.textContent = el.dataset.name;
                modalDesc.textContent = el.dataset.description;
                modalPrice.textContent = '$' + el.dataset.price;
                modalProductId.value = el.dataset.productId;
                document.getElementById('modal-quantity').value = 1;
                modal.classList.add('active');
                saveRecentlyViewed(el.dataset.productId, el.dataset.name, el.dataset.image, el.dataset.price);
            });
        });
        document.getElementById('close-modal').addEventListener('click', () => modal.classList.remove('active'));
        window.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('active'); });

        // AJAX Add to Basket
        async function addToBasket(productId, qty = 1) {
            try {
                const res = await fetch(`/${slug}/cart/add-ajax`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: `product_id=${productId}&quantity=${qty}`
                });
                const data = await res.json();
                if (data.success) {
                    cartBadge.textContent = data.cart_count;
                    showToast(data.message);
                    saveCartToLocal(productId, qty);
                }
            } catch (err) { console.error(err); }
        }
        function addToBasketFromModal() {
            const id = modalProductId.value;
            const qty = document.getElementById('modal-quantity').value;
            addToBasket(id, qty);
            modal.classList.remove('active');
        }

        // Toast
        function showToast(msg) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'bg-green-600 text-white px-4 py-2 rounded-xl shadow text-sm animate-slide-in';
            toast.textContent = msg;
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 2500);
        }

        // Live Cart Count
        function updateCartCount() {
            fetch(`/${slug}/cart/count`)
                .then(r => r.json())
                .then(data => { cartBadge.textContent = data.count; });
        }
        setInterval(updateCartCount, 30000);
        updateCartCount();

        // localStorage Cart Persistence
        function saveCartToLocal(productId, qty) {
            let cart = JSON.parse(localStorage.getItem('catalog_cart') || '{}');
            cart[productId] = (cart[productId] || 0) + qty;
            localStorage.setItem('catalog_cart', JSON.stringify(cart));
        }
        (function restoreCart() {
            if (cartBadge.textContent === '0') {
                const saved = localStorage.getItem('catalog_cart');
                if (saved) {
                    const cart = JSON.parse(saved);
                    Object.keys(cart).forEach(id => addToBasket(id, cart[id]));
                    localStorage.removeItem('catalog_cart');
                }
            }
        })();

        // Recently Viewed
        function saveRecentlyViewed(id, name, image, price) {
            let viewed = JSON.parse(localStorage.getItem('recently_viewed') || '[]');
            viewed = viewed.filter(v => v.id != id);
            viewed.unshift({ id, name, image, price });
            if (viewed.length > 4) viewed.pop();
            localStorage.setItem('recently_viewed', JSON.stringify(viewed));
            renderRecentlyViewed();
        }
        function renderRecentlyViewed() {
            const viewed = JSON.parse(localStorage.getItem('recently_viewed') || '[]');
            const container = document.getElementById('recently-viewed');
            const list = document.getElementById('recently-viewed-list');
            if (viewed.length === 0) { container.classList.add('hidden'); return; }
            container.classList.remove('hidden');
            list.innerHTML = viewed.map(v => `
                <div class="flex-shrink-0 w-32 bg-white rounded-xl shadow-sm p-2">
                    <img src="${v.image}" class="h-24 w-full object-cover rounded-lg mb-1">
                    <p class="text-xs font-medium truncate">${v.name}</p>
                    <p class="text-xs font-bold text-green-600">$${v.price}</p>
                </div>
            `).join('');
        }
        renderRecentlyViewed();

        // Search
        document.getElementById('productSearch').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
                card.style.display = card.dataset.name.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
