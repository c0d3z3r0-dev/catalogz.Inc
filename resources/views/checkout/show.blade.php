<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $client->name }} - Catalog.Inc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #efeae2; background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d4cdc2' fill-opacity='0.6'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3Ccircle cx='60' cy='60' r='2'/%3E%3Ccircle cx='40' cy='10' r='1.5'/%3E%3Ccircle cx='10' cy='50' r='1.5'/%3E%3Ccircle cx='70' cy='30' r='1.5'/%3E%3Ccircle cx='30' cy='70' r='1'/%3E%3Ccircle cx='50' cy='40' r='1'/%3E%3Ccircle cx='15' cy='35' r='1'/%3E%3Ccircle cx='65' cy='15' r='1'/%3E%3Ccircle cx='45' cy='55' r='1'/%3E%3C/g%3E%3C/svg%3E"); background-size: 80px 80px; color: #333; }
        .card-float { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .btn-dark-green { background-color: #0A8F3C; color: white; border-radius: 12px; padding: 16px 24px; font-weight: 600; transition: all 0.2s ease; width: 100%; border: none; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; }
        .btn-dark-green:hover { background-color: #047A2D; transform: translateY(-1px); }
        .top-bar { background-color: #0A8F3C !important; }
        .btn-loading { pointer-events: none; opacity: 0.7; }
        .spinner { display: none; width: 20px; height: 20px; border: 2px solid white; border-top-color: transparent; border-radius: 50%; animation: spin 0.8s linear infinite; margin-left: 8px; }
        .btn-loading .spinner { display: inline-block; }
        @keyframes spin { to { transform: rotate(360deg); } }
        input[type="tel"] { letter-spacing: 0.05em; }
    </style>
</head>
<body>
    <header class="top-bar shadow-sm p-4">
        <div class="max-w-2xl mx-auto flex items-center gap-3">
            <a href="{{ route('catalog.cart', $client->slug) }}" class="text-white/80 hover:text-white">&larr; Back to Basket</a>
            <h1 class="text-xl font-bold text-white">{{ $client->name }} – Checkout</h1>
        </div>
    </header>
    <main class="max-w-2xl mx-auto px-4 py-8">
        <div class="card-float p-6 mb-6">
            <h2 class="font-semibold text-lg mb-4">Order Summary</h2>
            <table class="w-full overflow-x-auto" class="w-full text-sm">
                @foreach ($items as $item)
                <tr class="border-b last:border-0">
                    <td class="py-3 flex items-center gap-3">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex-shrink-0">
                            @php
                                $img = $item['product']->image_path;
                                $imgUrl = $img ? (Str::startsWith($img, 'http') ? $img : secure_asset('storage/' . $img)) : null;
                            @endphp
                            @if ($imgUrl)
                                <img src="{{ $imgUrl }}" class="h-full w-full object-cover rounded-lg max-w-full">
                            @endif
                        </div>
                        <div>
                            <p class="font-medium">{{ $item['product']->name }}</p>
                            <p class="text-xs text-gray-500">{{ $item['quantity'] }} x ${{ number_format($item['product']->price, 2) }}</p>
                        </div>
                    </td>
                    <td class="py-3 text-right font-semibold">${{ number_format($item['line_total'], 2) }}</td>
                </tr>
                @endforeach
            </table>
            <div class="border-t mt-4 pt-4">
                <div class="flex justify-between text-sm text-gray-500 mb-1">
                    <span>Subtotal</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-500 mb-3">
                    <span>Delivery</span>
                    <span>Collection only</span>
                </div>
                <div class="flex justify-between text-lg font-bold">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('checkout.process', $client->slug) }}" onsubmit="handleSubmit(event)" class="card-float p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">EcoCash Phone Number</label>
                <input type="tel" name="customer_phone" required placeholder="077 123 4567"
                       class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 text-lg"
                       oninput="formatPhone(this)">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                <div class="flex gap-2">
                    <label class="flex-1">
                        <input type="radio" name="currency" value="USD" checked class="hidden peer">
                        <span class="block text-center py-2 border rounded-xl cursor-pointer peer-checked:bg-green-50 peer-checked:border-green-600 peer-checked:text-green-700">USD</span>
                    </label>
                    <label class="flex-1">
                        <input type="radio" name="currency" value="ZWL" class="hidden peer">
                        <span class="block text-center py-2 border rounded-xl cursor-pointer peer-checked:bg-green-50 peer-checked:border-green-600 peer-checked:text-green-700">ZWL</span>
                    </label>
                </div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <div>
                    <p class="text-sm font-medium text-green-800">Secure payment via EcoCash</p>
                    <p class="text-xs text-green-600 mt-1">You'll receive a USSD prompt on your phone. We never see your PIN.</p>
                </div>
            </div>
            <button type="submit" class="btn-dark-green" id="pay-btn">
                Pay with EcoCash
                <span class="spinner"></span>
            </button>
        </form>
    </main>

    <script>
        function handleSubmit(e) {
            const btn = document.getElementById('pay-btn');
            btn.classList.add('btn-loading');
            btn.querySelector('.spinner').style.display = 'inline-block';
        }

        function formatPhone(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 3 && value.length <= 6) {
                value = value.slice(0, 3) + ' ' + value.slice(3);
            } else if (value.length > 6) {
                value = value.slice(0, 3) + ' ' + value.slice(3, 6) + ' ' + value.slice(6, 10);
            }
            input.value = value;
        }
    </script>
</body>
</html>


