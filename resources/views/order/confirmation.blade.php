<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->id }} - Catalog.Inc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .spinner { border: 4px solid rgba(0,0,0,.1); border-left-color: #0A8F3C; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-slate-50">
    <header class="bg-white shadow-sm p-4">
        <h1 class="text-xl font-bold text-slate-800">Order #{{ $order->id }}</h1>
    </header>
    <main class="p-6 max-w-2xl mx-auto">
        <div id="loading" class="text-center py-10">
            <div class="spinner mx-auto mb-4"></div>
            <p class="text-slate-600">Waiting for payment confirmation...</p>
            <p class="text-xs text-slate-400">You will receive an EcoCash prompt on your phone. Please confirm the payment.</p>
        </div>

        <div id="paid-content" class="hidden">
            <div class="bg-green-50 border border-green-200 p-4 rounded-xl mb-6">
                <h2 class="text-lg font-semibold text-green-800">Payment Successful!</h2>
                <p class="text-green-700">Your order has been placed successfully.</p>
            </div>
            <!-- Order summary & collection details (same as before) -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="font-semibold mb-4">Order Summary</h3>
                <table class="w-full overflow-x-auto" class="w-full text-sm">
                    <thead class="bg-slate-50"><tr><th class="p-2 text-left">Item</th><th class="p-2 text-right">Qty</th><th class="p-2 text-right">Price</th><th class="p-2 text-right">Total</th></tr></thead>
                    <tbody>
                        @foreach ($order->items as $item)
                        <tr class="border-t"><td class="p-2">{{ $item->product_name }}</td><td class="p-2 text-right">{{ $item->quantity }}</td><td class="p-2 text-right">${{ number_format($item->price, 2) }}</td><td class="p-2 text-right">${{ number_format($item->price * $item->quantity, 2) }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="text-xl font-bold text-right mt-2">Total: ${{ number_format($order->total, 2) }} ({{ $order->currency }})</p>
            </div>
            @php $client = $order->client; @endphp
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="font-semibold mb-4">Collection Details</h3>
                <div class="space-y-2 text-slate-700">
                    <p><span class="font-medium">Business:</span> {{ $client->name }}</p>
                    @if ($client->address)<p><span class="font-medium">Address:</span> {{ $client->address }}</p>@endif
                    @if ($client->city)<p><span class="font-medium">City:</span> {{ $client->city }}</p>@endif
                    @if ($client->whatsapp_number)<p><span class="font-medium">Phone:</span> {{ $client->whatsapp_number }}</p>@endif
                    @if ($client->contact_email)<p><span class="font-medium">Email:</span> {{ $client->contact_email }}</p>@endif
                </div>
                @if ($client->whatsapp_number)
                <div class="mt-4">
                    <a href="https://wa.me/{{ $client->whatsapp_number }}?text=Regarding%20order%20%23{{ $order->id }}" target="_blank"
                       class="inline-block bg-green-600 text-white px-5 py-2 rounded-xl hover:bg-green-700 transition text-sm">Contact via WhatsApp</a>
                </div>
                @endif
            </div>
        </div>

        <div id="failed-content" class="hidden text-center py-10">
            <p class="text-red-600 mb-4">Payment failed or was cancelled.</p>
            <a href="{{ route('catalog.show', $slug) }}" class="text-blue-600 underline">Return to store</a>
        </div>
    </main>

    <script>
        function pollStatus() {
            fetch('{{ route("order.status", [$slug, $order->id]) }}')
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'paid') {
                        document.getElementById('loading').classList.add('hidden');
                        document.getElementById('paid-content').classList.remove('hidden');
                        clearInterval(pollInterval);
                    } else if (data.status === 'failed') {
                        document.getElementById('loading').classList.add('hidden');
                        document.getElementById('failed-content').classList.remove('hidden');
                        clearInterval(pollInterval);
                    }
                });
        }
        let pollInterval = setInterval(pollStatus, 5000);
        document.addEventListener('DOMContentLoaded', () => pollStatus());
    </script>
</body>
</html>



