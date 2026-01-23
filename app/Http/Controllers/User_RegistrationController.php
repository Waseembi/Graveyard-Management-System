<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class User_RegistrationController extends Controller
{
    public function create(){
        return view('GraveReservation');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'father_name' => 'required|string|max:255',
        'cnic' => 'nullable|digits:13',
        'age' => 'required|integer|min:1|max:120',
        'phone' => 'required|digits_between:7,15',
        'address' => 'required|string|max:500',
        'payment_method' => 'required|in:cash,card',
        'gender' => 'required|in:male,female',
        'dob' => 'required|date',
    ]);

    // Check for existing registration
    $alreadyRegistered = false;

    if ($request->filled('cnic')) {
        // If CNIC is provided, check by CNIC
        $alreadyRegistered = UserRegistration::where('cnic', $request->cnic)->exists();
    } else {
        // Otherwise, check by name + father_name + age
        $alreadyRegistered = UserRegistration::where('name', $request->name)
            ->where('father_name', $request->father_name)
            ->where('age', $request->age)
            ->exists();

    }

    if ($alreadyRegistered) {
        return redirect()->route('registration.create')
            ->with('error', 'This person is already registered.');
    }

    if (!Auth::check()) {
    return redirect()->route('login')->with('error', 'Please login to register.');
    }


    // Create new registration
    $user =   UserRegistration::create([
            'user_id' => Auth::id(), //  current logged-in user
            'name' => $request->name,
            'father_name' => $request->father_name,
            'cnic' => $request->cnic,
            'age' => $request->age,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'gender' => $request->gender,
            'status' => 'pending', //  default status
            'dob' => $request->dob,
        ]);

        Payment::create([ 
        'registration_id' => $user->id, 
        'user_id' => $user->user_id, 
        'purpose' => 'Annual Grave Fee', 
        'payment_year' => $user->created_at->year, 
        'status' => 'unpaid', ]);

    return redirect()->route('registration.create')
        ->with('success', 'Registration successfully done.');
}












// <---- this is from user dashboard register   ---> 
public function ucreate()
    {
        return view('roles.userregistration');
    }

public function ustore(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'father_name' => 'required|string|max:255',
        'cnic' => 'nullable|digits:13',
        'age' => 'required|integer|min:1|max:120',
        'phone' => 'required|digits_between:7,15',
        'address' => 'required|string|max:500',
        'payment_method' => 'required|in:cash,card',
        'gender' => 'required|in:male,female',
        'dob' => 'required|date',
    ]);

    // Check for existing registration
    $alreadyRegistered = false;

    if ($request->filled('cnic')) {
        // If CNIC is provided, check by CNIC
        $alreadyRegistered = UserRegistration::where('cnic', $request->cnic)->exists();
    } else {
        // Otherwise, check by name + father_name + phone
        $alreadyRegistered = UserRegistration::where('name', $request->name)
            ->where('father_name', $request->father_name)
            ->where('age', $request->age)
            ->exists();
    }
    if ($alreadyRegistered) {
        return redirect()->route('user.register.create')
            ->with('error', 'This person is already registered.');
    }

    if (!Auth::check()) {
    return redirect()->route('login')->with('error', 'Please login to register.');
  }

    // Create new registration
    $user =  UserRegistration::create([
            'user_id' => Auth::id(), //  current logged-in user
            'name' => $request->name,
            'father_name' => $request->father_name,
            'cnic' => $request->cnic,
            'age' => $request->age,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'gender' => $request->gender,
            'status' => 'pending', //  default status
            'dob' => $request->dob,
        ]);

        Payment::create([ 
        'registration_id' => $user->id, 
        'user_id' => $user->user_id, 
        'purpose' => 'Annual Grave Fee', 
        'payment_year' => $user->created_at->year, 
        'status' => 'unpaid', ]);

    return redirect()->route('user.register.create')->with('success', 'Registration successfully done.');
}


}