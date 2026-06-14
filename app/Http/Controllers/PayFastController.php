<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayFastController extends Controller
{
    public function checkout()
    {
        $data = [
            'merchant_id' => env('PAYFAST_MERCHANT_ID'),
            'merchant_key' => env('PAYFAST_MERCHANT_KEY'),
            'return_url' => env('PAYFAST_RETURN_URL'),
            'cancel_url' => env('PAYFAST_CANCEL_URL'),
            'notify_url' => env('PAYFAST_NOTIFY_URL'),
            'amount' => 200.00,
            'item_name' => 'Graveyard Management Test Payment',
        ];

        $query = http_build_query($data);
        return redirect(env('PAYFAST_URL') . "?$query");
    }

    public function notify(Request $request)
    {
        \Log::info('PayFast Notify:', $request->all());
        // TODO: Verify signature & update DB
    }

    public function success()
    {
        return "✅ Payment successful!";
    }

    public function cancel()
    {
        return "❌ Payment cancelled!";
    }
}
