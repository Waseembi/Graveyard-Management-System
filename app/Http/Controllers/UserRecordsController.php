<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class UserRecordsController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $registrations = UserRegistration::where('user_id', $userId)->get();
        $familyMembers = FamilyMember::with('registration')->where('user_id', $userId)->get();

        

        return view('roles.user.user_records', compact('registrations', 'familyMembers', ));
    }


    
    /**
     * View single registration
     */
    public function showRegistration($id)
    {
        $registration = UserRegistration::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Fetch all payment records for this user 
        $payments = Payment::where('registration_id', $registration->id)->orderBy('payment_year', 'desc')->get();

        return view('roles.user.user_records_view', compact('registration', 'payments'));
    }

    /**
     * Edit registration (limited fields)
     */
    public function editRegistration($id)
    {
        $registration = UserRegistration::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('roles.user.user_records_edit', compact('registration'));
    }

    /**
     * Update registration
     */
    public function updateRegistration(Request $request, $id)
    {
        $registration = UserRegistration::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'name'        => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'age'         => 'nullable|integer|min:0',
            'cnic'        => 'nullable|string|max:20',
            'dob'         => 'nullable|date',
            'gender'      => 'nullable|in:male,female',
        ]);

        $registration->update($request->only([
            'name',
            'father_name',
            'age',
            'cnic',
            'dob',
            'gender'
        ]));

        return redirect()
            ->route('user.records')
            ->with('success', 'Registration updated successfully');
    }

    /**
     * View family member
     */
    public function showFamily($id)
    {

        $member = FamilyMember::with('registration')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        // Fetch all payment records for this user 
        $payments = Payment::where('registration_id', $member->registration_id)->orderBy('created_at', 'desc')->get();

        return view('roles.user.user_records_family_view', compact('member', 'payments'));
    }

    /**
     * Edit family member
     */
    public function editFamily($id)
    {
        $member = FamilyMember::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('roles.user.user_records_family_edit', compact('member'));
    }

    /**
     * Update family member
     */
    public function updateFamily(Request $request, $id)
    {
        $member = FamilyMember::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'name'        => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'age'         => 'required|integer|min:0',
            'cnic'        => 'nullable|string|max:20',
            'dob'         => 'required|date',
            'gender'      => 'required|in:male,female',
            'address'     => 'required|string|max:255',
            'relationship'=> 'required|string|max:100',
        ]);

        $member->update($request->only([
            'name',
            'father_name',
            'age',
            'cnic',
            'dob',
            'gender',
            'address',
            'relationship',
        ]));

        // ✅ Update USER REGISTRATION using registration_id (IMPORTANT)
    if ($member->registration_id) {
        UserRegistration::where('id', $member->registration_id)->update([
            'name'        => $request->name,
            'father_name' => $request->father_name,
            'cnic'        => $request->cnic,
            'age'         => $request->age,
            'dob'         => $request->dob,
            'gender'      => $request->gender,
            'address'     => $request->address,
        ]);
    }

    // i use [#family] because after updating family member, user should be redirected to family section of user records page.
        return redirect()
         ->route('user.records', ['#family'])
         ->with('success', 'Family member updated successfully');

    }

}