<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function checkout()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Graveyard Management Test Payment',
                    ],
                    'unit_amount' => 2000, // $20 in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/stripe/success'),
            'cancel_url' => url('/stripe/cancel'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        return "✅ Stripe payment successful!";
    }

    public function cancel()
    {
        return "❌ Stripe payment cancelled!";
    }
}
