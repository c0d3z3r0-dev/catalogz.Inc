<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class MerchantDashboardController extends Controller
{
    public function orders(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->firstOrFail();
        $token = $request->input('token');

        if (!$token || $token !== $client->merchant_token) {
            abort(403, 'Unauthorized');
        }

        $orders = $client->orders()->latest()->paginate(20);
        return view('merchant.orders', compact('client', 'orders'));
    }

    public function fulfill(Request $request, $slug, Order $order)
    {
        $client = Client::where('slug', $slug)->firstOrFail();
        $token = $request->input('token');

        if (!$token || $token !== $client->merchant_token) {
            abort(403);
        }

        if ($order->client_id !== $client->id) {
            abort(404);
        }

        $order->update(['status' => 'fulfilled']);
        return back()->with('success', 'Order marked as fulfilled.');
    }
}
