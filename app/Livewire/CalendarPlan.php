<?php

namespace App\Livewire;

use App\Models\plans;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CalendarPlan extends Component
{
    public function render()
    {
        $user = Auth::user();
        // $plansAcceptedclaencalendar = plans::where('user_id', $user->id)
        //     ->orWhereHas('users', function ($query) use ($user) {
        //         $query->where('user_id', $user->id)
        //             ->where('status', 'accepted');
        //     })
        //     ->with(['creator', 'users'])
        //     ->orderBy('start_date', 'desc')

        //     ->select('id', 'name', 'start_date','end_date' ,'time_out', 'meeting_place', 'description', 'difficulty', 'observations', 'user_id')
        //     ->get()->makeHidden(['creator', 'users']);

        $plansAcceptedclaencalendar = $user->plans()->with('creator')->latest()->get();
        $plansAcceptedclaencalendar = $plansAcceptedclaencalendar->map(function ($plan) {
            return [
                'id' => $plan->id,
                'name' => $plan->name,
                'start_date' => $plan->start_date->format('Y-m-d'), // ✅ Formato YYYY-MM-DD
                'end_date' => $plan->end_date->format('Y-m-d'),     // ✅ Formato YYYY-MM-DD
                'time_out' => $plan->time_out,      // ✅ Formato HH:MM:SS
                'difficulty' => $plan->difficulty ?? 'default',       // Si tienes este campo
                'description' => $plan->description,
                // Agrega otros campos que necesites
            ];
        })->toArray();


        return view('livewire.calendar-plan', compact('plansAcceptedclaencalendar'));
    }
}
