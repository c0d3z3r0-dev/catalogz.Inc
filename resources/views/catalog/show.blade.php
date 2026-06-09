@extends('layouts.catalog')

@section('content')
<!-- This view now includes: localStorage cart save, toast, live count, recently viewed, sticky mobile add-to-basket -->
<div class="max-w-7xl mx-auto px-4 pt-20 pb-6 sm:pt-24 sm:pb-8">
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">{{ session('success') }}</div>
    @endif

    <div class="mb-6">
        <input type="text" id="productSearch" placeholder="Search products..."
               class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0A8F3C] focus:border-transparent text-sm">
    </div>

    <div class="product-grid grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
        @forelse ($products as $product)
        <div class="card-float product-card" data-name="{{ strtolower($product->name) }}">
            @php
                $imgUrl = null;
                if ($product->image_path) {
                    if (Str::startsWith($product->image_path, 'http')) {
                        $imgUrl = $product->image_path;
                    } else {
                        $imgUrl = secure_asset('storage/' . $product->image_path);
                    }
                }
            @endphp
            <div class="quick-view-trigger cursor-pointer image-container"
                 data-name="{{ $product->name }}"
                 data-description="{{ $product->description }}"
                 data-price="{{ number_format($product->price, 2) }}"
                 data-image="{{ $imgUrl }}"
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

    <!-- Recently Viewed (hidden by default) -->
    <div id="recently-viewed" class="mt-10 hidden">
        <h3 class="text-lg font-semibold mb-4">Recently Viewed</h3>
        <div id="recently-viewed-list" class="flex gap-4 overflow-x-auto pb-2"></div>
    </div>
</div>

<!-- Quick-View Modal with sticky bottom bar -->
<div id="quick-view-modal" class="modal">
    <div class="modal-content flex flex-col max-h-[90vh]">
        <button id="close-modal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl leading-none z-10">&times;</button>
        <div class="flex-1 overflow-y-auto">
            <div class="image-container rounded-lg mb-4">
                <img id="modal-image" src="" class="product-image" alt="">
            </div>
            <h3 id="modal-name" class="text-lg sm:text-xl font-bold"></h3>
            <p id="modal-description" class="text-gray-600 my-2 text-sm sm:text-base"></p>
            <p id="modal-price" class="text-xl sm:text-2xl font-bold text-green-600 mb-4"></p>
        </div>
        <!-- Sticky Add-to-Basket bar inside modal -->
        <div class="sticky bottom-0 bg-white pt-3 border-t mt-3">
            <form onsubmit="return false;" class="flex gap-2">
                <input type="hidden" id="modal-product-id">
                <input type="number" id="modal-quantity" value="1" min="1" class="w-16 sm:w-20 border rounded-xl px-2 py-2 text-center">
                <button onclick="addToBasketFromModal()" class="btn-dark-green flex-1 py-2">Add to Basket</button>
            </form>
        </div>
    </div>
</div>

<!-- Toast Notification Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true });

    const modal = document.getElementById('quick-view-modal');
    const modalProductId = document.getElementById('modal-product-id');
    const modalImage = document.getElementById('modal-image');
    const modalName = document.getElementById('modal-name');
    const modalDescription = document.getElementById('modal-description');
    const modalPrice = document.getElementById('modal-price');
    const cartBadge = document.getElementById('cart-badge');

    // ----- Quick View -----
    document.querySelectorAll('.quick-view-trigger').forEach(el => {
        el.addEventListener('click', (e) => {
            e.stopPropagation();
            modalImage.src = el.dataset.image || '';
            modalImage.style.display = el.dataset.image ? '' : 'none';
            modalName.textContent = el.dataset.name;
            modalDescription.textContent = el.dataset.description;
            modalPrice.textContent = '$' + el.dataset.price;
            modalProductId.value = el.dataset.productId;
            document.getElementById('modal-quantity').value = 1;
            modal.classList.add('active');

            // Save to recently viewed
            saveRecentlyViewed(el.dataset.productId, el.dataset.name, el.dataset.image, el.dataset.price);
        });
    });
    document.getElementById('close-modal').addEventListener('click', () => modal.classList.remove('active'));
    window.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('active'); });

    // ----- Add to Basket (AJAX) -----
    async function addToBasket(productId, qty = 1) {
        const slug = window.location.pathname.split('/')[1];
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
                // Save to localStorage for persistence
                saveCartToLocal(productId, qty);
            }
        } catch (err) {
            console.error(err);
        }
    }
    function addToBasketFromModal() {
        const id = modalProductId.value;
        const qty = document.getElementById('modal-quantity').value;
        addToBasket(id, qty);
        modal.classList.remove('active');
    }

    // ----- Toast -----
    function showToast(msg) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = 'bg-green-600 text-white px-4 py-2 rounded-xl shadow text-sm animate-slide-in';
        toast.textContent = msg;
        container.appendChild(toast);
        setTimeout(() => { toast.remove(); }, 2500);
    }

    // ----- Live Cart Count (poll every 30s) -----
    function updateCartCount() {
        const slug = window.location.pathname.split('/')[1];
        fetch(`/${slug}/cart/count`)
            .then(r => r.json())
            .then(data => { cartBadge.textContent = data.count; });
    }
    setInterval(updateCartCount, 30000);
    updateCartCount(); // initial load

    // ----- Save Cart to localStorage -----
    function saveCartToLocal(productId, qty) {
        let cart = JSON.parse(localStorage.getItem('catalog_cart') || '{}');
        cart[productId] = (cart[productId] || 0) + qty;
        localStorage.setItem('catalog_cart', JSON.stringify(cart));
    }
    // On page load, restore cart if session empty
    (function restoreCart() {
        if (cartBadge.textContent === '0') {
            const saved = localStorage.getItem('catalog_cart');
            if (saved) {
                const cart = JSON.parse(saved);
                Object.keys(cart).forEach(id => {
                    addToBasket(id, cart[id]);
                });
                // Clear localStorage after restore to avoid double-add
                localStorage.removeItem('catalog_cart');
            }
        }
    })();

    // ----- Recently Viewed -----
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
        if (viewed.length === 0) {
            container.classList.add('hidden');
            return;
        }
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

    // ----- Search -----
    document.getElementById('productSearch').addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('.product-card').forEach(card => {
            card.style.display = card.dataset.name.includes(filter) ? '' : 'none';
        });
    });
</script>
