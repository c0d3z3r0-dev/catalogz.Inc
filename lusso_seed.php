<?php
$c = \App\Models\Client::where('slug','lusso-boutique')->firstOrFail();
$c->products()->delete();
$products = [
    ['name'=>'Silk Blouse','description'=>'Soft silk blouse with a relaxed fit.','price'=>55.00,'image_path'=>'https://picsum.photos/400/400?random=20'],
    ['name'=>'Wide-Leg Trousers','description'=>'High-waisted wide-leg trousers in crepe.','price'=>75.00,'image_path'=>'https://picsum.photos/400/400?random=21'],
    ['name'=>'Cashmere Cardigan','description'=>'Lightweight cashmere cardigan, open front.','price'=>130.00,'image_path'=>'https://picsum.photos/400/400?random=22'],
    ['name'=>'Linen Shift Dress','description'=>'Breathable linen, perfect for warm days.','price'=>60.00,'image_path'=>'https://picsum.photos/400/400?random=23'],
    ['name'=>'Tailored Shorts','description'=>'Cotton tailored shorts with belt loops.','price'=>45.00,'image_path'=>'https://picsum.photos/400/400?random=24'],
    ['name'=>'Pleated Midi Skirt','description'=>'Midi length, pleated, with an elastic waist.','price'=>50.00,'image_path'=>'https://picsum.photos/400/400?random=25'],
    ['name'=>'Structured Blazer','description'=>'Single button blazer, fully lined.','price'=>140.00,'image_path'=>'https://picsum.photos/400/400?random=26'],
    ['name'=>'Ribbed Knit Top','description'=>'Fitted ribbed knit with a crew neck.','price'=>35.00,'image_path'=>'https://picsum.photos/400/400?random=27'],
    ['name'=>'High-Waist Jeans','description'=>'Stretch denim, classic five-pocket design.','price'=>80.00,'image_path'=>'https://picsum.photos/400/400?random=28'],
    ['name'=>'Maxi Wrap Dress','description'=>'Floral wrap dress with ruffle hem.','price'=>70.00,'image_path'=>'https://picsum.photos/400/400?random=29'],
    ['name'=>'Leather Belt','description'=>'Genuine leather with gold-tone buckle.','price'=>30.00,'image_path'=>'https://picsum.photos/400/400?random=30'],
    ['name'=>'Silk Scarf','description'=>'Hand-rolled silk scarf, multiple colours.','price'=>40.00,'image_path'=>'https://picsum.photos/400/400?random=31'],
    ['name'=>'Wool Beret','description'=>'Classic wool beret, one size.','price'=>25.00,'image_path'=>'https://picsum.photos/400/400?random=32'],
    ['name'=>'Tassel Earrings','description'=>'Statement tassel earrings, lightweight.','price'=>18.00,'image_path'=>'https://picsum.photos/400/400?random=33'],
    ['name'=>'Straw Sunhat','description'=>'Wide-brim straw hat with ribbon trim.','price'=>28.00,'image_path'=>'https://picsum.photos/400/400?random=34'],
    ['name'=>'Embroidered Clutch','description'=>'Beaded clutch with chain strap.','price'=>55.00,'image_path'=>'https://picsum.photos/400/400?random=35'],
    ['name'=>'Satin Pajama Set','description'=>'Two-piece satin pajama set.','price'=>65.00,'image_path'=>'https://picsum.photos/400/400?random=36'],
    ['name'=>'Denim Overalls','description'=>'Relaxed fit, adjustable straps.','price'=>85.00,'image_path'=>'https://picsum.photos/400/400?random=37'],
    ['name'=>'Lace Bodysuit','description'=>'Stretch lace bodysuit with snap closure.','price'=>42.00,'image_path'=>'https://picsum.photos/400/400?random=38'],
    ['name'=>'Block Heel Sandals','description'=>'Ankle strap sandals, cushioned sole.','price'=>70.00,'image_path'=>'https://picsum.photos/400/400?random=39'],
];
foreach ($products as $p) {
    $c->products()->create([
        'name' => $p['name'],
        'description' => $p['description'],
        'price' => $p['price'],
        'image_path' => $p['image_path'],
        'is_available' => true,
        'sort_order' => 0,
    ]);
}
echo "Lusso Boutique now has " . $c->products()->count() . " products.\n";
