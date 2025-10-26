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




    public function login(Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && password_verify($request->password, $user->password)) {
        Auth::login($user);

        // ✅ Redirect based on role
        if ($user->role_id === 1) {
            return redirect()->route('admin.dashboard');
        }

        //  return redirect()->route('user.dashboard');
        return redirect()->route('home');
        
    }

    return back()->withInput()->withErrors(['email' => 'Invalid credentials']);
    }









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
}

