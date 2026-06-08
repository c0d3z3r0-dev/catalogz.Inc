@extends('layouts.admin.app')

@section('title', 'Orders')

@section('page-title', 'Orders')

@section('content')
<div class="mb-4 flex gap-4">
    <form method="GET" class="flex gap-2">
        <select name="status" class="border rounded-xl px-2 py-1 text-sm">
            <option value="">All Status</option>
            <option value="paid" {{ request('status')=='paid'?'selected':'' }}>Paid</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="awaiting_payment" {{ request('status')=='awaiting_payment'?'selected':'' }}>Awaiting Payment</option>
            <option value="fulfilled" {{ request('status')=='fulfilled'?'selected':'' }}>Fulfilled</option>
            <option value="failed" {{ request('status')=='failed'?'selected':'' }}>Failed</option>
        </select>
        <button class="bg-[#0A8F3C] text-white px-3 py-1 rounded-xl text-sm">Filter</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <table class="w-full overflow-x-auto" class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="p-3 text-left">Order #</th>
                <th class="p-3 text-left">Client</th>
                <th class="p-3 text-left">Phone</th>
                <th class="p-3 text-left">Total</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($orders as $order)
            <tr class="hover:bg-slate-50">
                <td class="p-3">{{ $order->id }}</td>
                <td class="p-3">{{ $order->client->name }}</td>
                <td class="p-3">{{ $order->customer_phone }}</td>
                <td class="p-3">${{ number_format($order->total,2) }} ({{ $order->currency }})</td>
                <td class="p-3">
                    <span class="px-2 py-1 rounded-full text-xs font-medium 
                        @if($order->status=='paid') bg-green-100 text-green-700
                        @elseif($order->status=='fulfilled') bg-blue-100 text-blue-700
                        @elseif($order->status=='failed') bg-red-100 text-red-700
                        @else bg-yellow-100 text-yellow-700 @endif">
                        {{ ucfirst(str_replace('_',' ',$order->status)) }}
                    </span>
                </td>
                <td class="p-3 text-right space-x-2">
                    <a href="{{ route('orders.show', $order) }}" title="View order" class="text-blue-600 hover:underline text-sm">View</a>
                    <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Delete this order permanently?')" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <!-- Skeleton placeholders -->
            @for ($i = 0; $i < 5; $i++)
            <tr>
                <td class="p-3"><div class="skeleton h-4 w-12 bg-gray-200 rounded"></div></td>
                <td class="p-3"><div class="skeleton h-4 w-24 bg-gray-200 rounded"></div></td>
                <td class="p-3"><div class="skeleton h-4 w-20 bg-gray-200 rounded"></div></td>
                <td class="p-3"><div class="skeleton h-4 w-16 bg-gray-200 rounded"></div></td>
                <td class="p-3"><div class="skeleton h-4 w-16 bg-gray-200 rounded"></div></td>
                <td class="p-3"><div class="skeleton h-4 w-10 bg-gray-200 rounded"></div></td>
            </tr>
            @endfor
            @endforelse
        </tbody>
    </table>
    <div class="p-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection

