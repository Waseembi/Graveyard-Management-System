<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


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
    return view('roles.admin.user_profile', compact('admin'));
}


public function updateImage(Request $request)
{
    $request->validate([
        'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $admin = Auth::user();

    // Delete old image from public folder
    if ($admin->profile_image && File::exists(public_path('profile_images/' . $admin->profile_image))) {
        File::delete(public_path('profile_images/' . $admin->profile_image));
    }

    // Store new image in public/profile_images
    $image = $request->file('profile_image');
    $filename = time() . '_' . $image->getClientOriginalName();
    $image->move(public_path('profile_images'), $filename);

    $admin->profile_image = $filename;
    $admin->save();

    return redirect()->back()->with('success', 'Profile image updated successfully.');
}

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
