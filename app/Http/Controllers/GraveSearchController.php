<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;

class GraveSearchController extends Controller
{
    public function index(Request $request)
    {
        $results = [];

        if ($request->has('name') && $request->name !== null) {
            $query = $request->name;
            $results = UserRegistration::where('name', 'LIKE', '%' . $query . '%')->get();
        }

        return view('search', compact('results'));
    }
}
