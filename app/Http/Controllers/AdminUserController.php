<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;
use App\Models\FamilyMember;
use App\Models\Burial;
use App\Models\Grave;

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
        'cnic' => 'nullable|string|max:15',
        'phone' => 'required|string|max:20',
        'age' => 'required|integer|min:1',
        'address' => 'required|string|max:255',
        'status' => 'required|in:approved,pending',
        'burial_status' => 'required|in:buried,not_buried',
    ]);

    // Find the user by ID
    $user = UserRegistration::findOrFail($id);

    // Update the user record
    $user->update([
        'name' => $request->name,
        'father_name' => $request->father_name,
        'cnic' => $request->cnic,
        'phone' => $request->phone,
        'age' => $request->age,
        'address' => $request->address,
        'status' => $request->status,
        'burial_status' => $request->burial_status,
    ]);

    // ✅ Update all related family members with the same registration_id
    FamilyMember::where('registration_id', $user->id)->update([
        'name' => $request->name,
        'father_name' => $request->father_name,
        'cnic' => $request->cnic,
        'phone' => $request->phone,
        'age' => $request->age,
        'address' => $request->address,
        'status' => $request->status,
    ]);

     // If burial_status is 'not_buried', delete related burial and grave records
    if ($request->burial_status === 'not_buried') {
        Burial::where('registration_id', $user->id)->delete();
        Grave::where('registration_id', $user->id)->delete();
    }


    // Redirect back with success message
    return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }


//--------- Show All Users ----------
public function show($id)
    {
    $user = UserRegistration::findOrFail($id);
    $familyMembers = FamilyMember::where('registration_id', $id)->get();

    return view('roles.admin.user_show', compact('user', 'familyMembers'));
    }




}
