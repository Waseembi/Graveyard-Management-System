<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;



class AdminController extends Controller
{
    // AdminController
     public function index()
    {
        // ✅ Count records
        $totalUsers = User::count();
        $totalRegistrations = UserRegistration::count();
        $recentRegistrations = UserRegistration::latest()->take(5)->get();
       // $totalBurials = Burial::count();
        //$totalPayments = Payment::count();

        // Pass to view
        return view('roles.admindashboard', compact('totalUsers', 'totalRegistrations','recentRegistrations'));
    }

    public function profile()
    {
    $admin = Auth::user();
    return view('roles.admin.admin_profile', compact('admin'));
    }

    public function editProfile()
    {
    $admin = Auth::user();
    return view('roles.admin.admin_profile_edit', compact('admin'));
    }


    public function updateProfile(Request $request)
{
    $admin = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $admin->id,
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    // Update image
    if ($request->hasFile('profile_image')) {
        if ($admin->profile_image && File::exists(public_path('profile_images/' . $admin->profile_image))) {
            File::delete(public_path('profile_images/' . $admin->profile_image));
        }
        $image = $request->file('profile_image');
        $filename = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('profile_images'), $filename);
        $admin->profile_image = $filename;
    }

    // Update other fields
    $admin->name = $request->name;
    $admin->email = $request->email;

    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }

    $admin->save();

    return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
}


    
//     public function updateImage(Request $request)
//     {
//     $request->validate([
//         'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
//     ]);

//     /** @var \App\Models\User $admin */
//     $admin = Auth::user();  // i add above line because without above line its give red line on save

//     // Delete old image from public folder
//     if ($admin->profile_image && File::exists(public_path('profile_images/' . $admin->profile_image))) {
//         File::delete(public_path('profile_images/' . $admin->profile_image));
//     }

//     // Store new image in public/profile_images
//     $image = $request->file('profile_image');
//     $filename = time() . '_' . $image->getClientOriginalName();
//     $image->move(public_path('profile_images'), $filename);

//     $admin->profile_image = $filename;
//     $admin->save();

//     return redirect()->back()->with('success', 'Profile image updated successfully.');
// }

public function removeImage()
    {
    $admin = Auth::user();

    if ($admin->profile_image && File::exists(public_path('profile_images/' . $admin->profile_image))) {
        File::delete(public_path('profile_images/' . $admin->profile_image));
        $admin->profile_image = null;
    
        $admin->save();   
    }

    return redirect()->back()->with('success', 'Profile image removed.');
    }




}
