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

    // Show add burial page
    public function showAddBurialForm()
    {
        return view('roles.admin.add_burials');
    }

    // Search registration
    public function searchRegistration(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string',
            'father_name' => 'nullable|string',
            'cnic' => 'nullable|string',
        ]);

        $registrations = UserRegistration::query()
            ->when($request->name, fn ($q) =>
                $q->where('name', 'like', '%' . $request->name . '%')
            )
            ->when($request->father_name, fn ($q) =>
                $q->where('father_name', 'like', '%' . $request->father_name . '%')
            )
            ->when($request->cnic, fn ($q) =>
                $q->where('cnic', 'like', '%' . $request->cnic . '%')
            )
            ->get();

        return view('roles.admin.add_burials', compact('registrations'));
    }

    // Store burial
    public function storeBurial(Request $request)
    {
        $request->validate(
    [
        'registration_id' => 'required|exists:user_registrations,id',
        'date_of_death'   => 'required|date',
        'grave_image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2 MB limit
    ],
    [
        'grave_image.max'   => 'Grave image must be less than 2 MB.',
        'grave_image.image' => 'Only image files are allowed.',
        'registration_id.required' => 'Registration ID is required.',
        'date_of_death.required'   => 'Date of death is required.',
    ]
);

        $registration = UserRegistration::findOrFail($request->registration_id);

        if ($registration->status !== 'approved') {
            return back()->with('error', 'User is not approved for burial.');
        }

        if ($registration->burial_status === 'buried') {
            return back()->with('error', 'Burial already exists.');
        }

        /* ---------------- Image Upload ---------------- */
        $imageName = null;
            if ($request->hasFile('grave_image')) {
                $image     = $request->file('grave_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/graves'), $imageName);
            }

        // Auto assign grave
        $grave = Grave::create([
            'registration_id' => $registration->id,
            'user_id' => $registration->user_id,
            'status' => 'booked',
        ]);

        Burial::create([
            'registration_id' => $registration->id,
            'user_id' => $registration->user_id,
            'grave_id' => $grave->id,
            'name' => $registration->name,
            'father_name' => $registration->father_name,
            'date_of_death' => $request->date_of_death,
            'grave_image'     => $imageName,
        ]);

        $registration->update([
            'burial_status' => 'buried',
        ]);

        return redirect()->route('admin.burials.add')
            ->with('success', 'Burial record added successfully.');
    }


}

