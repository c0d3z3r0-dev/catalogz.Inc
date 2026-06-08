@extends('layouts.admin.app')

@section('title', 'Submission Detail')

@section('page-title', $submission->business_name)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="card-float p-6">
        <h3 class="font-semibold text-lg mb-4">Business Info</h3>
        <p><span class="text-gray-500">Name:</span> {{ $submission->business_name }}</p>
        <p><span class="text-gray-500">WhatsApp:</span> {{ $submission->whatsapp_number }}</p>
        @if($submission->email)<p><span class="text-gray-500">Email:</span> {{ $submission->email }}</p>@endif
        @if($submission->city)<p><span class="text-gray-500">City:</span> {{ $submission->city }}</p>@endif
        @if($submission->address)<p><span class="text-gray-500">Address:</span> {{ $submission->address }}</p>@endif
    </div>
    <div class="card-float p-6">
        <h3 class="font-semibold text-lg mb-4">Products</h3>
        @forelse ($submission->products as $product)
            <div class="flex items-start gap-4 mb-4 border-b pb-3">
                <div class="w-16 h-16 bg-gray-200 rounded flex-shrink-0">
                    @if ($product->image_path)
                        <img alt="" ->image_path) }}" class="h-full w-full object-cover rounded">
                    @endif
                </div>
                <div>
                    <p class="font-medium">{{ $product->product_name ?: 'No name' }}</p>
                    <p class="text-sm text-gray-500">{{ $product->product_price ? '$'.$product->product_price : 'No price' }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-400">No products listed.</p>
        @endforelse
    </div>
</div>
<div class="mt-6">
    <a href="{{ route('clients.create', ['name' => $submission->business_name, 'whatsapp' => $submission->whatsapp_number, 'email' => $submission->email, 'address' => $submission->address, 'city' => $submission->city]) }}" class="btn-dark-green px-4 py-2">Create Catalog from this Submission</a>
</div>
@endsection

