<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaffleEntry extends Model
{
    protected $fillable = [
        'dni', 
        'last_name', 
        'name', 
        'phone', 
        'ticket_number', 
        'rating'
    ];
}