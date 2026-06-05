@extends('layouts.admin.app')

@section('title', $client->name)

@section('page-title', $client->name)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1 bg-white rounded-xl shadow p-6">
        <div class="flex flex-col items-center text-center">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                @if ($client->logo_path)
                    <img src="{{ Str::startsWith($client->logo_path, 'http') ? $client->logo_path : secure_asset('storage/' . $client->logo_path) }}" alt="{{ $client->name }}" class="h-full w-full object-cover rounded-full">
                @else
                    <span class="text-4xl text-gray-400">{{ substr($client->name, 0, 1) }}</span>
                @endif
            </div>
            <h2 class="text-xl font-bold">{{ $client->name }}</h2>
            <p class="text-gray-500">WhatsApp: {{ $client->whatsapp_number }}</p>
            <p class="text-gray-500">Email: {{ $client->email ?? 'N/A' }}</p>
            <p class="text-sm mt-2">
                <a href="{{ route('catalog.show', $client->slug) }}" target="_blank" class="text-[#0A8F3C] hover:underline">View Public Catalog</a>
            </p>
            <div class="mt-4">
                <a href="{{ route('clients.edit', $client) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
            </div>
        </div>
    </div>
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Products ({{ $client->products->count() }})</h3>
                <a href="{{ route('clients.products.create', $client) }}" class="bg-[#0A8F3C] text-white px-4 py-2 rounded text-sm hover:bg-green-700">+ Add Product</a>
            </div>
            @if ($client->products->isEmpty())
                <p class="text-gray-400">No products yet.</p>
            @else
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($client->products as $product)
                    @php
                        $imgUrl = $product->image_path && Str::startsWith($product->image_path, 'http')
                            ? $product->image_path
                            : ($product->image_path ? secure_asset('storage/' . $product->image_path) : null);
                    @endphp
                    <div class="border rounded p-3 flex items-start space-x-3">
                        <div class="w-16 h-16 bg-gray-200 rounded flex-shrink-0 flex items-center justify-center text-gray-400 text-xs">
                            @if ($imgUrl)
                                <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded">
                            @else
                                No img
                            @endif
                        </div>
                        <div>
                            <p class="font-medium">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">${{ number_format($product->price, 2) }}</p>
                            <a href="{{ route('clients.products.edit', [$client, $product]) }}" class="text-xs text-yellow-600 hover:underline">Edit</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('clients.products.index', $client) }}" class="text-sm text-blue-600 hover:underline">Manage all products</a>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-3">Merchant Dashboard</h3>
            @if ($client->merchant_token)
                <p class="text-sm text-gray-600 mb-3">Share this link with the merchant so they can view orders and mark them as fulfilled.</p>
                <div class="flex items-center gap-2">
                    @php
                        $merchantUrl = route('merchant.orders', ['slug' => $client->slug]) . '?token=' . $client->merchant_token;
                    @endphp
                    <input type="text" value="{{ $merchantUrl }}" id="merchant-link" readonly
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-xl bg-gray-50 text-sm text-gray-700">
                    <button onclick="copyMerchantLink()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-xl text-sm font-medium">
                        Copy
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-2">Copied link to clipboard: <span id="copy-status" class="text-green-600 hidden">Done</span></p>
            @else
                <p class="text-sm text-gray-500">No merchant token generated yet. Update the client to generate one automatically.</p>
            @endif
        </div>
    </div>
</div>

<script>
    function copyMerchantLink() {
        const input = document.getElementById('merchant-link');
        input.select();
        input.setSelectionRange(0, 99999);
        document.execCommand('copy');
        document.getElementById('copy-status').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('copy-status').classList.add('hidden');
        }, 2000);
    }
</script>
@endsection
