<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\UserRegistration;
use App\Models\Payment;
use App\Models\MarbleBooking;
use App\Models\Grave;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalNotificationMail;
use App\Mail\MarbleBookingStatusMail;
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
                    'unit_amount' => 5193, // $5
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect($session->url);
    }

    //this is for user record view blade from where user pay by stripe, even user select cash, userrecordcontroler
    public function pay(UserRegistration $registration)
{
    // Set Stripe secret key
    Stripe::setApiKey(config('services.stripe.secret'));

    // Create a Stripe Checkout Session
    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => 'Annual Grave Fee'],
                'unit_amount' => 5193, // $15.00 (amount in cents)
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&reg_id=' . $registration->id,
        'cancel_url' => route('stripe.cancel'),
    ]);

    // Redirect user to Stripe Checkout
    return redirect($session->url);
}


   // Success handler for both flows
    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::retrieve($request->session_id);

        if ($session->payment_status === 'paid') {

            // Case 1: Existing registration (Pay Fee button)
            if ($request->filled('reg_id')) {
                $registration = UserRegistration::findOrFail($request->reg_id);

                $registration->update([
                    'status' => 'approved',
                    'payment_method' => 'card',
                ]);

                Payment::updateOrCreate(
                    ['registration_id' => $registration->id],
                    [
                        'user_id' => $registration->user_id,
                        'purpose' => 'Annual Grave Fee',
                        'status' => 'paid',
                        'amount' => 1500,
                        'method' => 'card',
                    ]
                );

            } elseif (session()->has('registration_data')) {
                // Case 2: New registration (form with card)
                $data = session('registration_data');

                $registration = UserRegistration::create([
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
                    'registration_id' => $registration->id,
                    'user_id' => $registration->user_id,
                    'purpose' => 'Annual Grave Fee',
                    'payment_year' => now()->year,
                    'payment_date' => now(),
                    'status' => 'paid',
                    'amount' => 1500,
                    'method' => 'card',
                ]);

                session()->forget('registration_data');
            }

            // Send approval email
        $registeredUser = \App\Models\User::find($registration->user_id);
        if ($registeredUser && $registeredUser->email) {
            Mail::to($registeredUser->email)
                ->send(new ApprovalNotificationMail($registration));
        }

            return redirect()->route('user.register.create')->with('success', 'Registration approved via Stripe!');
        }

        return redirect()->route('user.register.create')->with('error', 'Payment not completed.');
    }

    //for marble payment
    public function paymarble($bookingId)
{
    $booking = MarbleBooking::findOrFail($bookingId);

    Stripe::setApiKey(config('services.stripe.secret'));

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => 'Marble Service Fee'],
                'unit_amount' => 7018, // amount in cents ($200.00 if 20000)
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('marble.success') . '?session_id={CHECKOUT_SESSION_ID}&booking_id=' . $booking->id,
        'cancel_url' => route('marble.cancel'),
    ]);

    return redirect($session->url);
}

//for marble payment
public function successmarble(Request $request)
{
    Stripe::setApiKey(config('services.stripe.secret'));
    $session = Session::retrieve($request->session_id);

    if ($session->payment_status === 'paid') {
        $booking = MarbleBooking::findOrFail($request->booking_id);

        $booking->update([
            'status' => 'approved',
            'payment_method' => 'card',
        ]);

         Payment::create([
            'registration_id' => $booking->registration_id,
            'user_id'         => $booking->user_id,
            'purpose'         => 'Marble Service Fee',
            'payment_year'    => now()->year,
            'payment_date'    => now(),
            'status'          => 'paid',
            'amount'          => '20000', // use the amount from booking
            'method'          => 'card',
        ]);

        //  Send email notification to user
        $user = $booking->user; // assuming MarbleBooking has a relation ->user
        if ($user && $user->email) {
            Mail::to($user->email)->send(new MarbleBookingStatusMail($booking));
        }

        return redirect()->route('marble.service.index')
                         ->with('success', 'Marble service payment completed successfully!');
    }

    return redirect()->route('marble.service.index')
                     ->with('error', 'Payment not completed.');
}

//this is for map payment
public function checkoutmap(UserRegistration $registration)
{
    Stripe::setApiKey(config('services.stripe.secret'));

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => 'Annual Grave Fee'],
                'unit_amount' => 5193, // $5.00 in cents
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('map.success') . '?session_id={CHECKOUT_SESSION_ID}&reg_id=' . $registration->id,
        'cancel_url' => route('map.cancel'),
    ]);

    return redirect($session->url);
}


//this is for map payment
public function successmap(Request $request)
{
    Stripe::setApiKey(config('services.stripe.secret'));
    $session = Session::retrieve($request->session_id);

    if ($session->payment_status === 'paid') {
        $registration = UserRegistration::findOrFail($request->reg_id);

        $registration->update([
            'status' => 'approved',
            'payment_method' => 'card',
        ]);

        Payment::updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'user_id' => $registration->user_id,
                'purpose' => 'Annual Grave Fee',
                'payment_year' => now()->year,
                'payment_date' => now(),
                'status' => 'paid',
                'amount' => 1500,
                'method' => 'card',
            ]
        );

        $grave = Grave::where('registration_id', $registration->id)->firstOrFail();

        $grave->update([
            'status' => 'booked',
        ]);

        // Send approval email
        $registeredUser = \App\Models\User::find($registration->user_id);
        if ($registeredUser && $registeredUser->email) {
            Mail::to($registeredUser->email)
                ->send(new ApprovalNotificationMail($registration));
        }

        return redirect()->route('grave.map', ['id' => $grave->id])
            ->with('success', 'Registration approved via Stripe!');
    }

    return redirect()->route('grave.map', ['id' => $request->reg_id])
        ->with('error', 'Payment not completed.');
}


 public function cancelmap()
    {
        return redirect()->route('user.register.create')->with('error', 'Stripe payment cancelled.');
    }




    // public function success(Request $request)
    // {
    //     // Set key again before retrieving session
    //     Stripe::setApiKey(config('services.stripe.secret'));

    //     $session = Session::retrieve($request->session_id);

    //     if ($session->payment_status === 'paid') {
    //         $data = session('registration_data');

    //         $user = UserRegistration::create([
    //             'user_id' => Auth::id(),
    //             'name' => $data['name'],
    //             'father_name' => $data['father_name'],
    //             'cnic' => $data['cnic'],
    //             'age' => $data['age'],
    //             'phone' => $data['phone'],
    //             'address' => $data['address'],
    //             'payment_method' => $data['payment_method'],
    //             'gender' => $data['gender'],
    //             'status' => 'approved',
    //             'dob' => $data['dob'],
    //         ]);

    //         Payment::create([
    //             'registration_id' => $user->id,
    //             'user_id' => $user->user_id,
    //             'purpose' => 'Annual Grave Fee',
    //             'payment_year' => now()->year,
    //             'payment_date' => now(),
    //             'status' => 'paid',
    //             'amount' => 1500, // Store the amount paid
    //             'method' => $data['payment_method'], // Store the payment method used
    //         ]);

    //         session()->forget('registration_data');
    //         return redirect()->route('user.register.create')->with('success', 'Registration approved via Stripe!');
    //     }

    //     return redirect()->route('user.register.create')->with('error', 'Payment not completed.');
    // }

    public function cancel()
    {
        return redirect()->route('user.register.create')->with('error', 'Stripe payment cancelled.');
    }
}
