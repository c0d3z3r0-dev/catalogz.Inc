<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Client $client)
    {
        $products = $client->products()->orderBy('sort_order')->get();
        return view('admin.products.index', compact('client', 'products'));
    }

    public function create(Client $client)
    {
        return view('admin.products.create', compact('client'));
    }

    public function store(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $client->products()->create($validated);
        Cache::forget("catalog.html.{$client->slug}");

        return redirect()->route('clients.products.index', $client)
            ->with('success', 'Product added.');
    }

    public function bulkStore(Request $request, Client $client)
    {
        $request->validate(['bulk_data' => 'required|string']);
        $lines = explode("\n", trim($request->bulk_data));
        $added = 0;

        foreach ($lines as $line) {
            $parts = explode("\t", trim($line));
            if (count($parts) >= 2) {
                $name = trim($parts[0]);
                $price = floatval(trim($parts[1]));
                $description = $parts[2] ?? '';
                if ($name && $price >= 0) {
                    $client->products()->create([
                        'name' => $name,
                        'price' => $price,
                        'description' => $description,
                        'is_available' => true,
                        'sort_order' => 0,
                    ]);
                    $added++;
                }
            }
        }

        Cache::forget("catalog.html.{$client->slug}");
        return redirect()->route('clients.products.index', $client)
            ->with('success', "{$added} products added.");
    }

    public function edit(Client $client, Product $product)
    {
        return view('admin.products.edit', compact('client', 'product'));
    }

    public function update(Request $request, Client $client, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path && !str_starts_with($product->image_path, 'http')) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);
        Cache::forget("catalog.html.{$client->slug}");

        return redirect()->route('clients.products.index', $client)
            ->with('success', 'Product updated.');
    }

    public function destroy(Client $client, Product $product)
    {
        $product->orderItems()->delete();
        if ($product->image_path && !str_starts_with($product->image_path, 'http')) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        Cache::forget("catalog.html.{$client->slug}");

        return redirect()->route('clients.products.index', $client)
            ->with('success', 'Product permanently deleted.');
    }
}
