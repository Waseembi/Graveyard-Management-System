<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\UserRegistration;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function checkout()
    {
        // Always set the key before any Stripe call
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => 'Graveyard Registration Fee'],
                    'unit_amount' => 500, // $5
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        // Set key again before retrieving session
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($request->session_id);

        if ($session->payment_status === 'paid') {
            $data = session('registration_data');

            $user = UserRegistration::create([
                'user_id' => Auth::id(),
                'name' => $data['name'],
                'father_name' => $data['father_name'],
                'cnic' => $data['cnic'],
                'age' => $data['age'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'payment_method' => 'card',
                'gender' => $data['gender'],
                'status' => 'approved',
                'dob' => $data['dob'],
            ]);

            Payment::create([
                'registration_id' => $user->id,
                'user_id' => $user->user_id,
                'purpose' => 'Annual Grave Fee',
                'payment_year' => $user->created_at->year,
                'status' => 'paid',
                'method' => 'card',
            ]);

            session()->forget('registration_data');
            return redirect()->route('user.register.create')->with('success', 'Registration approved via Stripe!');
        }

        return redirect()->route('user.register.create')->with('error', 'Payment not completed.');
    }

    public function cancel()
    {
        return redirect()->route('user.register.create')->with('error', 'Stripe payment cancelled.');
    }
}
