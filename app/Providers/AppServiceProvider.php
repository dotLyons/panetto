<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\RaffleParticipants;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar componente Livewire manualmente para asegurar su disponibilidad
        if (class_exists(Livewire::class) && class_exists(RaffleParticipants::class)) {
            Livewire::component('raffle-participants', RaffleParticipants::class);
        }
    }
}
