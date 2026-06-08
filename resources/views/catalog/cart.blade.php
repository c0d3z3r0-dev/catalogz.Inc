<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basket - {{ $client->name }} - Catalog.Inc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #efeae2; background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d4cdc2' fill-opacity='0.6'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3Ccircle cx='60' cy='60' r='2'/%3E%3Ccircle cx='40' cy='10' r='1.5'/%3E%3Ccircle cx='10' cy='50' r='1.5'/%3E%3Ccircle cx='70' cy='30' r='1.5'/%3E%3Ccircle cx='30' cy='70' r='1'/%3E%3Ccircle cx='50' cy='40' r='1'/%3E%3Ccircle cx='15' cy='35' r='1'/%3E%3Ccircle cx='65' cy='15' r='1'/%3E%3Ccircle cx='45' cy='55' r='1'/%3E%3C/g%3E%3C/svg%3E"); background-size: 80px 80px; color: #333; }
        .card-float { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .btn-dark-green { background-color: #0A8F3C; color: white; border-radius: 12px; padding: 14px 24px; font-weight: 600; transition: all 0.2s ease; display: inline-flex; align-items: center; justify-content: center; min-height: 48px; width: 100%; }
        .btn-dark-green:hover { background-color: #047A2D; transform: translateY(-1px); }
        .top-bar { background-color: #0A8F3C !important; }
        .quantity-btn { width: 36px; height: 36px; border-radius: 8px; border: 1px solid #d1d5db; background: white; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; }
        .quantity-btn:hover { background: #f3f4f6; }
        .quantity-input { width: 48px; text-align: center; border: 1px solid #d1d5db; border-radius: 8px; padding: 4px; font-size: 0.95rem; }
        .remove-row { animation: slideOut 0.3s ease forwards; }
        @keyframes slideOut { to { opacity: 0; transform: translateX(30px); max-height: 0; padding: 0; margin: 0; } }
        .btn-loading { pointer-events: none; opacity: 0.7; }
        .spinner { display: none; width: 20px; height: 20px; border: 2px solid white; border-top-color: transparent; border-radius: 50%; animation: spin 0.8s linear infinite; margin-left: 8px; }
        .btn-loading .spinner { display: inline-block; }
        @keyframes spin { to { transform: rotate(360deg); } }
        @media (max-width: 640px) {
            .cart-table td { padding: 0.75rem 0.5rem; font-size: 0.85rem; }
        }
    </style>
</head>
<body>
    <header class="top-bar shadow-sm p-4 sticky top-0 z-30">
        <div class="max-w-3xl mx-auto flex items-center justify-between">
            <h1 class="text-lg sm:text-xl font-bold text-white">
                Basket <span class="text-white/70 text-sm font-normal">({{ count($items) }} item{{ count($items) !== 1 ? 's' : '' }})</span>
            </h1>
            <a href="{{ route('catalog.show', $client->slug) }}" class="text-white/80 hover:text-white underline text-sm">Continue Shopping</a>
        </div>
    </header>
    <main class="max-w-3xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">{{ session('success') }}</div>
        @endif
        @if (empty($items))
            <div class="text-center py-16">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <p class="text-gray-500 text-lg mb-4">Your basket is empty</p>
                <a href="{{ route('catalog.show', $client->slug) }}" class="text-green-600 hover:underline font-medium">Start shopping</a>
            </div>
        @else
            <form method="POST" action="{{ route('catalog.cart.update', $client->slug) }}" id="cart-form">
                @csrf
                <div class="card-float overflow-hidden mb-6">
                    <table class="w-full overflow-x-auto" class="w-full cart-table">
                        <thead class="bg-gray-50 text-left text-sm text-gray-500 hidden sm:table-header-group">
                            <tr><th class="p-4">Product</th><th class="p-4 text-center">Qty</th><th class="p-4 text-right">Total</th><th></th></tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($items as $item)
                            <tr class="cart-row">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gray-200 rounded-xl flex-shrink-0">
                                            @php
                                                $img = $item['product']->image_path;
                                                $imgUrl = $img ? (Str::startsWith($img, 'http') ? $img : secure_asset('storage/' . $img)) : null;
                                            @endphp
                                            @if ($imgUrl)
                                                <img src="{{ $imgUrl }}" class="h-full w-full object-cover rounded-xl max-w-full">
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium text-sm sm:text-base">{{ $item['product']->name }}</p>
                                            <p class="text-xs sm:text-sm text-gray-500">${{ number_format($item['product']->price, 2) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <button type="button" class="quantity-btn" onclick="changeQty(this, -1, '{{ $item['product']->id }}')">-</button>
                                        <input type="number" name="quantities[{{ $item['product']->id }}]" value="{{ $item['quantity'] }}" min="0" class="quantity-input" data-id="{{ $item['product']->id }}" readonly>
                                        <button type="button" class="quantity-btn" onclick="changeQty(this, 1, '{{ $item['product']->id }}')">+</button>
                                    </div>
                                </td>
                                <td class="p-4 text-right font-semibold text-sm sm:text-base line-total" data-id="{{ $item['product']->id }}" data-price="{{ $item['product']->price }}">${{ number_format($item['line_total'], 2) }}</td>
                                <td class="p-4 text-right">
                                    <button type="button" onclick="removeRow(this, '{{ $client->slug }}', '{{ $item['product']->id }}')" class="text-red-500 hover:text-red-700 text-sm" title="Remove item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-xl hover:bg-gray-700 text-sm">Update Basket</button>
                    <p class="text-xl sm:text-2xl font-bold text-right">Total: <span id="grand-total">${{ number_format($total, 2) }}</span></p>
                </div>
            </form>
            <div class="mt-6">
                <form method="POST" action="{{ route('checkout.process', $client->slug) }}" onsubmit="handleCheckout(event)">
                    @csrf
                    <button type="submit" class="btn-dark-green" id="checkout-btn">
                        Proceed to Checkout
                        <span class="spinner"></span>
                    </button>
                </form>
            </div>
        @endif
    </main>

    <script>
        function changeQty(btn, delta, productId) {
            const row = btn.closest('tr');
            const input = row.querySelector('.quantity-input');
            let qty = parseInt(input.value) + delta;
            if (qty < 0) qty = 0;
            input.value = qty;

            // Update line total
            const price = parseFloat(row.querySelector('.line-total').dataset.price);
            const lineTotal = row.querySelector('.line-total');
            lineTotal.textContent = '$' + (price * qty).toFixed(2);

            // Update grand total
            let grand = 0;
            document.querySelectorAll('.line-total').forEach(el => {
                grand += parseFloat(el.textContent.replace('$', ''));
            });
            document.getElementById('grand-total').textContent = '$' + grand.toFixed(2);
        }

        function removeRow(btn, slug, productId) {
            const row = btn.closest('tr');
            row.classList.add('remove-row');
            setTimeout(() => {
                window.location.href = '/' + slug + '/cart/remove/' + productId;
            }, 300);
        }

        function handleCheckout(e) {
            const btn = document.getElementById('checkout-btn');
            btn.classList.add('btn-loading');
            btn.querySelector('.spinner').style.display = 'inline-block';
            // Form will submit normally; loading state prevents double-click
        }
    </script>
</body>
</html>




