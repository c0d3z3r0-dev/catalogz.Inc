<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Product;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if demo already exists
        if (Client::where('slug', 'lusso-boutique')->exists()) return;

        $client = Client::create([
            'name' => 'Lusso Boutique',
            'slug' => 'lusso-boutique',
            'whatsapp_number' => '0771234567',
            'email' => 'hello@lusso.co.zw',
            'address' => '12 Samora Machel Ave',
            'city' => 'Harare',
            'background_color' => '#FFFFFF',
            'font_family' => 'Inter',
            'is_active' => true,
        ]);
        $client->generateMerchantToken();

        $products = [
            ['Silk Blouse', 'Soft silk blouse with a relaxed fit.', 55.00, 'https://images.unsplash.com/photo-1551232864-3f0890c687d4?w=400&h=400&fit=crop'],
            ['Wide-Leg Trousers', 'High-waisted wide-leg trousers in crepe.', 75.00, 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400&h=400&fit=crop'],
            ['Cashmere Cardigan', 'Lightweight cashmere cardigan, open front.', 130.00, 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?w=400&h=400&fit=crop'],
            ['Linen Shift Dress', 'Breathable linen, perfect for warm days.', 60.00, 'https://images.unsplash.com/photo-1560243563-062bfc001d68?w=400&h=400&fit=crop'],
            ['Tailored Shorts', 'Cotton tailored shorts with belt loops.', 45.00, 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400&h=400&fit=crop'],
            ['Pleated Midi Skirt', 'Midi length, pleated, with an elastic waist.', 50.00, 'https://images.unsplash.com/photo-1485968579580-b6d095142e6e?w=400&h=400&fit=crop'],
            ['Structured Blazer', 'Single button blazer, fully lined.', 140.00, 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=400&h=400&fit=crop'],
            ['Ribbed Knit Top', 'Fitted ribbed knit with a crew neck.', 35.00, 'https://images.unsplash.com/photo-1475180098004-ca77a9146669?w=400&h=400&fit=crop'],
        ];

        foreach ($products as $p) {
            $client->products()->create([
                'name' => $p[0], 'description' => $p[1], 'price' => $p[2],
                'image_path' => $p[3], 'is_available' => true, 'sort_order' => 0,
            ]);
        }
    }
}
