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
        return view('admin.burial_requests.show', compact('request'));
    }

    public function approve($id)
    {
        $request = BurialRequest::findOrFail($id);
        $registration = $request->registration;

        Burial::create([
            'user_id' => $request->user_id,
            'registration_id' => $registration->id,
            'death_certificate' => $request->death_certificate,
        ]);

        if ($registration->grave_id) {
            Grave::where('id', $registration->grave_id)->update(['status' => 'buried']);
        }

        $request->update(['status' => 'approved']);

        return redirect()->route('admin.burial.requests')->with('success', 'Burial request approved.');
    }

    public function reject($id)
    {
        $request = BurialRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);

        return redirect()->route('admin.burial.requests')->with('error', 'Burial request rejected.');
    }
}




