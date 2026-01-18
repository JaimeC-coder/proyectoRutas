<?php

namespace App\Http\Controllers;

use App\Helpers\WhatsAppHelper;
use App\Models\PlanInvitations;
use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log as FacadesLog;

class PlanInvitationsController extends Controller
{
      public function accept($token)
    {
        $invitation = PlanInvitations::where('token', $token)->firstOrFail();

        if ($invitation->isExpired()) {
            return view('invitations.expired');
        }

        if ($invitation->isAccepted()) {
            return redirect()->route('plans.show', $invitation->plan_id)
                ->with('info', 'Ya has aceptado esta invitación.');
        }

        // Verificar si el usuario ya está registrado
        $user = User::where('email', $invitation->email)->first();

        if ($user) {
            // Usuario existe, solo asociar al plan
            if (Auth::id() !== $user->id) {
                Auth::login($user);
            }

            $invitation->plan->users()->attach($user->id, [
                'role' => $invitation->role
            ]);

            $invitation->update(['accepted_at' => now()]);

            return redirect()->route('plans.show', $invitation->plan_id)
                ->with('success', '¡Te has unido al plan exitosamente!');
        }

        // Usuario no existe, mostrar formulario de registro
        return view('invitations.register', compact('invitation'));
    }

    public function register(Request $request, $token)
    {
        $invitation = PlanInvitations::where('token', $token)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone'=>'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $invitation->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Asociar al plan
        $invitation->plan->users()->attach($user->id, [
            'role' => $invitation->role
        ]);

        $invitation->update(['accepted_at' => now()]);

        $creator = $invitation->plan->creator;
        FacadesLog::info("Número del creador del plan: " . $creator->phone);

        WhatsAppHelper::confirmationInvitation(
            $creator->name,
            $user->name,
            $invitation->plan->name,
            $creator->phone
        );
        // Login automático
        Auth::login($user);

        return redirect()->route('plans.show', $invitation->plan_id)
            ->with('success', '¡Cuenta creada y te has unido al plan!');
    }
}
