<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            $shipping_address = $session->shipping;

            Log::info($session);
        }

        return response()->json(['status' => 'success'], 200);
    }
}
