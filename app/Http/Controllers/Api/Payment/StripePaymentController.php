<?php

namespace App\Http\Controllers\Api\Payment;


use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Http\Controllers\Controller;
use App\Models\Order;

class StripePaymentController extends Controller
{
    public function stripe()

    {

        return view('stripe');
    }



    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function checkout(Order $order)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Prepare line items array
        $lineItems = [];

        foreach ($order->orderItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => intval($item->price * 100), // Stripe requires amount in cents
                    'product_data' => [
                        'name' => $item->itemable->name ?? 'Item', // assuming polymorphic itemable has a 'name'
                        // You can also add description/image if you want
                    ],
                ],
                'quantity' => $item->quantity,
            ];
        }

        // Create the checkout session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => url('/success'),
            'cancel_url' => url('/cancel'),
            'metadata' => [
                'order_id' => $order->id
            ]
        ]);

        // Redirect to Stripe checkout
        return response()->json([
            'success' => true,
            'message' => 'Checkout session created',
            'url' => $session->url
        ]);
    }
}
