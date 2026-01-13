<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'google_access_token',
        'google_refresh_token',
        'google_token_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Planes que creó el usuario
    public function createdPlans()
    {
        return $this->hasMany(Plans::class,'created_by');
    }

    // Planes en los que participa
    public function plans()
    {
        return $this->belongsToMany(Plans::class, 'user_plans', 'user_id', 'plan_id')
            ->withPivot('status', 'role')
            ->withTimestamps();
    }

    //partiendo del usuario obtener los planes que esten aceptados , rechazados o pendientes

    public function allPlans()
    {
        return $this->plans()->wherePivot('status', 'accepted')
            ->orWherePivot('status', 'pending')
            ->orWherePivot('status', 'refused');
    }

    // Verificar si tiene Google Calendar conectado
    public function hasGoogleCalendar()
    {
        return !is_null($this->google_access_token);
    }
}
