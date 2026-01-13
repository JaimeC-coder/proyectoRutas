<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{

    protected $table = 'plans';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'time_out',
        'meeting_place',
        'description',
        'difficulty',
        'observations',
        'user_id',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Creador del plan
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getStatusAttribute()
    {
        return $this->pivot->status ?? null;
    }

    public function getRoleAttribute()
    {
        return $this->pivot->role ?? null;
    }

    // Verificar si un usuario específico tiene este plan sincronizado
    public function isSyncedForUser($userId)
    {
        $user = $this->users()->where('user_id', $userId)->first();
        return $user && !is_null($user->pivot->google_event_id);
    }

    // Obtener el google_event_id para un usuario específico
    public function getGoogleEventIdForUser($userId)
    {
        $user = $this->users()->where('user_id', $userId)->first();
        return $user ? $user->pivot->google_event_id : null;
    }

    // Verificar si el usuario es el creador
    public function isCreator($userId)
    {
        return $this->created_by == $userId;
    }

    // Scope: Planes donde el usuario participa
    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('users', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    // Scope: Planes creados por el usuario
    public function scopeCreatedBy($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    // Usuarios que participan en el plan
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_plans', 'plan_id', 'user_id')
            ->withPivot('status', 'role', 'google_event_id', 'synced_at')
            ->withTimestamps();
    }
}
