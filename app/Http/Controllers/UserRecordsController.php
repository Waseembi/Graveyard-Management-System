<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\Auth;

class UserRecordsController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $registrations = UserRegistration::where('user_id', $userId)->get();
        $familyMembers = FamilyMember::with('registration')->where('user_id', $userId)->get();


        return view('roles.user.user_records', compact('registrations', 'familyMembers'));
    }


    
    /**
     * View single registration
     */
    public function showRegistration($id)
    {
        $registration = UserRegistration::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('roles.user.user_records_view', compact('registration'));
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

        return view('roles.user.user_records_family_view', compact('member'));
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
            'age'         => 'nullable|integer|min:0',
            'cnic'        => 'nullable|string|max:20',
            'dob'         => 'nullable|date',
            'gender'      => 'nullable|in:male,female',
        ]);

        $member->update($request->only([
            'name',
            'father_name',
            'age',
            'cnic',
            'dob',
            'gender'
        ]));

        return redirect()
            ->route('user.records')
            ->with('success', 'Family member updated successfully');
    }

}