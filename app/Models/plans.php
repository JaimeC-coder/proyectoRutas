<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class plans extends Model
{

    protected $table = 'plans';

    protected $fillable = [
        'name',
        'date',
        'time_out',
        'meeting_place',
        'description',
        'difficulty',
        'observations',
        'user_id',
    ];

    // Creador del plan
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Usuarios que participan en el plan
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_plans', 'plan_id', 'user_id')
            ->withPivot('status', 'role')
            ->withTimestamps();
    }
}
