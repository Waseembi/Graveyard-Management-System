<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;
use App\Models\FamilyMember;
use App\Models\Burial;
use App\Models\Grave;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use App\Models\User;

class AdminUserController extends Controller
{

//--------- Show all registrations  ----------
    // public function index(Request $request)
    // {
    //     $query = UserRegistration::query();

    //     // Search by name or CNIC
    //     if ($request->filled('search')) {
    //         $query->where('name', 'like', "%{$request->search}%")
    //               ->orWhere('cnic', 'like', "%{$request->search}%");
    //     }

    //     $registrations = $query->latest()->paginate(10);

    //     return view('roles.admin.user', compact('registrations'));
    // }

// --------- Show all registrations ----------
public function index(Request $request)
{
    $query = UserRegistration::query();

    // Search by name or CNIC
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('father_name', 'like', "%{$search}%")
              ->orWhere('cnic', 'like', "%{$search}%");
        });
    }

    // Paginated users
    $registrations = $query->latest()->paginate(10);

    // Dashboard Stats
    $stats = [
        'total'    => UserRegistration::count(),
        'approved' => UserRegistration::where('status', 'approved')->count(),
        'pending'  => UserRegistration::where('status', 'pending')->count(),
        'buried'   => UserRegistration::where('burial_status', 'buried')->count(),
    ];

    return view('roles.admin.user', compact('registrations', 'stats'));
}


    

//---------- Delete a registration ------------
    public function destroy($id)
    {
        UserRegistration::findOrFail($id)->delete();
        FamilyMember::where('registration_id', $id)->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }



// -------- Edit user  -----------
    public function edit($id)
    {
    $user = UserRegistration::findOrFail($id);
    return view('roles.admin.user_edit', compact('user'));
    }


// ---------- Update user --------------
public function update(Request $request, $id)
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'father_name' => 'required|string|max:255',
        'cnic' => 'nullable|digits:13',
        'phone' => 'required|string|max:20',
        'age' => 'required|integer|min:1',
        'address' => 'required|string|max:255',
        'status' => 'required|in:approved,pending',
        'burial_status' => 'required|in:buried,not_buried',
        'dob'         => 'nullable|date',
        'gender'      => 'nullable|in:male,female',
    ]);

    // Find the user by ID
    $user = UserRegistration::findOrFail($id);

    // Update the user record
    // $user->update([
    //     'name' => $request->name,
    //     'father_name' => $request->father_name,
    //     'cnic' => $request->cnic,
    //     'phone' => $request->phone,
    //     'age' => $request->age,
    //     'address' => $request->address,
    //     'status' => $request->status,
    //     'burial_status' => $request->burial_status,
    // ]);

    //Prepare update data beavise we updating user two times also in below payment 
    $updateData = [ 
        'name' => $request->name, 
        'father_name' => $request->father_name, 
        'cnic' => $request->cnic, 
        'phone' => $request->phone, 
        'age' => $request->age, 
        'address' => $request->address, 
        'status' => $request->status, 
        'burial_status' => $request->burial_status,
        'dob' => $request->dob,
        'gender' => $request->gender,
    ];

    //  Update all related family members with the same registration_id
    FamilyMember::where('registration_id', $user->id)->update([
        'name' => $request->name,
        'father_name' => $request->father_name,
        'cnic' => $request->cnic,
        'phone' => $request->phone,
        'age' => $request->age,
        'dob' => $request->dob,
        'gender' => $request->gender,
        'address' => $request->address,
        'status' => $request->status,
    ]);

     // If burial_status is 'not_buried', delete related burial and grave records
    if ($request->burial_status === 'not_buried') {
        Burial::where('registration_id', $user->id)->delete();
        Grave::where('registration_id', $user->id)->update([ 'registration_id' => null, 'user_id' => null, 'status' => 'available',  ]);
    }

    //Case 1: status equal to Approved.
    //now adding the record in payments table if admin make user status  approved 
    // $user->status !== 'approved' && $request->status === 'approved' the login behind this code is if admin changes anything else so the payment record will not be created again and again.before this when admin change any other field it was creating multiple payment records if status is already approved.
    if ($user->status !== 'approved' && $request->status === 'approved') { 
        $currentYear = now()->year; 
         Payment::create([ 
            'registration_id' => $user->id, 
            'user_id' => $user->user_id, 
            'method' => 'cash',
            'amount' => 1000, 
            'purpose' => 'Annual Grave Fee', 
            'payment_year' => $currentYear, 
            'payment_date' => now(), 
            'status' => 'paid', 
            ]); 
        

        //this will uodate the payment date in user table
        $updateData['approved_at'] = now(); 
        $updateData['expiry_date'] = now()->endOfYear();
    }
    // Case 2: Admin sets user back to pending (unapprove) 
    if ($request->status === 'pending') { 
        // Clear validity 
        $updateData['approved_at'] = null; 
        $updateData['expiry_date'] = null; 
        // Delete payment record that matches approved_at year 
        if ($user->approved_at) 
            { 
                Payment::where('registration_id', $user->id)
                 ->whereDate('payment_date','=', $user->approved_at) ->delete(); 
            } 
    }
    // Update the user record once 
    $user->update($updateData);


    // Redirect back with success message
    return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }



//--------- Show All Users ----------
public function show($id){
    $user = UserRegistration::findOrFail($id);

    //this line will get who registered this user
    $userRegisterbywhom = User::where('id', $user->user_id)->first();

    // Case 1: user is a registrant 
    $familyMembers = FamilyMember::where('registration_id', $user->id)->first(); 
    

    // Case 2: user might also be listed as a family member 
    if ($familyMembers) {
        $familyMembersUserID  = $familyMembers->user_id;
        $familyRecord = FamilyMember::where('user_id', $familyMembersUserID)->get();  
    }
    else { 
        $familyRecord = collect(); 
        // this is used because without this the familymemmbers will give error if it is null. 
        }
    
    // Fetch all payment records for this user 
    $payments = Payment::where('registration_id', $user->id)->orderBy('created_at', 'desc')->get();

    return view('roles.admin.user_show', compact('user', 'familyRecord', 'userRegisterbywhom','payments'));
    }


}