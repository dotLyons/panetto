<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RaffleEntry;

class RaffleForm extends Component
{
    // Campos del formulario
    public $dni;
    public $last_name;
    public $name;
    public $phone;
    public $table_number; // Nombre correcto (Mesa)
    public $visit_hour;
    public $visit_minute;
    public $rating = 5;

    public $submitted = false;

    protected $rules = [
        'dni' => 'required|numeric|digits_between:7,9',
        'last_name' => 'required|min:2',
        'name' => 'required|min:2',
        'phone' => 'required|numeric|min_digits:8',
        'table_number' => 'required', // Validamos que pongan la mesa
        'visit_hour' => 'nullable|integer|min:0|max:23',
        'visit_minute' => 'nullable|integer|min:0|max:59',
        'rating' => 'required|integer|min:1|max:5',
    ];

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function save()
    {
        $this->validate();

        // Construir hora formateada (Ej: 14:30)
        $visit_time = null;
        if ($this->visit_hour !== null && $this->visit_minute !== null && $this->visit_hour !== '' && $this->visit_minute !== '') {
            $visit_time = sprintf('%02d:%02d', (int)$this->visit_hour, (int)$this->visit_minute);
        }

        RaffleEntry::create([
            'dni' => $this->dni,
            'last_name' => $this->last_name,
            'name' => $this->name,
            'phone' => $this->phone,
            'table_number' => $this->table_number, // Guardamos Mesa
            'visit_time' => $visit_time,           // Guardamos Hora
            'rating' => $this->rating,
        ]);

        $this->submitted = true;
        $this->reset(['dni', 'last_name', 'name', 'phone', 'table_number', 'visit_hour', 'visit_minute', 'rating']);
    }

    public function render()
    {
        return view('livewire.raffle-form');
    }
}
