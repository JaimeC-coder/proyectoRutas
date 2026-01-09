<?php

namespace App\Livewire;

use App\Models\plans;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ListPlan extends Component
{
    public function deletePlan($planId)
    {
        try {
            $plan = plans::findOrFail($planId);

            // Verificar que el usuario sea el creador o tenga permisos
            if ($plan->user_id !== Auth::id() && !$plan->users->contains(Auth::id())) {
                session()->flash('error', 'No tienes permiso para eliminar este plan.');
                return;
            }

            $plan->delete();
            session()->flash('message', 'Plan eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error deleting plan: ' . $e->getMessage());
            session()->flash('error', 'Hubo un error al eliminar el plan.');
        }
    }

    private function transformPlan($user)
    {
        // Planes creados por el usuario
        $createdPlans = $user->createdPlans;

        // Planes compartidos con el usuario
        $sharedPlans = $user->plans;

        // Unir ambas colecciones y eliminar duplicados por ID
        $allPlans = $createdPlans->merge($sharedPlans)->unique('id');

        // Ordenar por fecha descendente
        return $allPlans->sortByDesc('date')->values();
    }

    public function render()
    {
        $user = Auth::user();
        // Obtener todos los planes del usuario (creados + compartidos) que el usuario a aceptó
        $plansAccepted = Plans::where('user_id', $user->id)
            ->orWhereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('status', 'accepted');
            })
            ->with(['creator', 'users'])
            ->orderBy('date', 'desc')
            ->get();

        $plansPendientes = Plans::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('status', 'pending');
        })
            ->with(['creator', 'users'])
            ->orderBy('date', 'desc')
            ->get();

        $planesRefused = Plans::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('status', 'refused');
        })
            ->with(['creator', 'users'])
            ->orderBy('date', 'desc')
            ->get();







        return view('livewire.list-plan', compact('plansAccepted', 'plansPendientes', 'planesRefused'));
    }
}
