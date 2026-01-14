<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

use App\Models\Plans;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    private static function getClient($user)
    {
        if (!$user->google_access_token) {
            return null;
        }

        $client = new Client();
        $client->setClientId(config('google-calendar.client_id'));
        $client->setClientSecret(config('google-calendar.client_secret'));
        $client->setAccessToken($user->google_access_token);

        if ($client->isAccessTokenExpired()) {
            if ($user->google_refresh_token) {
                $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                $user->update([
                    'google_access_token' => $client->getAccessToken()['access_token'],
                    'google_token_expires_at' => now()->addSeconds($client->getAccessToken()['expires_in']),
                ]);
            } else {
                return null;
            }
        }

        return $client;
    }

    /**
     * Agregar un plan al Google Calendar de un usuario específico
     */
    public static function addEventForUser(User $user, Plans $plan)
    {
        $client = self::getClient($user);

        if (!$client) {
            return false;
        }

        try {

            // Determinar si el usuario es el creador o invitado
            $isCreator = $plan->isCreator($user->id);
            $role = $isCreator ? 'Organizador' : 'Invitado';
            $service = new Calendar($client);
            $event = new Event([
                'summary' => $plan->name,
                'description' => $plan->description . "\n\n[$role en este plan]",
                'start' => [
                    'dateTime' => $plan->start_date->toRfc3339String(),
                    'timeZone' => 'America/Lima',
                ],
                'end' => [
                    'dateTime' => ($plan->end_date && $plan->end_date->isAfter($plan->start_date)  ? $plan->end_date : $plan->start_date->copy()->addHours(1)
                    )->toRfc3339String(),
                    'timeZone' => 'America/Lima',
                ],
            ]);

            $createdEvent = $service->events->insert('primary', $event);

            // Guardar el google_event_id en la tabla pivote
            $plan->users()->updateExistingPivot($user->id, [
                'google_event_id' => $createdEvent->getId(),
                'synced_at' => now(),
            ]);

            return $createdEvent->getId();
        } catch (\Exception $e) {
            Log::error("Error al crear evento para usuario {$user->id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualizar evento en el calendario de un usuario específico
     */
    public static function updateEventForUser(User $user, Plans $plan)
    {
        $googleEventId = $plan->getGoogleEventIdForUser($user->id);

        if (!$googleEventId) {
            return self::addEventForUser($user, $plan);
        }

        $client = self::getClient($user);

        if (!$client) {
            return false;
        }

        try {
            $service = new Calendar($client);
            $event = $service->events->get('primary', $googleEventId);

            $isCreator = $plan->isCreator($user->id);
            $role = $isCreator ? 'Organizador' : 'Invitado';

            $event->setSummary($plan->name);
            $event->setDescription($plan->description . "\n\n[$role en este plan]");
            $event->setStart(new \Google\Service\Calendar\EventDateTime([
                'dateTime' => $plan->start_date->toRfc3339String(),
                'timeZone' => 'America/Lima',
            ]));
            $event->setEnd(new \Google\Service\Calendar\EventDateTime([
                'dateTime' => $plan->end_date->toRfc3339String(),
                'timeZone' => 'America/Lima',
            ]));

            $service->events->update('primary', $googleEventId, $event);

            $plan->users()->updateExistingPivot($user->id, [
                'synced_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Error al actualizar evento para usuario {$user->id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar evento del calendario de un usuario específico
     */
    public static function deleteEventForUser(User $user, Plans $plan)
    {
        $googleEventId = $plan->getGoogleEventIdForUser($user->id);

        if (!$googleEventId) {
            return true;
        }

        $client = self::getClient($user);

        if (!$client) {
            return false;
        }

        try {
            $service = new Calendar($client);
            $service->events->delete('primary', $googleEventId);

            $plan->users()->updateExistingPivot($user->id, [
                'google_event_id' => null,
                'synced_at' => null,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Error al eliminar evento para usuario {$user->id}: " . $e->getMessage());
            //si el error es un 401 quiero que igual se acutlize el pivot
            if ($e->getCode() == 401) {
                $plan->users()->updateExistingPivot($user->id, [
                    'google_event_id' => null,
                    'synced_at' => null,
                ]);
                return true;
            }

            return false;
        }
    }

    /**
     * Sincronizar todos los planes pendientes de un usuario
     */
    public static function syncAllPlansForUser(User $user)
    {
        $client = self::getClient($user);

        if (!$client) {
            return ['success' => false, 'message' => 'No se pudo conectar con Google Calendar'];
        }

        // Obtener planes del usuario que NO están sincronizados
        $plans = $user->plans()
            ->wherePivot('google_event_id', null)
            ->get();

        $synced = 0;
        $failed = 0;

        foreach ($plans as $plan) {
            if (self::addEventForUser($user, $plan)) {
                $synced++;
            } else {
                $failed++;
            }
        }

        return [
            'success' => true,
            'synced' => $synced,
            'failed' => $failed,
            'total' => $plans->count()
        ];
    }

    /**
     * Sincronizar plan para TODOS los usuarios participantes
     */
    public function syncPlanForAllUsers(Plans $plan)
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'skipped' => 0
        ];

        foreach ($plan->users as $user) {
            // Solo sincronizar si el usuario tiene Google Calendar conectado
            if (!$user->hasGoogleCalendar()) {
                $results['skipped']++;
                continue;
            }

            // Solo sincronizar si aún no está sincronizado
            if ($plan->isSyncedForUser($user->id)) {
                $results['skipped']++;
                continue;
            }

            if ($this->addEventForUser($user, $plan)) {
                $results['success']++;
            } else {
                $results['failed']++;
            }
        }

        return $results;
    }

    //Sincronizar un plan existente
    public function syncPLanForUser(User $user, Plans $plan)
    {
        // Solo sincronizar si el usuario tiene Google Calendar conectado
        if (!$user->hasGoogleCalendar()) {
            return false;
        }

        // Solo sincronizar si aún no está sincronizado
        if ($plan->isSyncedForUser($user->id)) {
            return false;
        }

        return $this->addEventForUser($user, $plan);
    }
}
