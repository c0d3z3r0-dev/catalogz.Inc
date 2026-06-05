<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutApiController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'cart_token' => 'required|string|exists:carts,token',
            'customer_phone' => 'required|string|max:20',
            'currency' => 'required|in:USD,ZWL',
        ]);

        $cart = Cart::where('token', $request->cart_token)->firstOrFail();
        $client = $cart->client;

        if ($cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $total = $cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $order = Order::create([
            'client_id' => $client->id,
            'customer_phone' => $request->customer_phone,
            'status' => 'pending',
            'total' => $total,
            'currency' => $request->currency,
        ]);

        foreach ($cart->items as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'price' => $cartItem->product->price,
                'quantity' => $cartItem->quantity,
            ]);
        }

        $cart->delete();

        return response()->json([
            'order_id' => $order->id,
            'message' => 'Order created. Payment pending.',
            'confirmation_url' => url("/{$client->slug}/order/{$order->id}/confirmation"),
        ]);
    }
}
