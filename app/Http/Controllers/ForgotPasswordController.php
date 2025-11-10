<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon; // Add this for time comparison

class ForgotPasswordController extends Controller
{
    public function showRequestForm() {
        return view('auth.forgot_password');
    }

    public function sendCode(Request $request) {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $code = rand(100000, 999999);

        // Store code, email, and expiration time (1 minute from now)
        session([
            'reset_email' => $request->email,
            'reset_code' => $code,
            'reset_code_expires_at' => Carbon::now()->addMinute()
        ]);

        // Send email
        Mail::raw("Your password reset code is: $code\n\nNote: This code is valid for 1 minute only.", function ($message) use ($request) {
            $message->to($request->email)->subject('Attock GMS Password Reset Code');
        });

        return redirect()->route('password.verify')->with('success', 'Verification code sent to your email. Code is valid for 1 minute.');


    }

    public function showVerifyForm() {
        return view('auth.forgot_verify_password');
    }

    public function verifyCode(Request $request) {
        $request->validate(['code' => 'required']);

        $storedCode = session('reset_code');
        $expiresAt = session('reset_code_expires_at');

        // Check if code exists and not expired
        if (!$storedCode || !$expiresAt || Carbon::now()->greaterThan($expiresAt)) {
            session()->forget(['reset_code', 'reset_code_expires_at']);
            return back()->with('error', 'Code expired. Please request a new one.');
        }

        // Validate the code
        if ($request->code != $storedCode) {
            return back()->with('error', 'Invalid code. Please try again.');
        }

        return redirect()->route('password.reset');
    }

    public function showResetForm() {
        return view('auth.forgot_reset_password');
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'password' => 'required|min:4|confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/  ',
        ]);

        $user = User::where('email', session('reset_email'))->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear all session data related to reset
        session()->forget(['reset_email', 'reset_code', 'reset_code_expires_at']);

        return redirect()->route('login')->with('success', 'Password reset successfully. You can now login.');
    }
}
