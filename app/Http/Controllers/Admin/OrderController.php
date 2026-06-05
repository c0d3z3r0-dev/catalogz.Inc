<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('client')->latest();

        if ($request->filled('status')) {
            $orders->where('status', $request->status);
        }
        if ($request->filled('client_id')) {
            $orders->where('client_id', $request->client_id);
        }

        $orders = $orders->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'client');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:paid,failed,pending,fulfilled']);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted.');
    }
}
