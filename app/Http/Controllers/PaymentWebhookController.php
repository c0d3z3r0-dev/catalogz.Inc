<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $reference = $request->input('reference');
        $status = $request->input('status');

        $order = Order::where('paynow_reference', $reference)->first();

        if ($order && $status === 'paid') {
            $order->update(['status' => 'paid']);
            $this->notifyMerchant($order);
        } elseif ($order && $status === 'cancelled') {
            $order->update(['status' => 'failed']);
        }

        return response('OK', 200);
    }

    private function notifyMerchant($order)
    {
        $client = $order->client;
        $message = "New order #{$order->id} from {$order->customer_phone}\nTotal: \${$order->total} ({$order->currency})\nView: " . route('order.confirmation', [$client->slug, $order->id]);

        // WhatsApp notification
        $token = config('services.whatsapp.token');
        $phoneId = config('services.whatsapp.phone_id');
        $to = $client->whatsapp_number; // should be in international format, e.g., 263771234567

        if ($token && $phoneId && $to) {
            \Illuminate\Support\Facades\Http::withToken($token)
                ->post("https://graph.facebook.com/v18.0/{$phoneId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $to,
                    'type' => 'text',
                    'text' => ['body' => $message],
                ]);
        }

        // Email fallback (optional)
        if ($client->email) {
            \Illuminate\Support\Facades\Mail::raw($message, function ($mail) use ($client) {
                $mail->to($client->email)->subject("New Order #{$order->id}");
            });
        }
    }
}
