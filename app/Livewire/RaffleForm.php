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
    public $ticket_number;
    public $rating = 5; // Valor por defecto

    // Estado de éxito
    public $submitted = false;

    // Reglas de validación
    protected $rules = [
        'dni' => 'required|numeric|digits_between:7,9',
        'last_name' => 'required|min:2',
        'name' => 'required|min:2',
        'phone' => 'required|numeric|min_digits:8',
        'ticket_number' => 'required',
        'rating' => 'required|integer|min:1|max:5',
    ];

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function save()
    {
        $this->validate();

        // Opcional: Verificar si el ticket ya fue cargado para evitar duplicados
        if(RaffleEntry::where('ticket_number', $this->ticket_number)->exists()) {
            $this->addError('ticket_number', 'Este ticket ya fue registrado.');
            return;
        }

        RaffleEntry::create([
            'dni' => $this->dni,
            'last_name' => $this->last_name,
            'name' => $this->name,
            'phone' => $this->phone,
            'ticket_number' => $this->ticket_number,
            'rating' => $this->rating,
        ]);

        $this->submitted = true;
        $this->reset(['dni', 'last_name', 'name', 'phone', 'ticket_number', 'rating']);
    }

    public function render()
    {
        return view('livewire.raffle-form');
    }
}