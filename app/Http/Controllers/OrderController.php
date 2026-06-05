<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function instructions($slug, Order $order)
    {
        if ($order->client->slug !== $slug) abort(404);
        return view('order.instructions', compact('order', 'slug'));
    }

    public function confirmation($slug, Order $order)
    {
        if ($order->client->slug !== $slug) abort(404);
        return view('order.confirmation', compact('order', 'slug'));
    }

    public function status($slug, Order $order)
    {
        if ($order->client->slug !== $slug) abort(404);
        return response()->json(['status' => $order->status]);
    }
}
