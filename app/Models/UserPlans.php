<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlans extends Model
{
    protected $table = 'user_plans';

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'role',
        'google_event_id',
        'synced_at'
    ];
}
