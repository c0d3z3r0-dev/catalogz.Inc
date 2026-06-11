<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Product;

class LussoBoutiqueSeeder extends Seeder
{
    public function run(): void
    {
        $client = Client::where('slug', 'lusso-boutique')->first();
        if (!$client) {
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
        }

        // Remove existing products to start fresh
        $client->products()->delete();

        $products = [
            ["Silk Blouse", "Soft silk blouse with a relaxed fit.", 55.00, "https://images.unsplash.com/photo-1551232864-3f0890c687d4?w=400&h=400&fit=crop"],
            ["Wide-Leg Trousers", "High-waisted wide-leg trousers in crepe.", 75.00, "https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400&h=400&fit=crop"],
            ["Cashmere Cardigan", "Lightweight cashmere cardigan, open front.", 130.00, "https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?w=400&h=400&fit=crop"],
            ["Linen Shift Dress", "Breathable linen, perfect for warm days.", 60.00, "https://images.unsplash.com/photo-1560243563-062bfc001d68?w=400&h=400&fit=crop"],
            ["Tailored Shorts", "Cotton tailored shorts with belt loops.", 45.00, "https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400&h=400&fit=crop"],
            ["Pleated Midi Skirt", "Midi length, pleated, with an elastic waist.", 50.00, "https://images.unsplash.com/photo-1485968579580-b6d095142e6e?w=400&h=400&fit=crop"],
            ["Structured Blazer", "Single button blazer, fully lined.", 140.00, "https://images.unsplash.com/photo-1483985988355-763728e1935b?w=400&h=400&fit=crop"],
            ["Ribbed Knit Top", "Fitted ribbed knit with a crew neck.", 35.00, "https://images.unsplash.com/photo-1475180098004-ca77a9146669?w=400&h=400&fit=crop"],
            ["High-Waist Jeans", "Stretch denim, classic five-pocket design.", 80.00, "https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?w=400&h=400&fit=crop"],
            ["Maxi Wrap Dress", "Floral wrap dress with ruffle hem.", 70.00, "https://images.unsplash.com/photo-1445205170230-053b83016050?w=400&h=400&fit=crop"],
            ["Leather Belt", "Genuine leather with gold-tone buckle.", 30.00, "https://images.unsplash.com/photo-1552902865-b72c031ac5ea?w=400&h=400&fit=crop"],
            ["Silk Scarf", "Hand-rolled silk scarf, multiple colours.", 40.00, "https://images.unsplash.com/photo-1509631179647-0177331693ae?w=400&h=400&fit=crop"],
            ["Wool Beret", "Classic wool beret, one size.", 25.00, "https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?w=400&h=400&fit=crop"],
            ["Tassel Earrings", "Statement tassel earrings, lightweight.", 18.00, "https://images.unsplash.com/photo-1550639521-0d3df0a2b1de?w=400&h=400&fit=crop"],
            ["Straw Sunhat", "Wide-brim straw hat with ribbon trim.", 28.00, "https://images.unsplash.com/photo-1564557287817-3785e38adc5d?w=400&h=400&fit=crop"],
            ["Embroidered Clutch", "Beaded clutch with chain strap.", 55.00, "https://images.unsplash.com/photo-1503342217505-b0a15ace3260?w=400&h=400&fit=crop"],
            ["Satin Pajama Set", "Two-piece satin pajama set.", 65.00, "https://images.unsplash.com/photo-1517438476312-10d79c077509?w=400&h=400&fit=crop"],
            ["Denim Overalls", "Relaxed fit, adjustable straps.", 85.00, "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop"],
            ["Lace Bodysuit", "Stretch lace bodysuit with snap closure.", 42.00, "https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=400&h=400&fit=crop"],
            ["Block Heel Sandals", "Ankle strap sandals, cushioned sole.", 70.00, "https://images.unsplash.com/photo-1562157873-818bc0726f68?w=400&h=400&fit=crop"],
            ["Oversized Sweater", "Chunky knit, dropped shoulders.", 65.00, "https://images.unsplash.com/photo-1582142306909-195724d33ffc?w=400&h=400&fit=crop"],
            ["Flared Mini Dress", "Sleeveless mini dress with flared skirt.", 48.00, "https://images.unsplash.com/photo-1591369822096-ffd140ec948f?w=400&h=400&fit=crop"],
            ["Cropped Denim Jacket", "Classic denim jacket, cropped length.", 95.00, "https://images.unsplash.com/photo-1542295667260-2238a2e3ae5f?w=400&h=400&fit=crop"],
            ["Satin Slip Dress", "Bias cut satin slip, midi length.", 78.00, "https://images.unsplash.com/photo-1565260526622-391c76a05d0b?w=400&h=400&fit=crop"],
            ["Cotton Trench Coat", "Double-breasted cotton trench, water-resistant.", 150.00, "https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=400&h=400&fit=crop"],
            ["Knit Beanie", "Soft ribbed knit beanie, one size.", 22.00, "https://images.unsplash.com/photo-1514327605112-b887c0e61c0a?w=400&h=400&fit=crop"],
            ["Leather Tote Bag", "Genuine leather, spacious interior.", 110.00, "https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=400&h=400&fit=crop"],
            ["Gingham Shirt", "Cotton gingham, button-down collar.", 42.00, "https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=400&h=400&fit=crop"],
            ["Ruffle Blouse", "Feminine ruffle blouse with tie neck.", 48.00, "https://images.unsplash.com/photo-1567498430905-7164486800b3?w=400&h=400&fit=crop"],
            ["Jogger Pants", "Cotton joggers with elastic waist and cuffs.", 52.00, "https://images.unsplash.com/photo-1551854838-212c4b4c184d?w=400&h=400&fit=crop"],
            ["Velvet Blazer", "Soft velvet, single button, slim fit.", 135.00, "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop"],
            ["Printed Maxi Dress", "Bold print, halter neck, flowing skirt.", 68.00, "https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=400&h=400&fit=crop"],
            ["Biker Jacket", "Faux leather, asymmetric zip, slim fit.", 120.00, "https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400&h=400&fit=crop"],
            ["Strappy Heels", "Minimalist strappy heels, stiletto.", 65.00, "https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=400&h=400&fit=crop"],
            ["Cargo Trousers", "Cotton cargo, side pockets, relaxed fit.", 68.00, "https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=400&h=400&fit=crop"],
            ["Tulle Skirt", "Layered tulle midi skirt, hidden zip.", 88.00, "https://images.unsplash.com/photo-1583496661160-fb5886a0aaaa?w=400&h=400&fit=crop"],
            ["Cotton Tank Top", "Basic cotton tank, ribbed texture.", 20.00, "https://images.unsplash.com/photo-1533035353720-f1c6a75cddab?w=400&h=400&fit=crop"],
            ["Linen Blazer", "Unstructured linen blazer, patch pockets.", 145.00, "https://images.unsplash.com/photo-1555069519-127aadedf1ee?w=400&h=400&fit=crop"],
            ["Halter Top", "Satin halter top, backless, adjustable tie.", 32.00, "https://images.unsplash.com/photo-1564485373809-4d0a8c2ffc56?w=400&h=400&fit=crop"],
            ["Boyfriend Jeans", "Relaxed fit, distressed details, mid-rise.", 72.00, "https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=400&h=400&fit=crop"],
        ];

        foreach ($products as $p) {
            $client->products()->create([
                'name' => $p[0],
                'description' => $p[1],
                'price' => $p[2],
                'image_path' => $p[3],
                'is_available' => true,
                'sort_order' => 0,
            ]);
        }

        echo "Lusso Boutique now has " . $client->products()->count() . " products.\n";
    }
}
