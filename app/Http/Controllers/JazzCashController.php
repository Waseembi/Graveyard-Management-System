<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JazzCashController extends Controller
{
    public function checkout()
    {
        date_default_timezone_set('Asia/Karachi');

        $merchantId    = "MC798338";
        $password      = "zx28x1e32w";
        $integritySalt = "xx1v3gbs1c";

        $returnUrl = "http://127.0.0.1:8000/jazzcash/response";

        $txnDateTime       = date('YmdHis');
        $txnExpiryDateTime = date('YmdHis', strtotime('+3 days'));
        $txnRefNo          = 'T' . $txnDateTime . rand(100, 999);

        $amount = 200; // PKR 200

        $postData = [
            "pp_Version"           => "1.1",
            "pp_TxnType"           => "MWALLET",
            "pp_Language"          => "EN",
            "pp_MerchantID"        => $merchantId,
            "pp_Password"          => $password,
            "pp_TxnRefNo"          => $txnRefNo,
            "pp_Amount"            => $amount * 100, // amount in paisa
            "pp_TxnCurrency"       => "PKR",
            "pp_TxnDateTime"       => $txnDateTime,
            "pp_TxnExpiryDateTime" => $txnExpiryDateTime,
            "pp_BillReference"     => "BILL001",
            "pp_Description"       => "TestPayment",
            "pp_ReturnURL"         => $returnUrl,

            // Sandbox test number
            "pp_MobileNumber"            => "03001234567",
            "pp_PaymentInstrumentNumber" => "03001234567",
            "pp_PaymentInstrumentID"     => "0",

            "ppmpf_1" => "1",
            "ppmpf_2" => "2",
            "ppmpf_3" => "3",
            "ppmpf_4" => "4",
            "ppmpf_5" => "5",
        ];

        // Build hash string from non-empty values
        $hashString = '';
        foreach ($postData as $key => $value) {
            if (!empty($value) && $key !== 'pp_SecureHash') {
                $hashString .= $value . '&';
            }
        }
        $hashString = rtrim($hashString, '&');

        $secureHash = strtoupper(hash_hmac('sha256', $hashString, $integritySalt));
        $postData['pp_SecureHash'] = $secureHash;

        return view('jazzcash_redirect', compact('postData'));
    }

    public function response(Request $request)
    {
        $responseData = $request->all();
        $ppSecureHash = $responseData['pp_SecureHash'] ?? null;

        $hashString = '';
        foreach ($responseData as $key => $value) {
            if (!empty($value) && $key !== 'pp_SecureHash') {
                $hashString .= $value . '&';
            }
        }
        $hashString = rtrim($hashString, '&');

        $calculatedHash = strtoupper(hash_hmac('sha256', $hashString, "xx1v3gbs1c"));
        $isValid = ($ppSecureHash === $calculatedHash);

        return response()->json([
            'success' => $isValid,
            'data' => $responseData,
        ]);
    }
}
