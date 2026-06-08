<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - {{ $client->name }} - Catalog.Inc</title>
    <link rel="stylesheet" href="/css/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <span class="font-bold text-xl text-gray-800">{{ $product->name }}</span>
        <div class="flex gap-4">
            <a href="{{ route('clients.products.index', $client) }}" class="text-blue-600 hover:underline">← Products</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-500 hover:underline">Logout</button>
            </form>
        </div>
    </nav>
    <div class="p-8 max-w-lg mx-auto">
        <div class="bg-white shadow rounded p-6">
            <p class="text-2xl font-bold mb-4">${{ number_format($product->price, 2) }}</p>
            <p class="mb-4">{{ $product->description }}</p>
            <p class="text-sm text-gray-500">Available: {{ $product->is_available ? 'Yes' : 'No' }}</p>
            <p class="text-sm text-gray-500">Sort Order: {{ $product->sort_order }}</p>
        </div>
    </div>
</body>
</html>



