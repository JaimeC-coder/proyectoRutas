<?php

namespace App\Livewire;

use App\Models\plans;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\GoogleCalendarService;

class ListPlan extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];
    public function deletePlan($planId)
    {
        try {
            $plan = plans::findOrFail($planId);

            // Verificar que el usuario sea el creador o tenga permisos
            if ($plan->user_id !== Auth::id() && !$plan->users->contains(Auth::id())) {
                session()->flash('error', 'No tienes permiso para eliminar este plan.');
                return;
            }
            foreach ($plan->users as $user) {
                if ($user->hasGoogleCalendar() && $plan->isSyncedForUser($user->id)) {
                    $this->calendarService->deleteEventForUser($user, $plan);
                }
            }


            $plan->delete();
            session()->flash('message', 'Plan eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error deleting plan: ' . $e->getMessage());
            session()->flash('error', 'Hubo un error al eliminar el plan.');
        }
    }

    public function acceptPlan($id)
    {
        $userId = Auth::id();
        $this->updatePlanStatus($userId, $id, 'accepted');
        GoogleCalendarService::addEventForUser(Auth::user(), plans::find($id));
    }
    public function refusePlan($id)
    {
        $userId = Auth::id();
        $this->updatePlanStatus($userId, $id, 'refused');
        GoogleCalendarService::deleteEventForUser(Auth::user(), plans::find($id));
    }

    private function updatePlanStatus($userId, $planId, $status)
    {
        $plan = plans::find($planId);

        if ($plan && $plan->users->contains($userId)) {
            $plan->users()->updateExistingPivot($userId, ['status' => $status]);
        }
    }




    public function render()
    {
        $user = Auth::user();

        $allPlanes = $user->plans()
            ->orderBy('start_date', 'desc')
            ->get();




        return view('livewire.list-plan', compact('allPlanes'));
    }
}
