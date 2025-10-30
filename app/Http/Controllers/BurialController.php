<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Burial;
use App\Models\UserRegistration;
use App\Models\Grave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BurialController extends Controller
{
   public function showAddBurialForm(Request $request)
{
    $registration = null;

    if ($request->has('query')) {
        $query = $request->query('query');

        $registration = UserRegistration::where('id', $query)
            ->orWhere('cnic', 'like', "%$query%")
            ->orWhere('name', 'like', "%$query%")
            ->first();
    }

    return view('roles.admin.add_burials', compact('registration'));
}

public function storeBurial(Request $request)
{
    $request->validate([
        'registration_id' => 'required|exists:user_registrations,id',
        'date_of_death' => 'required|date',
    ]);

    $registration = UserRegistration::with('user')->find($request->registration_id);

    if (!$registration || $registration->status !== 'approved') {
        return redirect()->back()->with('error', 'User is not approved for burial.');
    }

    // Create grave record and mark as booked
    $grave = Grave::create([
        'registration_id' => $registration->id,
        'user_id' => $registration->user_id,
        'location' => null, // or assign dynamically later
        'status' => 'booked',
    ]);

    // Create burial record
    Burial::create([
        'registration_id' => $registration->id,
        'user_id' => $registration->user_id,
        'grave_id' => $grave->id,
        'name' => $registration->name,
        'father_name' => $registration->father_name,
        'date_of_death' => $request->date_of_death,
    ]);

    return redirect()->route('admin.burials.add')->with('success', 'Burial record and grave assigned successfully.');
}
}
