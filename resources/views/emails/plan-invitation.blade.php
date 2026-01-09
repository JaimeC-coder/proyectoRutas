<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4F46E5; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .button { display: inline-block; padding: 12px 24px; background: #4F46E5; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .details { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Has sido invitado a un plan!</h1>
        </div>
        <div class="content">
            <p>Hola,</p>
            <p><strong>{{ $inviterName }}</strong> te ha invitado a participar en el siguiente plan:</p>

            <div class="details">
                <h2>{{ $plan->name }}</h2>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($plan->date)->format('d/m/Y') }}</p>
                <p><strong>Hora:</strong> {{ $plan->time_out }}</p>
                <p><strong>Lugar de encuentro:</strong> {{ $plan->meeting_place }}</p>
                @if($plan->description)
                    <p><strong>Descripción:</strong> {{ $plan->description }}</p>
                @endif
                @if($plan->difficulty)
                    <p><strong>Dificultad:</strong> {{ ucfirst($plan->difficulty) }}</p>
                @endif
            </div>

            <p>Tu rol en este plan será: <strong>{{ $invitation->role === 'guest' ? 'Invitado' : 'Editor' }}</strong></p>

            <a href="{{ route('invitation.accept', $invitation->token) }}" class="button">
                Aceptar Invitación
            </a>

            <p style="font-size: 12px; color: #666; margin-top: 20px;">
                Esta invitación expirará el {{ $invitation->expires_at->format('d/m/Y') }}.
            </p>
        </div>
    </div>
</body>
</html>
