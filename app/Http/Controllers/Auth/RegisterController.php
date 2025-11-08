<?php

namespace App\Http\Controllers\Auth;

// app/Http/Controllers/Auth/RegisterController.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\PendingUser;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email|unique:pending_users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $code = rand(100000, 999999);

        PendingUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::raw("Your Attock GMS verification code is: $code", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Attock GMS Email Verification');
        });

        return redirect()->route('verify.code.form')->with('email', $request->email);
    }

    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
        ]);

        $pending = PendingUser::where('email', $request->email)->first();

        if (!$pending || $pending->verification_code !== $request->code || now()->gt($pending->expires_at)) {
            return back()->withErrors(['code' => 'Invalid or expired code']);
        }

        User::create([
            'name' => $pending->name,
            'email' => $pending->email,
            'password' => $pending->password,
        ]);

        $pending->delete();

        return redirect()->route('login')->with('success', 'Account created successfully. You can now log in.');
    }
}

