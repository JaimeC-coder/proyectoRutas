<?php

namespace App\Http\Controllers;

use App\Models\Plans;
use App\Models\User;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planes = Plans::all();
        return view('admin.plans.index', compact('planes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user()->id ?? null;
        $users  = User::where('id', '!=', $user)->get();
        return view('plans.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'time_out' => 'required',
            'meeting_place' => 'required|string',
            'description' => 'required|string',
            'difficulty' => 'required|string',
            'observations' => 'nullable|string',
        ]);

        dd($request->all());

        $plan = Plans::create([
            'name' => $request->name,
            'date' => $request->date,
            'time_out' => $request->time_out,
            'meeting_place' => $request->meeting_place,
            'description' => $request->description,
            'difficulty' => $request->difficulty,
            'observations' => $request->observations,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('plans.    -users', $plan)
            ->with('success', 'Plan creado correctamente');
    }


    /**
     * Display the specified resource.
     */
    public function show(Plans $plan)
    {

        return view('plans.show',compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plans $plans)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plans $plans)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plans $plans)
    {
        //
    }
}
