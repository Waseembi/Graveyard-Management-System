<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Burial;

class GraveSearchController extends Controller
{
   
    // public function index(Request $request)
    // {
    //     $name = $request->input('name');
    //     $cnic = $request->input('cnic');
    //     $graveId = $request->input('grave_id');
    //     $year = $request->input('year');



    //     $results = Burial::with(['registration', 'grave'])
    //         ->when($name, fn($q) => $q->where('name', 'like', "%$name%"))
    //         ->when($cnic, fn($q) => $q->orWhereHas('registration', fn($qr) => $qr->where('cnic', 'like',    "%$cnic%")))
    //         ->when($graveId, fn($q) => $q->where('grave_id', $graveId))
    //         ->when($year, fn($q) => $q->whereYear('date_of_death', $year))
    //         ->latest()
    //         ->get();

    //     return view('search', compact('results'));
    // }

    public function index(Request $request)
{
    $query = Burial::with(['registration', 'grave']);
    // Match by Name
    if ($request->filled('name')) {
        $query->where('name', 'like', "%{$request->name}%");
    }

    // Match by Father Name
    if ($request->filled('father_name')) {
        $query->where('father_name', 'like', "%{$request->father_name}%");
    }

    // Match by CNIC (inside registration relation)
    if ($request->filled('cnic')) {
        $query->whereHas('registration', function ($qr) use ($request) {
            $qr->where('cnic', 'like', "%{$request->cnic}%");
            
        });
    }

    // Match by Grave ID
    if ($request->filled('grave_id')) {
        $query->where('grave_id', $request->grave_id);
    }

    // Match by Year of Death
    if ($request->filled('year')) {
        $query->whereYear('date_of_death', $request->year);
    }

    // Finally get results
    $results = $query->latest()->get();

    return view('search', compact('results'));


    // this code will works only if user search by name else it will not return any result when page is loaded like in first code it returns all records when no search is made
    // $results = collect(); // empty collection by default 
    // if($request->filled('search')){ 
    //     $results = Burial::with(['registration','grave'])
    //                 ->where('name','like',"%{$request->search}%")
    //                 ->latest() ->get(); }


                    }



}