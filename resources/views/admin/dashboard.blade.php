@extends('layouts.admin.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
    <div class="card-float p-5 aspect-square flex flex-col justify-center">
        <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Total Clients</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalClients }}</p>
    </div>
    <div class="card-float p-5 aspect-square flex flex-col justify-center">
        <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Total Products</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalProducts }}</p>
    </div>
    <div class="card-float p-5 aspect-square flex flex-col justify-center">
        <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Total Orders</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalOrders }}</p>
    </div>
    <div class="card-float p-5 aspect-square flex flex-col justify-center">
        <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">This Week</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $ordersThisWeek ?? 0 }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="card-float p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Quick Actions</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('clients.create') }}" class="btn-dark-green">+ New Client</a>
            <a href="{{ route('clients.index') }}" class="btn-orange">View All Clients</a>
        </div>
    </div>
    <div class="card-float p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">System Health</h3>
        @php
            $diskSize = 0;
            $uploadPath = storage_path('app/public');
            if (is_dir($uploadPath)) {
                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($uploadPath));
                foreach ($iterator as $file) { if ($file->isFile()) $diskSize += $file->getSize(); }
            }
            $dbSize = filesize(database_path('database.sqlite'));
            function fmtBytes($b) { return $b>=1048576 ? number_format($b/1048576,2).' MB' : ($b>=1024 ? number_format($b/1024,2).' KB' : $b.' B'); }
        @endphp
        <div class="space-y-2 text-sm">
            <p><span class="text-slate-500">Uploaded files:</span> {{ fmtBytes($diskSize) }}</p>
            <p><span class="text-slate-500">Database size:</span> {{ fmtBytes($dbSize) }}</p>
            <p><span class="text-slate-500">PHP:</span> {{ phpversion() }}</p>
            <p><span class="text-slate-500">Laravel:</span> {{ app()->version() }}</p>
        </div>
    </div>
</div>

{{-- Recent Orders --}}
<div class="card-float p-6">
    <h3 class="text-lg font-semibold text-slate-800 mb-4">Recent Orders</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="p-2 text-left">Order #</th>
                    <th class="p-2 text-left">Client</th>
                    <th class="p-2 text-left">Phone</th>
                    <th class="p-2 text-right">Total</th>
                    <th class="p-2 text-left">Status</th>
                    <th class="p-2 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse(\App\Models\Order::with('client')->latest()->take(5)->get() as $order)
                <tr class="hover:bg-slate-50">
                    <td class="p-2">#{{ $order->id }}</td>
                    <td class="p-2">{{ $order->client->name }}</td>
                    <td class="p-2">{{ $order->customer_phone }}</td>
                    <td class="p-2 text-right">${{ number_format($order->total, 2) }}</td>
                    <td class="p-2">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                            @if($order->status=='paid') bg-green-100 text-green-700
                            @elseif($order->status=='fulfilled') bg-blue-100 text-blue-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ ucfirst(str_replace('_',' ',$order->status)) }}
                        </span>
                    </td>
                    <td class="p-2 text-right"><a href="{{ route('orders.show', $order) }}" class="text-blue-600 text-xs hover:underline">View</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-4 text-center text-gray-400">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
