<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;

class StripeWebhookController extends Controller
{
    public function webhook()
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secretKey'));
        $endpoint_secret = config('services.stripe.endpointSecret');

        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['message' => 'Invalid payload!'], 400);
        }
        if ($endpoint_secret) {
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload,
                    $sig_header,
                    $endpoint_secret
                );
            } catch (\Stripe\Exception\SignatureVerificationException $e) {
                return response()->json(['message' => 'Invalid signature!'], 400);
            }
        }

        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;

            $address = new Address([
                'city' => $session->shipping_details->address->city,
                'country'  => $session->shipping_details->address->country,
                'line1' => $session->shipping_details->address->line1,
                'line2' => $session->shipping_details->address->line2,
                'postal_code' => $session->shipping_details->address->postal_code,
                'phone' => $session->customer_details->phone,
            ]);

            $order = Order::where('_id', $session->metadata->order_id)->first();
            $order->address()->associate($address);
            $order->status = 'payed';
            $order->payment = $session->payment_intent;
            $order->save();
            return response()->json(['status' => 'success'], 200);
        }
        if ($event->type == "charge.succeeded") {
            $session = $event->data->object;

            $address = new Address([
                'city' => $session->billing_details->address->city,
                'country'  => $session->billing_details->address->country,
                'line1' => $session->billing_details->address->line1,
                'line2' => $session->billing_details->address->line2,
                'postal_code' => $session->billing_details->address->postal_code,
                'phone' => $session->billing_details->phone,
            ]);

            $order = Order::where('_id', $session->metadata->order_id)->first();
            $order->address()->associate($address);
            $order->status = 'payed';
            $order->payment = $session->payment_intent;
            $order->save();
            return response()->json(['status' => 'success'], 200);
        }
    }
}
