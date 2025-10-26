<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRegistration;
use App\Models\Payment;
use App\Models\Grave;
use App\Models\Burial;

class UserController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $registrations = UserRegistration::where('user_id', $userId)->get();
        $payments = Payment::where('user_id', $userId)->get();
        $graves = Grave::whereHas('registration', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->get();
        $burials = Burial::where('user_id', $userId)->get();

        return view('roles.userdashboard', compact('registrations', 'payments', 'graves', 'burials'));
    }

}
