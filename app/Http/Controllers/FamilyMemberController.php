<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyMember;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRegistration;

class FamilyMemberController extends Controller
{
    // Show form
    public function create()
    {
        return view('roles.familyregistration');
    }



    // Store family member
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'father_name' => 'required|string|max:255',
        'cnic' => 'nullable|digits:13',
        'age' => 'required|integer|min:1|max:120',
        'phone' => 'required|digits_between:7,15',
        'address' => 'required|string|max:500',
        'relationship' => 'required|string|max:50',
        'payment_method' => 'required|in:cash,card',
        'gender' => 'required|in:male,female',
        'dob' => 'required|date',
        
    ]);

    // ✅ Check if user is logged in
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to register.');
    }

    // ✅ Check for duplicate registration
    $alreadyRegistered = false;

    if ($request->filled('cnic')) {
        $alreadyRegistered = UserRegistration::where('cnic', $request->cnic)->exists();
    } else {
        $alreadyRegistered = UserRegistration::where('name', $request->name)
            ->where('father_name', $request->father_name)
            ->where('age', $request->age)
            ->exists();
    }

    if ($alreadyRegistered) {
        return redirect()->back()->with('error', 'This person is already registered.');
    }

    // ✅ Step 1: Create user registration
    $user = UserRegistration::create([
        'user_id' => Auth::id(),
        'name' => $request->name,
        'father_name' => $request->father_name,
        'cnic' => $request->cnic,
        'age' => $request->age,
        'phone' => $request->phone,
        'address' => $request->address,
        'payment_method' => $request->payment_method,
        'gender' => $request->gender,
        'dob' => $request->dob,
        'status' => 'pending',
    ]);

    // ✅ Step 2: Create family member record linked to user registration
    FamilyMember::create([
        'registration_id' => $user->id,
        'user_id' => Auth::id(),
        'name' => $request->name,
        'father_name' => $request->father_name,
        'age' => $request->age,
        'phone' => $request->phone,
        'cnic' => $request->cnic,
        'address' => $request->address,
        'relationship' => $request->relationship,
        'payment_method' => $request->payment_method,
        'gender' => $request->gender,
        'dob' => $request->dob,
        'status' => 'pending',
    ]);

    Payment::create([ 
        'registration_id' => $user->id, 
        'user_id' => $user->user_id, 
        'purpose' => 'Annual Grave Fee', 
        'payment_year' => $user->created_at->year, 
        'status' => 'unpaid', ]);

    return redirect()->route('family.create')->with('success', 'Registration completed successfully!');
}

}
