<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CatalogController extends Controller
{
    public function show($slug)
    {
        $client = Client::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $products = $client->products()->where('is_available', true)
            ->orderBy('sort_order')
            ->get();

        return view('catalog.show', [
            'client' => $client,
            'products' => $products,
        ]);
    }

    public function saved($slug)
    {
        $client = Client::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('catalog.saved', compact('client'));
    }

    public function cart($slug)
    {
        $client = Client::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $cart = session()->get("cart.{$client->id}", []);
        $items = [];
        $total = 0;
        if ($cart) {
            $products = $client->products()->whereIn('id', array_keys($cart))->get()->keyBy('id');
            foreach ($cart as $productId => $qty) {
                if (isset($products[$productId])) {
                    $product = $products[$productId];
                    $lineTotal = $product->price * $qty;
                    $items[] = [
                        'product' => $product,
                        'quantity' => $qty,
                        'line_total' => $lineTotal,
                    ];
                    $total += $lineTotal;
                }
            }
        }
        return view('catalog.cart', compact('client', 'items', 'total'));
    }

    public function cartCount($slug)
    {
        $client = Client::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $cart = session()->get("cart.{$client->id}", []);
        $count = array_sum($cart);
        return response()->json(['count' => $count]);
    }

    public function addToCart(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);
        $product = $client->products()->findOrFail($productId);
        $cart = session()->get("cart.{$client->id}", []);
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        session()->put("cart.{$client->id}", $cart);
        return redirect()->route('catalog.cart', $slug)->with('success', 'Added to basket.');
    }

    public function updateCart(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $quantities = $request->input('quantities', []);
        $cart = session()->get("cart.{$client->id}", []);
        foreach ($quantities as $productId => $qty) {
            $qty = (int) $qty;
            if ($qty > 0) {
                $cart[$productId] = $qty;
            } else {
                unset($cart[$productId]);
            }
        }
        session()->put("cart.{$client->id}", $cart);
        return redirect()->route('catalog.cart', $slug)->with('success', 'Basket updated.');
    }

    public function removeFromCart($slug, $productId)
    {
        $client = Client::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $cart = session()->get("cart.{$client->id}", []);
        unset($cart[$productId]);
        session()->put("cart.{$client->id}", $cart);
        return redirect()->route('catalog.cart', $slug)->with('success', 'Item removed.');
    }

    public function addToCartAjax(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);
        $product = $client->products()->findOrFail($productId);
        $cart = session()->get("cart.{$client->id}", []);
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        session()->put("cart.{$client->id}", $cart);
        $count = array_sum($cart);
        return response()->json(['success' => true, 'cart_count' => $count, 'message' => 'Added to basket']);
    }
}
