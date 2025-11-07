<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function home() {
        $user = Auth::user();
        return view('home', compact('user'));
    }

    public function showLogin() {
        return view('auth.login');
    }




    // public function login(Request $request) {
    // $request->validate([
    //     'email' => 'required|email',
    //     'password' => 'required',
    // ]);

    // $user = User::where('email', $request->email)->first();

    // if ($user && password_verify($request->password, $user->password)) {
    //     Auth::login($user);

    //     // ✅ Redirect based on role
    //     if ($user->role_id === 1) {
    //         return redirect()->route('admin.dashboard');
    //     }

    //     //  return redirect()->route('user.dashboard');
    //     return redirect()->route('home');
        
    //     }

    //  return back()->withInput()->with('error', 'Invalid credentials');
    // }









    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = 2; // 👈 Default to 'user' role
        $user->save();

        return redirect()->route('login')->with('success', 'Account created. Please login.');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }







public function login(Request $request)
{
    // ✅ Step 1: Validate input first
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // ✅ Step 2: Try to find user
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        // If email doesn’t exist → validation-style error
        return back()
            ->withErrors(['email' => 'No account found with this email address.'])
            ->withInput();
    }

    if (!password_verify($request->password, $user->password)) {
        // If password doesn’t match → validation-style error
        return back()
            ->withErrors(['password' => 'Incorrect password.'])
            ->withInput();
    }

    // ✅ Step 3: Login the user
    Auth::login($user);

    // ✅ Step 4: Redirect by role
    if ($user->role_id === 1) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('home');
}


}