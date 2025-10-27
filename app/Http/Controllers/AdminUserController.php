<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;

class AdminUserController extends Controller
{
    // Show all registrations
    public function index(Request $request)
    {
        $query = UserRegistration::query();

        // Search by name or CNIC
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('cnic', 'like', "%{$request->search}%");
        }

        $registrations = $query->latest()->paginate(10);

        return view('roles.admin.user', compact('registrations'));
    }

    // Show single registration details
    public function show($id)
    {
        $registration = UserRegistration::findOrFail($id);
        return view('roles.admin.user', compact('registration'));
    }

    // Edit form (optional)
    public function edit($id)
    {
        $registration = UserRegistration::findOrFail($id);
        return view('roles.admin.user', compact('registration'));
    }

    // Update registration info (optional)
    public function update(Request $request, $id)
    {
        $registration = UserRegistration::findOrFail($id);

        $registration->update([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'cnic' => $request->cnic,
            'status' => $request->status,
        ]);

        return redirect()->route('roles.admin.user')->with('success', 'Registration updated successfully.');
    }

    // Delete a registration
    public function destroy($id)
    {
        UserRegistration::findOrFail($id)->delete();
        return redirect()->route('roles.admin.user')->with('success', 'Registration deleted successfully.');
    }
}
