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
    //to show burial page for admin
    public function index(Request $request)
    {
        $name = $request->input('name');
        $cnic = $request->input('cnic');
        $graveId = $request->input('grave_id');
        $year = $request->input('year');

        $burials = Burial::with(['registration', 'grave'])
            ->when($name, fn($q) => $q->where('name', 'like', "%$name%"))
            ->when($cnic, fn($q) => $q->orWhereHas('registration', fn($qr) => $qr->where('cnic', 'like',    "%$cnic%")))
            ->when($graveId, fn($q) => $q->where('grave_id', $graveId))
            ->when($year, fn($q) => $q->whereYear('date_of_death', $year))
            ->latest()
            ->get();

        return view('roles.admin.burials', compact('burials'));
    }



   public function showAddBurialForm(Request $request)
    {
    $registration = null;

    if ($request->has('query')) {
        $query = trim($request->query('query'));

        if (is_numeric($query)) {
            if (strlen($query) === 13) {
                // CNIC match (stored as string)
                $registration = UserRegistration::where('cnic', $query)->first();
            } else {
                // Registration ID match
                $registration = UserRegistration::find($query);
            }
        } else {
            // Name match
            $registration = UserRegistration::where('name', 'like', "%$query%")->first();
        }
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

    
    // ✅ Optional: Prevent duplicate burial for same registration
    // if (Burial::where('registration_id', $registration->id)->exists()) {
    //     return back()->with('error', 'Burial record already exists for this user.');
    // }

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

    $registration->update([
    'burial_status' => 'buried',
    ]);

    return redirect()->route('admin.burials.add')->with('success', 'Burial record and grave assigned successfully.');
    }




}
