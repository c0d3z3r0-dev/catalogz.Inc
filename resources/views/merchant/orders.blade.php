<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $client->name }} – Orders</title>
    <link rel="stylesheet" href="/css/tailwind.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f5f7; }
    </style>
</head>
<body>
    <header class="bg-[#0A8F3C] text-white p-4">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <h1 class="text-xl font-bold">{{ $client->name }} – Orders</h1>
            <span class="text-sm text-white/80">{{ $orders->total() }} orders</span>
        </div>
    </header>

    <main class="max-w-4xl mx-auto p-4">
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        @forelse ($orders as $order)
        <div class="bg-white rounded-xl shadow-sm p-4 mb-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold">Order #{{ $order->id }}</p>
                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-sm">Total: ${{ number_format($order->total,2) }} ({{ $order->currency }})</p>
                </div>
                <span class="px-2 py-1 rounded-full text-xs font-medium 
                    @if($order->status=='paid') bg-green-100 text-green-700
                    @elseif($order->status=='fulfilled') bg-blue-100 text-blue-700
                    @elseif($order->status=='failed') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ ucfirst(str_replace('_',' ',$order->status)) }}
                </span>
            </div>
            @if($order->status == 'paid')
            <div class="mt-3">
                <form method="POST" action="{{ route('merchant.fulfill', ['slug' => $client->slug, 'order' => $order->id]) }}?token={{ request('token') }}">
                    @csrf
                    <button class="bg-[#0A8F3C] text-white px-4 py-1 rounded text-sm">Mark as Fulfilled</button>
                </form>
            </div>
            @endif
        </div>
        @empty
        <p class="text-center text-gray-500 py-12">No orders yet.</p>
        @endforelse

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </main>
</body>
</html>



