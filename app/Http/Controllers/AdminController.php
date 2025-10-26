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
        $totalRegistrations = UserRegistration::count();
        $totalUsers = User::count();

        return view('roles.admindashboard' , compact('totalRegistrations', 'totalUsers'));
    }


}
