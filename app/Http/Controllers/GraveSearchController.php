<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Burial;

class GraveSearchController extends Controller
{
   
    public function index(Request $request)
    {
        $name = $request->input('name');
        $cnic = $request->input('cnic');
        $graveId = $request->input('grave_id');
        $year = $request->input('year');

        $results = Burial::with(['registration', 'grave'])
            ->when($name, fn($q) => $q->where('name', 'like', "%$name%"))
            ->when($cnic, fn($q) => $q->orWhereHas('registration', fn($qr) => $qr->where('cnic', 'like',    "%$cnic%")))
            ->when($graveId, fn($q) => $q->where('grave_id', $graveId))
            ->when($year, fn($q) => $q->whereYear('date_of_death', $year))
            ->latest()
            ->get();

        return view('search', compact('results'));
    }



    

}
