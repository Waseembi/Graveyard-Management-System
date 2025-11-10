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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/  ',
        ]);

        $code = rand(100000, 999999);

        // Check if this email already exists in pending_users
$existing = PendingUser::where('email', $request->email)->first();

if ($existing) {
    // Delete the old record (user didn't verify)
    $existing->delete();
}


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
        'email' => 'nullable|email', // allow nullable if you rely on session
        'code'  => 'required|string',
    ]);

    // Get email from request OR session (you redirected with ->with('email', ...))
    $email = $request->input('email') ?? session('email');

    if (!$email) {
        return back()->withErrors(['email' => 'Email is required. Please go back to the registration page.']);
    }

    // Normalize the code user submitted
    $submittedCode = trim($request->input('code'));

    // Find the pending user
    $pending = PendingUser::where('email', $email)->first();

    if (!$pending) {
        return back()->withErrors(['code' => 'No pending verification request was found for this email.']);
    }

    // Check expiry first
    if (now()->gt($pending->expires_at)) {
        // optional: delete expired pending record to allow re-register
        $pending->delete();
        return back()->withErrors(['code' => 'Code has expired. Please register again or request a new code.']);
    }

    // Compare codes as strings (trim both sides)
    if (trim((string)$pending->verification_code) !== $submittedCode) {
        return back()->withErrors(['code' => 'Invalid verification code. Please check your email and try again.']);
    }

    // Code matches and not expired -> create user
    User::create([
        'name'     => $pending->name,
        'email'    => $pending->email,
        'password' => $pending->password, // already hashed
    ]);

    // Clean up pending record
    $pending->delete();

    return redirect()->route('login')->with('success', 'Account created successfully. You can now log in.');
}

}

