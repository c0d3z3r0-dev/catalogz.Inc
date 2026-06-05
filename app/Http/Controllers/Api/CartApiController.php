<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartApiController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'client_slug' => 'required|string|exists:clients,slug',
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'integer|min:1',
            'cart_token' => 'nullable|string',
        ]);

        $client = Client::where('slug', $request->client_slug)->firstOrFail();
        $product = Product::where('client_id', $client->id)->findOrFail($request->product_id);

        $cart = null;
        if ($request->cart_token) {
            $cart = Cart::where('token', $request->cart_token)->first();
        }
        if (!$cart) {
            $cart = Cart::create([
                'token' => Str::random(40),
                'client_id' => $client->id,
            ]);
        }

        $existingItem = $cart->items()->where('product_id', $product->id)->first();
        if ($existingItem) {
            $existingItem->increment('quantity', $request->quantity ?? 1);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        return response()->json([
            'cart_token' => $cart->token,
            'message' => 'Item added',
        ]);
    }

    public function show($token)
    {
        $cart = Cart::where('token', $token)->firstOrFail();
        $items = $cart->items()->with('product')->get()->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'line_total' => $item->product->price * $item->quantity,
                'image_url' => $item->product->image_path ? asset('storage/' . $item->product->image_path) : null,
            ];
        });

        $total = $items->sum('line_total');

        return response()->json([
            'cart_token' => $cart->token,
            'items' => $items,
            'total' => $total,
        ]);
    }
}
