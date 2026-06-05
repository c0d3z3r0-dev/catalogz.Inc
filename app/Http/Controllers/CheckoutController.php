<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function process(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $cart = session()->get("cart.{$client->id}", []);
        if (empty($cart)) {
            return redirect()->route('catalog.cart', $slug);
        }
        $items = $this->getCartItems($client, $cart);
        $total = array_sum(array_column($items, 'line_total'));

        $order = Order::create([
            'client_id' => $client->id,
            'customer_phone' => $request->input('customer_phone', ''),
            'status' => 'pending',
            'total' => $total,
            'currency' => $request->input('currency', 'USD'),
        ]);

        foreach ($items as $item) {
            $order->items()->create([
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'price' => $item['product']->price,
                'quantity' => $item['quantity'],
            ]);
        }

        session()->forget("cart.{$client->id}");

        $this->notifyMerchant($order);

        return redirect()->route('order.instructions', [$slug, $order->id]);
    }

    private function getCartItems($client, $cart)
    {
        $items = [];
        $products = $client->products()->whereIn('id', array_keys($cart))->get();
        foreach ($products as $product) {
            $qty = $cart[$product->id];
            $items[] = [
                'product' => $product,
                'quantity' => $qty,
                'line_total' => $product->price * $qty,
            ];
        }
        return $items;
    }

    private function notifyMerchant($order)
    {
        $client = $order->client;
        $message = "New order #{$order->id} from {$order->customer_phone}\nTotal: \${$order->total} ({$order->currency})\nView: " . route('order.instructions', [$client->slug, $order->id]);

        $token = config('services.whatsapp.token');
        $phoneId = config('services.whatsapp.phone_id');

        // Only send WhatsApp if real credentials are set (not placeholders)
        if ($token && $phoneId && $token !== 'your_meta_token' && $phoneId !== 'your_phone_id' && $client->whatsapp_number) {
            \Illuminate\Support\Facades\Http::withToken($token)
                ->timeout(5)
                ->post("https://graph.facebook.com/v18.0/{$phoneId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $client->whatsapp_number,
                    'type' => 'text',
                    'text' => ['body' => $message],
                ]);
        }

        // Email fallback (only if mail is configured)
        if ($client->email && config('mail.default') && config('mail.mailers.smtp.host')) {
            \Illuminate\Support\Facades\Mail::raw($message, function ($mail) use ($client, $order) {
                $mail->to($client->email)->subject("New Order #{$order->id}");
            });
        }
    }
}
