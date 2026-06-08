@extends('layouts.admin.app')

@section('title', 'Order #'.$order->id)

@section('page-title', 'Order #'.$order->id)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border col-span-2">
        <h3 class="font-semibold mb-4">Items</h3>
        <table class="w-full overflow-x-auto" class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr><th class="p-2 text-left">Product</th><th class="p-2 text-right">Qty</th><th class="p-2 text-right">Price</th><th class="p-2 text-right">Total</th></tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr class="border-t">
                    <td class="p-2">{{ $item->product_name }}</td>
                    <td class="p-2 text-right">{{ $item->quantity }}</td>
                    <td class="p-2 text-right">${{ number_format($item->price,2) }}</td>
                    <td class="p-2 text-right">${{ number_format($item->price * $item->quantity,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p class="text-xl font-bold text-right mt-4">Total: ${{ number_format($order->total,2) }} ({{ $order->currency }})</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border">
        <h3 class="font-semibold mb-4">Order Details</h3>
        <p><span class="text-slate-500">Customer:</span> {{ $order->customer_phone }}</p>
        <p><span class="text-slate-500">Status:</span> 
            <span class="px-2 py-0.5 rounded-full text-xs font-medium status-badge
                @if($order->status=='paid') bg-green-100 text-green-700
                @elseif($order->status=='fulfilled') bg-blue-100 text-blue-700
                @elseif($order->status=='failed') bg-red-100 text-red-700
                @else bg-yellow-100 text-yellow-700 @endif">
                {{ ucfirst(str_replace('_',' ',$order->status)) }}
            </span>
        </p>
        <p><span class="text-slate-500">Date:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>

        <form method="POST" action="{{ route('orders.update-status', $order) }}" class="mt-4">
            @csrf
            <label class="block text-sm font-medium mb-1">Change Status</label>
            <select name="status" class="w-full border rounded-xl px-2 py-1 text-sm mb-2">
                <option value="paid" {{ $order->status=='paid'?'selected':'' }}>Paid</option>
                <option value="fulfilled" {{ $order->status=='fulfilled'?'selected':'' }}>Fulfilled</option>
                <option value="failed" {{ $order->status=='failed'?'selected':'' }}>Failed</option>
                <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
            </select>
            <button class="bg-[#0A8F3C] text-white px-3 py-1 rounded-xl text-sm">Update</button>
        </form>

        <div class="mt-4 border-t pt-4">
            <form method="POST" action="{{ route('orders.destroy', $order) }}" onsubmit="return confirm('Delete this order permanently?')">
                @csrf @method('DELETE')
                <button class="text-red-600 hover:underline text-sm">Delete this order</button>
            </form>
        </div>
    </div>
</div>
@endsection

