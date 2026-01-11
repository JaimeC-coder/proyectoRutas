<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WhatsAppHelper
{
    public static function confirmationInvitation($usuario, $invitado, $plan, $numeroDestino)
    {


        $text = "Hola" . $usuario . ", el usuario " . $invitado . " aceptado unirse al plan:  " . $plan . ".";

        self::enviarMensaje($text, $numeroDestino);

        return true;
    }

    public static function cuestionInvitation($usuario, $invitado, $plan, $numeroDestino)
    {
        $text = "Hola" . $invitado . ", el usuario " . $usuario . " te ha enviado una invitación para unirte al plan:  " . $plan . ". \nPor favor, ingrese a la web para acepta o rechaza la invitación.";

        self::enviarMensaje($text, $numeroDestino);

        return true;
    }





    public static function enviarMensaje($mensaje, $numeroDestino)
    {

        $apiKey = '2426432';

        $url = "https://api.callmebot.com/whatsapp.php";

        HTTP::get($url, [
            'phone' => $numeroDestino,
            'text' => $mensaje,
            'apikey' => $apiKey,
        ]);
    }
}
