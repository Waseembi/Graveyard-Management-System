<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarbleBooking;
use App\Models\Burial;
use App\Models\Grave;

class MarbleBookingController extends Controller
{
    // Show all buried graves for the logged-in user
    public function index()
    {
        // Get all burials for the logged-in user 
        $burials = Burial::where('user_id', auth()->id()) 
                            ->with('marbleBookings')->get();
        return view('roles.user.marble_services', compact('burials'));
    }

    public function create($graveId) { 
        $grave = Grave::findOrFail($graveId); 
        // Get burial + registration details 
        $burial = Burial::where('grave_id', $graveId) 
                    ->where('user_id', auth()->id()) 
                    ->with('registration')->firstOrFail();
        return view('roles.user.marble_service_booking', compact('grave', 'burial')); 
    } 

    public function store(Request $request, $graveId) {
        $request->validate([ 
            'payment_method' => 'required|in:cash,card',
             ]); 

        // Find the burial record for this grave and user 
        $burial = Burial::where('grave_id', $graveId) ->where('user_id', auth()->id()) ->firstOrFail();

        MarbleBooking::create([ 
            'registration_id' => $burial->registration_id, 
            'user_id' => auth()->id(), 
            'grave_id' => $graveId, 
            'payment_method' => $request->payment_method, 
            'amount' => 20000, 
            'status' => 'pending', 
            ]); 

        return redirect()->route('marble.service.index')
                        ->with('success', 'Marble service request submitted successfully!');
    }



    //------------- admin functions -----------------

    public function adminindex() { 
        $bookings = MarbleBooking::with(['user','burial','registration'])->get(); 
        return view('roles.admin.admin_marble_service', compact('bookings')); 
    }

    public function update(Request $request, $id){
        $booking = MarbleBooking::findOrFail($id);
        $booking->status = $request->status;

        if($request->status === 'completed') {
            $booking->completed_at = now();
        }

        $booking->save();

        return redirect()->back()->with('success', 'Booking status updated successfully!');
    }



   
    
}
