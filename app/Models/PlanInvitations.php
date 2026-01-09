<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class PlanInvitations extends Model
{

    protected $fillable = [
        'plan_id',
        'email',
        'role',
        'token',
        'expires_at',
        'accepted_at'
    ];
    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function plan()
    {
        return $this->belongsTo(Plans::class);
    }

    public static function createForPlan($planId, $email, $role)
    {
        return self::create([
            'plan_id' => $planId,
            'email' => $email,
            'role' => $role,
            'token' => Str::random(64),
            'expires_at' => now()->addDays(7),
        ]);
    }

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    public function isAccepted()
    {
        return !is_null($this->accepted_at);
    }
}
