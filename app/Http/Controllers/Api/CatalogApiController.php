<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;

class CatalogApiController extends Controller
{
    public function clientInfo($slug)
    {
        $client = Client::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $products = $client->products()->where('is_available', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'image_url' => $product->image_path ? asset('storage/' . $product->image_path) : null,
                ];
            });

        return response()->json([
            'client' => [
                'name' => $client->name,
                'address' => $client->address,
                'city' => $client->city,
                'whatsapp' => $client->whatsapp_number,
                'contact_email' => $client->contact_email,
                'styling' => [
                    'background_color' => $client->background_color,
                    'font_family' => $client->font_family,
                    'custom_css' => $client->custom_css,
                ],
            ],
            'products' => $products,
        ]);
    }
}
