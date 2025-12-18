<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\Auth;

class UserRecordsController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $registrations = UserRegistration::where('user_id', $userId)->get();
        $familyMembers = FamilyMember::with('registration')->where('user_id', $userId)->get();


        return view('roles.user.user_records', compact('registrations', 'familyMembers'));
    }

}