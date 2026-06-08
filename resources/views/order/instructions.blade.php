<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->id }} - Payment Instructions</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #efeae2;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d4cdc2' fill-opacity='0.6'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3Ccircle cx='60' cy='60' r='2'/%3E%3Ccircle cx='40' cy='10' r='1.5'/%3E%3Ccircle cx='10' cy='50' r='1.5'/%3E%3Ccircle cx='70' cy='30' r='1.5'/%3E%3Ccircle cx='30' cy='70' r='1'/%3E%3Ccircle cx='50' cy='40' r='1'/%3E%3Ccircle cx='15' cy='35' r='1'/%3E%3Ccircle cx='65' cy='15' r='1'/%3E%3Ccircle cx='45' cy='55' r='1'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 80px 80px;
            color: #333;
            margin: 0;
            min-height: 100vh;
        }
        .card-float {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        .btn-wa {
            background-color: #25D366;
            color: white;
            border-radius: 12px;
            padding: 14px 20px;
            font-weight: 500;
            display: block;
            width: 100%;
            text-align: center;
            transition: all 0.2s ease;
            min-height: 48px;
            animation: pulse-glow 2s infinite;
        }
        .btn-wa:hover { background-color: #128C7E; transform: translateY(-1px); }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.4); }
            70% { box-shadow: 0 0 0 12px rgba(37, 211, 102, 0); }
        }
        .btn-secondary {
            background-color: white;
            border: 1px solid #d1d5db;
            color: #374151;
            border-radius: 12px;
            padding: 12px 16px;
            font-weight: 500;
            display: block;
            width: 100%;
            text-align: center;
            transition: all 0.2s ease;
            min-height: 48px;
        }
        .btn-secondary:hover { background-color: #f9fafb; }
        .copy-btn {
            background: #f3f4f6;
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
            color: #374151;
            font-weight: 500;
        }
        .copy-btn:hover { background: #e5e7eb; }
        .copy-btn.copied { background: #d1fae5; color: #065f46; }
        .step-icon {
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1rem;
            flex-shrink: 0;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        @media (max-width: 640px) {
            .btn-wa, .btn-secondary { padding: 12px 16px; font-size: 0.9rem; }
        }
    </style>
</head>
<body>

    <header class="bg-[#0A8F3C] shadow-card p-4 sticky top-0 z-30">
        <div class="max-w-2xl mx-auto flex items-center justify-between">
            <h1 class="text-lg sm:text-xl font-bold text-white">{{ $order->client->name }} – Order #{{ $order->id }}</h1>
            <span class="status-badge bg-yellow-100 text-yellow-800">Pending Payment</span>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 py-6 sm:py-8">

        {{-- Order Summary --}}
        <div class="card-float p-4 sm:p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
            <div class="space-y-3">
                @foreach ($order->items as $item)
                <div class="flex items-center gap-3 border-b pb-3 last:border-0 last:pb-0">
                    @php
                        $img = $item->product->image_path ?? null;
                        $imgUrl = $img ? (Str::startsWith($img, 'http') ? $img : secure_asset('storage/' . $img)) : null;
                    @endphp
                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex-shrink-0">
                        @if ($imgUrl)
                            <img src="{{ $imgUrl }}" class="h-full w-full object-cover rounded-lg max-w-full">
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-sm">{{ $item->product_name }}</p>
                        <p class="text-xs text-gray-500">{{ $item->quantity }} x ${{ number_format($item->price, 2) }}</p>
                    </div>
                    <p class="font-semibold text-sm">${{ number_format($item->price * $item->quantity, 2) }}</p>
                </div>
                @endforeach
            </div>
            <p class="text-xl font-bold text-right mt-4">Total: ${{ number_format($order->total, 2) }} ({{ $order->currency }})</p>
        </div>

        {{-- Payment Steps --}}
        <div class="card-float p-4 sm:p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">How to complete your order</h2>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="step-icon bg-green-100 text-green-700">1</div>
                    <div>
                        <p class="font-medium text-sm">Send payment via EcoCash</p>
                        <p class="text-xs text-gray-500">Send the exact total to the merchant's number below. Use the order reference so they can identify your payment.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="step-icon bg-green-100 text-green-700">2</div>
                    <div>
                        <p class="font-medium text-sm">Confirm your payment on WhatsApp</p>
                        <p class="text-xs text-gray-500">Tap the green button below to send a pre‑filled confirmation message to the merchant.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="step-icon bg-green-100 text-green-700">3</div>
                    <div>
                        <p class="font-medium text-sm">Collect your order</p>
                        <p class="text-xs text-gray-500">The merchant will confirm your payment. Visit the address below to collect your items.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Merchant Details --}}
        @php $client = $order->client; @endphp
        <div class="card-float p-4 sm:p-6 mb-6">
            <div class="bg-[#0A8F3C] text-white px-4 py-2 rounded-t-xl -mx-4 sm:-mx-6 -mt-4 sm:-mt-6 mb-4">
                <h3 class="font-semibold">Pay using EcoCash</h3>
            </div>

            <div class="space-y-4">
                {{-- EcoCash Number --}}
                <div>
                    <p class="text-sm text-gray-500">EcoCash Number</p>
                    <div class="flex items-center gap-2 mt-1">
                        <p class="text-xl sm:text-2xl font-bold text-gray-800" id="ecocash-number">{{ $client->whatsapp_number }}</p>
                        <button class="copy-btn" onclick="copyText('ecocash-number', this)">Copy</button>
                    </div>
                </div>

                {{-- Order Reference --}}
                <div>
                    <p class="text-sm text-gray-500">Order Reference</p>
                    <div class="flex items-center gap-2 mt-1">
                        <p class="text-base sm:text-lg font-semibold text-gray-800" id="order-reference">Order #{{ $order->id }}</p>
                        <button class="copy-btn" onclick="copyText('order-reference', this)">Copy</button>
                    </div>
                </div>

                {{-- Business Details --}}
                <div>
                    <p class="text-sm text-gray-500">Business</p>
                    <p class="font-semibold text-gray-800">{{ $client->name }}</p>
                </div>
                @if($client->address || $client->city)
                <div>
                    <p class="text-sm text-gray-500">Collection Address</p>
                    <p class="text-gray-700">{{ $client->address }}{{ $client->city ? ', '.$client->city : '' }}</p>
                </div>
                @endif
                @if($client->contact_email)
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-gray-700">{{ $client->contact_email }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="space-y-3 mb-6">
            <a href="https://wa.me/{{ $client->whatsapp_number }}?text=I%20have%20paid%20for%20order:%20%23{{ $order->id }}.%20Here%27s%20the%20confirmation%20details." target="_blank" class="btn-wa">
                Send Payment Confirmation via WhatsApp
            </a>
            <a href="https://wa.me/{{ $client->whatsapp_number }}?text=Hello%2C%20I%20have%20a%20question%20about%20Order%20%23{{ $order->id }}" target="_blank" class="btn-secondary">
                Ask a question about this order
            </a>
        </div>

        {{-- Back to catalog --}}
        <p class="text-center text-sm text-gray-500 pb-8">
            <a href="{{ route('catalog.show', $order->client->slug) }}" class="text-[#0A8F3C] hover:underline">&larr; Back to {{ $order->client->name }}</a>
        </p>

    </main>

    <script>
        function copyText(elementId, btn) {
            const text = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(text).then(() => {
                btn.textContent = 'Copied';
                btn.classList.add('copied');
                setTimeout(() => {
                    btn.textContent = 'Copy';
                    btn.classList.remove('copied');
                }, 2000);
            }).catch(() => {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = text;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                btn.textContent = 'Copied';
                btn.classList.add('copied');
                setTimeout(() => {
                    btn.textContent = 'Copy';
                    btn.classList.remove('copied');
                }, 2000);
            });
        }
    </script>
</body>
</html>






