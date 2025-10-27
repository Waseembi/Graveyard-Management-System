<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;
use App\Models\User;


class AdminController extends Controller
{
    // AdminController
     public function index()
    {
        // ✅ Count records
        $totalUsers = User::count();
        $totalRegistrations = UserRegistration::count();
        $recentRegistrations = UserRegistration::latest()->take(5)->get();
       // $totalBurials = Burial::count();
        //$totalPayments = Payment::count();

        // Pass to view
        return view('roles.admindashboard', compact('totalUsers', 'totalRegistrations','recentRegistrations'));
    }

}
