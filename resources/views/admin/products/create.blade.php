@extends('layouts.admin.app')

@section('title', 'Add Product – ' . $client->name)

@section('page-title', 'Add Product to ' . $client->name)

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-card border border-slate-200">
    <form method="POST" action="{{ route('clients.products.store', $client) }}" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[var(--green-primary)] focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[var(--green-primary)] focus:border-transparent">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Price (USD)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[var(--green-primary)] focus:border-transparent @error('price') border-red-500 @enderror">
                @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Product Image</label>
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_available" value="1" checked class="rounded border-slate-300 text-[var(--green-primary)] focus:ring-[var(--green-primary)]">
                    <span class="ml-2 text-sm text-slate-700">Available</span>
                </label>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[var(--green-primary)] focus:border-transparent">
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="{{ route('clients.products.index', $client) }}" class="px-4 py-2 border border-slate-300 rounded-xl text-slate-700 hover:bg-slate-50 text-sm">Cancel</a>
            <button type="submit" class="px-5 py-2 bg-[var(--green-primary)] text-white rounded-xl hover:bg-[var(--green-hover)] transition text-sm font-medium">
                Add Product
            </button>
        </div>
    </form>
</div>
@endsection

