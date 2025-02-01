<?php

namespace App\Http\Controllers;

use App\Models\Order;

class StripeController extends Controller
{
    public function checkout(Order $order)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secretKey'));


        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'LKR',
                        'product_data' => [
                            'name' => $order->auction->title,
                            'images' => [
                                asset('storage/' . $order->auction->images[0]),
                            ],
                        ],
                        'unit_amount' => $order->auction->highestBid->amount * 100,
                    ],
                    'quantity' => 1,
                ]
            ],
            'customer_email' => $order->user->email,
            'mode' => 'payment',
            'success_url' => route('dashboard.purchases'),
            'cancel_url' => route('dashboard.purchases'),
            'metadata' => [
                'auction_id' => $order->auction->id,
                'order_id' => $order->id,
            ],
            'shipping_address_collection' => [
                'allowed_countries' => ['LK']
            ],
            'phone_number_collection' => ['enabled' => true],
        ]);

        return redirect()->away($session->url);
    }
}
