<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyEntry extends Model
{
    protected $fillable = [
        'dni', 'last_name', 'name', 'phone', 'email', 'visit_time',
        'brings_kids', 'kids_ages', 'useful_play_area', 'visit_more_often'
    ];

    protected $casts = [
        'kids_ages' => 'array',
    ];
}
