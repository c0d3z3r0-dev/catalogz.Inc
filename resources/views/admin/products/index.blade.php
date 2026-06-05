@extends('layouts.admin.app')

@section('title', 'Products – ' . $client->name)

@section('page-title', $client->name . ' – Products')

@section('content')
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('clients.show', $client) }}" class="text-sm text-blue-600 hover:underline">&larr; Back to client</a>
    <a href="{{ route('clients.products.create', $client) }}" class="inline-flex items-center px-4 py-2 bg-[#0A8F3C] text-white rounded-xl hover:bg-green-700 transition text-sm font-medium">
        + Add Product
    </a>
</div>

@if (session('success'))
    <div class="bg-green-50 border-l-4 border-[#0A8F3C] text-green-700 p-4 mb-6 rounded-r">
        {{ session('success') }}
    </div>
@endif

{{-- Bulk Upload --}}
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h3 class="font-semibold text-lg mb-2">Bulk Add Products</h3>
    <p class="text-sm text-gray-500 mb-3">Paste tab‑delimited data: <strong>Name</strong> &rarr; <strong>Price</strong> &rarr; <strong>Description</strong> (one per line).</p>
    <form method="POST" action="{{ route('clients.products.bulk', $client) }}" class="space-y-3">
        @csrf
        <textarea name="bulk_data" rows="5" class="w-full border rounded-xl px-4 py-2 text-sm font-mono" placeholder="T-shirt&#9;25&#9;Cotton crew neck"></textarea>
        <button type="submit" class="bg-[#0A8F3C] text-white px-4 py-2 rounded text-sm">Add Products</button>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($products as $product)
    @php
        $imgUrl = null;
        if ($product->image_path) {
            $imgUrl = Str::startsWith($product->image_path, 'http') ? $product->image_path : secure_asset('storage/' . $product->image_path);
        }
    @endphp
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">
        <div class="image-container">
            @if ($imgUrl)
                <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="product-image">
            @else
                <div class="absolute inset-0 flex items-center justify-center text-slate-400 text-sm">No image</div>
            @endif
            <div class="absolute top-0 left-0 w-full h-1 {{ $product->is_available ? 'bg-[#0A8F3C]' : 'bg-slate-400' }}"></div>
        </div>
        <div class="p-4">
            <h4 class="font-semibold text-slate-800 text-sm sm:text-base">{{ $product->name }}</h4>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 mb-2 line-clamp-2">{{ Str::limit($product->description, 50) }}</p>
            <div class="flex items-center justify-between">
                <span class="text-base sm:text-lg font-bold text-slate-900">${{ number_format($product->price, 2) }}</span>
                @if ($product->is_available)
                    <span class="px-2.5 py-0.5 bg-green-50 text-green-700 text-xs rounded-full border border-green-200">In stock</span>
                @else
                    <span class="px-2.5 py-0.5 bg-red-50 text-red-700 text-xs rounded-full border border-red-200">Out of stock</span>
                @endif
            </div>
            <div class="mt-4 flex justify-end space-x-3 border-t pt-3">
                <a href="{{ route('clients.products.edit', [$client, $product]) }}" class="text-amber-600 hover:text-amber-800 text-sm">Edit</a>
                <form method="POST" action="{{ route('clients.products.destroy', [$client, $product]) }}" onsubmit="return confirm('Delete this product?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12 text-slate-400">No products yet.</div>
    @endforelse
</div>
@endsection
