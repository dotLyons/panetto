<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalonControl extends Model
{
    protected $fillable = [
        'branch',
        'location_id',
        'shift',
        'date',
        'manager',
        'time_1',
        'time_2',
        'time_3',
        'time_4',
        'items_data',
        'general_observations',
        'signature',
    ];

    protected $casts = [
        'items_data' => 'array',
        'date' => 'date',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
