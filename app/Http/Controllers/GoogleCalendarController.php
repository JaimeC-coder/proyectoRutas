<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Calendar;
use Illuminate\Support\Facades\Log;

class GoogleCalendarController extends Controller
{
    private function getClient()
    {
        $clientId = config('google-calendar.client_id');
        $clientSecret = config('google-calendar.client_secret');
        $redirectUri = config('google-calendar.redirect_uri');

        // Validar que existan las credenciales
        if (empty($clientId) || empty($clientSecret) || empty($redirectUri)) {
            throw new \Exception('Las credenciales de Google Calendar no están configuradas correctamente. Por favor verifica tu archivo .env');
        }

        $client = new Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope(Calendar::CALENDAR);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return $client;
    }

    public function redirectToGoogle()
    {
        try {
            $client = $this->getClient();
            $authUrl = $client->createAuthUrl();
            Log::error('entro1: ');
            return redirect($authUrl);
        } catch (\Exception $e) {
            Log::error('Google Calendar Redirect Error: ' . $e->getMessage());
            return redirect('admin/dashboard')->with('error', $e->getMessage());
        }
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $client = $this->getClient();

            if ($request->has('code')) {
                $token = $client->fetchAccessTokenWithAuthCode($request->code);

                if (isset($token['error'])) {
                    return redirect('/dashboard')->with('error', 'Error al conectar con Google Calendar: ' . $token['error']);
                }

                $user = auth()->user();
                Log::info('User ID: ' . $user->id);


                $user->update([
                    'google_access_token' => $token['access_token'],
                    'google_refresh_token' => $token['refresh_token'] ?? null,
                    'google_token_expires_at' => now()->addSeconds($token['expires_in']),
                ]);



                Log::error('entro: ');
                return redirect('admin/dashboard')->with('success', '¡Google Calendar conectado exitosamente!');
            }

            return redirect('admin/dashboard')->with('error', 'No se recibió código de autorización');
        } catch (\Exception $e) {
            Log::error('Google Calendar Callback Error: ' . $e->getMessage());
            return redirect('admin/dashboard')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function disconnect()
    {
        $user = auth()->user();
        $user->update([
            'google_access_token' => null,
            'google_refresh_token' => null,
            'google_token_expires_at' => null,
        ]);

        Log::error('entro3: ');

        return redirect('admin/dashboard')->with('success', 'Google Calendar desconectado');
    }
}
