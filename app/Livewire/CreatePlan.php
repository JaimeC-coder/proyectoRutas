<?php

namespace App\Livewire;

use App\Mail\PlanInvitationMail;
use App\Models\Plan;
use App\Models\PlanInvitation;
use App\Models\PlanInvitations;
use App\Models\plans;
use App\Models\User;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CreatePlan extends Component
{
    public $name;
    public $start_date;
    public $end_date;
    public $time_out;
    public $meeting_place;
    public $description;
    public $difficulty;
    public $observations;
    public $selectedUsers = [];
    public $inviteEmails = ['']; // Array para correos no registrados

    protected $rules = [
        'name' => 'required|string|max:255',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'time_out' => 'required',
        'meeting_place' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'difficulty' => 'nullable|in:easy,medium,hard',
        'observations' => 'nullable|string|max:1000',
        'inviteEmails.*' => 'nullable|email',
    ];

    protected $messages = [
        'name.required' => 'El nombre del plan es obligatorio.',
        'start_date.required' => 'La fecha de inicio del plan es obligatoria.',
        'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o posterior.',
        'end_date.required' => 'La fecha de fin del plan es obligatoria.',
        'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        'time_out.required' => 'La hora de encuentro es obligatoria.',
        'meeting_place.required' => 'El lugar de encuentro es obligatorio.',
        'difficulty.in' => 'La dificultad seleccionada no es válida.',
        'inviteEmails.*.email' => 'Ingresa un correo electrónico válido.',
    ];

    public function addEmailField()
    {
        $this->inviteEmails[] = '';
    }

    public function removeEmailField($index)
    {
        unset($this->inviteEmails[$index]);
        $this->inviteEmails = array_values($this->inviteEmails);
    }

    public function saveplan()
    {
        $this->validate();

        // Validación personalizada para usuarios seleccionados
        foreach ($this->selectedUsers as $userId => $userData) {
            if (isset($userData['selected']) && $userData['selected']) {
                if (empty($userData['role'])) {
                    $this->addError("selectedUsers.{$userId}.role", "Debes seleccionar un rol para este usuario.");
                }
            }
        }

        // Validar correos invitados y asignar roles
        $emailInvitations = [];
        foreach ($this->inviteEmails as $index => $email) {
            if (!empty($email)) {
                // Verificar si el correo ya está registrado
                $existingUser = User::where('email', $email)->first();
                if ($existingUser) {
                    $this->addError("inviteEmails.{$index}", "Este correo ya está registrado. Selecciónalo de la lista de usuarios.");
                } else {
                    $emailInvitations[] = [
                        'email' => $email,
                        'role' => 'guest' // Rol por defecto, puedes agregar un select si quieres
                    ];
                }
            }
        }

        // Si hay errores, detener ejecución
        if ($this->getErrorBag()->isNotEmpty()) {
            return;
        }

        try {
            DB::beginTransaction();

            // Crear el plan
            $plan = plans::create([
                'name' => $this->name,
                'start_date' => date('Y-m-d H:i:s', strtotime($this->start_date)),
                'end_date' => date('Y-m-d H:i:s', strtotime($this->end_date)),
                'time_out' => $this->time_out,
                'meeting_place' => $this->meeting_place,
                'description' => $this->description,
                'difficulty' => $this->difficulty,
                'observations' => $this->observations,
                'user_id' => Auth::id(),
            ]);

            //agregar al creador del plan como admin
            $plan->users()->attach(Auth::id(), [
                'role' => 'admin',
                'status' => 'accepted'
            ]);

            GoogleCalendarService::addEventForUser(Auth::user(), $plan);

            // Asociar usuarios registrados
            foreach ($this->selectedUsers as $userId => $userData) {
                if (isset($userData['selected']) && $userData['selected']) {
                    $plan->users()->attach($userId, [
                        'role' => $userData['role'] ?? 'guest'
                    ]);
                }
            }

            // Crear invitaciones por correo y enviar emails
            $inviterName = Auth::user()->name;
            foreach ($emailInvitations as $invitationData) {
                $invitation = PlanInvitations::createForPlan(
                    $plan->id,
                    $invitationData['email'],
                    $invitationData['role']
                );

                // Enviar correo
                Mail::to($invitationData['email'])->send(
                    new PlanInvitationMail($plan, $invitation, $inviterName)
                );
            }

            DB::commit();

            session()->flash('message', 'Plan creado exitosamente y se enviaron ' . count($emailInvitations) . ' invitación(es) por correo.');
            Log::info('Plan creado: ' . $plan->id . ' por usuario: ' . Auth::id());
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating plan: ' . $e->getMessage());
            session()->flash('error', 'Hubo un error al crear el plan. Por favor intenta de nuevo.');
        }
    }

    public function render()
    {
        $users = User::where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        return view('livewire.create-plan', compact('users'));
    }
}
