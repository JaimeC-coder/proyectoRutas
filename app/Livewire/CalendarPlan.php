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
        $plansAcceptedclaencalendar = plans::where('user_id', $user->id)
            ->orWhereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('status', 'accepted');
            })
            ->with(['creator', 'users'])
            ->orderBy('date', 'desc')
            ->select('id', 'name', 'date', 'time_out', 'meeting_place', 'description', 'difficulty', 'observations', 'user_id')
            ->get()->makeHidden(['creator', 'users']);;




        return view('livewire.calendar-plan', compact('plansAcceptedclaencalendar'));
    }
}
