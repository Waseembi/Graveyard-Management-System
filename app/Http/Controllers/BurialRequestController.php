<?php
namespace App\Http\Controllers;

use App\Models\UserRegistration;
use App\Models\MarbleBooking;
use App\Models\Registration;
use App\Models\Grave;
use App\Models\Burial;
use App\Models\User;
use App\Models\BurialRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BurialApprovedMail;


class BurialRequestController extends Controller
{
    public function index()
    {
        $registrations = UserRegistration::where('status', 'approved')->where('burial_status', 'not_buried')
        ->where('user_id', auth()->id())
        ->get();
        return view('roles.user.request_burial', compact('registrations'));
    }

    
    public function create(UserRegistration $registration)
    {
        return view('roles.user.request_burial_form', compact('registration'));
    }

    public function store(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'registration_id' => 'required|exists:user_registrations,id',
            'death_certificate' => 'required|file|image|mimes:pdf,jpg,png|max:2048',
        ]);

         // ---------------- IMAGE UPLOAD ----------------
        $imageName = null;
        if ($request->hasFile('death_certificate')) {
            $image = $request->file('death_certificate');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/death'), $imageName);
        }

        $registration = UserRegistration::findOrFail($request->registration_id);

        BurialRequest::create([
            'user_id' => $request->user_id,
            'registration_id' => $registration->id,
            'name' => $registration->name,
            'father_name' => $registration->father_name,
            'cnic' => $registration->cnic,
            'age' => $registration->age,
            'phone' => $registration->phone,
            'address' => $registration->address,
            'gender' => $registration->gender,
            'dob' => $registration->dob,
            'date_of_death' => $request->date_of_death,
            'death_certificate' => $imageName,
            'status' => 'pending',
            'in_process' => true,
        ]);

        return redirect()->route('burial.request.index')->with('success', 'Burial request submitted successfully.');
    }



    ///// admin burial request methods (commented out for now)
    public function aindex()
    {
        $requests = BurialRequest::with('user', 'registration')->where('status', 'pending')->get();
        return view('roles.admin.burial_request', compact('requests'));
    }

    public function ashow($id)
    {
        $request = BurialRequest::with('user', 'registration')->findOrFail($id);
        return view('roles.admin.burial_request_form', compact('request'));
    }

    public function approve(Request $request, $id)
{
    // ✅ Validation
    $request->validate(
        [
            'grave_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ],
        [
            'grave_image.max'   => 'Grave image must be less than 2 MB.',
            'grave_image.image' => 'Only image files are allowed.',
            'date_of_death.required' => 'Date of death is required.',
        ]
    );

    // ✅ Find burial request + registration
    $burialRequest = BurialRequest::findOrFail($id);
    $registration  = $burialRequest->registration;

    // ---------------- IMAGE UPLOAD ----------------
    $imageName = null;
    if ($request->hasFile('grave_image')) {
        $image = $request->file('grave_image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/graves'), $imageName);
    }

    // ======================================================
    // STEP 1: CHECK IF USER ALREADY BOOKED A GRAVE
    // ======================================================
    $grave = Grave::where('registration_id', $registration->id)
                  ->where('status', 'booked')
                  ->first();

    // ======================================================
    // STEP 2: IF NOT → ASSIGN NEW GRAVE
    // ======================================================
    if (!$grave) {
        $grave = Grave::where('status', 'available')->first();

        if (!$grave) {
            return back()->with('error', 'No available graves.');
        }

        $grave->update([
            'registration_id' => $registration->id,
            'user_id'         => $registration->user_id,
            'status'          => 'booked',
        ]);
    } else {
        // ✅ Already booked → just ensure user_id is correct
        $grave->update([
            'user_id' => $registration->user_id,
        ]);
    }

    // ======================================================
    // STEP 3: CREATE BURIAL RECORD
    // ======================================================
    Burial::create([
        'registration_id' => $registration->id,
        'user_id'         => $registration->user_id,
        'grave_id'        => $grave->id,
        'name'            => $registration->name,
        'father_name'     => $registration->father_name,
        'date_of_death'   => $burialRequest->date_of_death,
        'grave_image'     => $imageName,
    ]);

    // ======================================================
    // STEP 4: UPDATE REGISTRATION + REQUEST STATUS
    // ======================================================
    $registration->update([
        'burial_status' => 'buried',
    ]);

    $burialRequest->update([
        'status' => 'approved',
        'in_process' => false,
    ]);

    // ======================================================
    // STEP 5: SEND EMAIL TO USER
    // ======================================================
    $userEmail = $registration->user->email; // Assuming relation exists

    $details = [
        'name'          => $registration->name,
        'registrationId'=> $registration->id,
        'fatherName'    => $registration->father_name,
        'age'           => $registration->age,
        'dateOfDeath'   => $burialRequest->date_of_death,
        'graveId'       => $grave->id,
        'cnic'          => $registration->cnic,
    ];

    Mail::send('mails.burialApproved', ['details' => $details], function($message) use ($userEmail) {
    $message->to($userEmail)
            ->subject('Burial Approval Notification');
});


    // ======================================================
    // SUCCESS
    // ======================================================
    return redirect()->route('admin.burial.requests')
        ->with('success', 'Burial request approved and burial record created successfully.');
} 



    public function reject($id)
    {
        $request = BurialRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);

        return redirect()->route('admin.burial.requests')->with('error', 'Burial request rejected.');
    }
}




