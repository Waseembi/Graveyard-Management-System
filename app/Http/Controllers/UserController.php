<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRegistration;
use App\Models\Payment;
use App\Models\Grave;
use App\Models\Burial;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


class UserController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $registrations = UserRegistration::where('user_id', $userId)->get();
        $payments = Payment::where('user_id', $userId)->get();
        $graves = Grave::whereHas('registration', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->get();
        $burials = Burial::where('user_id', $userId)->get();

        return view('roles.userdashboard', compact('registrations', 'payments', 'graves', 'burials'));
    }




    public function profile()
    {
    $user = Auth::user();
    return view('roles.user.user_profile', compact('user'));
    }

    public function editProfile()
    {
    $user = Auth::user();
    return view('roles.user.user_profile_edit', compact('user'));
    }


    public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    // Update image
    if ($request->hasFile('profile_image')) {
        if ($user->profile_image && File::exists(public_path('profile_images/user/' . $user->profile_image))) {
            File::delete(public_path('profile_images/user/' . $user->profile_image));
        }
        $image = $request->file('profile_image');
        $filename = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('profile_images/user'), $filename);
        $user->profile_image = $filename;
    }

    // Update other fields
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
}


    


public function removeImage()
    {
    $user = Auth::user();

    if ($user->profile_image && File::exists(public_path('profile_images/' . $user->profile_image))) {
        File::delete(public_path('profile_images/' . $user->profile_image));
        $user->profile_image = null;
    
        $user->save();   
    }

    return redirect()->back()->with('success', 'Profile image removed.');
    }

}
