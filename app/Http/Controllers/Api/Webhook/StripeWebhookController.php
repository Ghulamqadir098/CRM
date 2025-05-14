<?php
namespace App\Http\Controllers\Api\Webhook;


use Stripe\Webhook;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = env('STRIPE_WEBHOOK_SECRET'); // set this in your .env

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid Payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid Signature'], 400);
        }

        // ✅ Handle successful payment
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // Retrieve metadata (optional: set order_id in checkout session metadata)
            $orderId = $session->metadata->order_id ?? null;

            if ($orderId) {
                $order = Order::find($orderId);
                if ($order && $order->status !== 'paid') {
                    $order->update(['status' => 'paid']);
                }
            }

            Log::info("✅ Order #$orderId marked as paid.");
        }

        return response()->json(['status' => 'success']);
    }
}
