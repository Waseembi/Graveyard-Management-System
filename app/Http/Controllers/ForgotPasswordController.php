<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showRequestForm() {
        return view('auth.forgot_password');
    }

    public function sendCode(Request $request) {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $code = rand(100000, 999999);

        session(['reset_email' => $request->email, 'reset_code' => $code]);

        // Send email
        Mail::raw("Your password reset code is: $code", function ($message) use ($request) {
            $message->to($request->email)->subject('Attock GMS Password Reset Code');
        });

        return redirect()->route('password.verify')->with('success', 'Verification code sent to your email.');
    }

    public function showVerifyForm() {
        return view('auth.forgot_verify_password');
    }

    public function verifyCode(Request $request) {
        $request->validate(['code' => 'required']);
        if ($request->code == session('reset_code')) {
            return redirect()->route('password.reset');
        }
        return back()->with('error', 'Invalid code. Please try again.');
    }

    public function showResetForm() {
        return view('auth.forgot_reset_password');
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('email', session('reset_email'))->first();
        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget(['reset_email', 'reset_code']);

        return redirect()->route('login')->with('success', 'Password reset successfully. You can now login.');
    }
}

