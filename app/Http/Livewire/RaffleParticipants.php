<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RaffleEntry;

class RaffleParticipants extends Component
{
    use WithPagination;

    public $perPage = 10;

    // Ganador seleccionado aleatoriamente
    public $winner = null;

    protected $paginationTheme = 'tailwind';

    public function pickWinner()
    {
        $this->winner = RaffleEntry::inRandomOrder()->first();
    }

    public function render()
    {
        $entries = RaffleEntry::orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.raffle-participants', compact('entries'));
    }
}
