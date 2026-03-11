<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class SalonControlForm extends Component
{
    public $location_id = '';
    public $branch = '';
    public $shift = '';
    public $date = '';
    public $manager = '';
    public $time_1 = '';
    public $time_2 = '';
    public $time_3 = '';
    public $time_4 = '';
    public $items_data = [];
    public $general_observations = '';
    public $signature = '';
    public $previewMode = false;
    public $savedId = null;
    public $timestampText = '';
    public $controlId = null;

    public function mount($controlId = null)
    {
        $this->controlId = $controlId;

        $user = Auth::user();

        // Si nos pasan un controlId, cargamos ese registro en modo readonly
        if ($controlId) {
            $control = \App\Models\SalonControl::find($controlId);
            if ($control) {
                $this->savedId = $control->id;
                $this->location_id = $control->location_id;
                $this->branch = $control->branch;
                $this->shift = $control->shift;
                $this->date = $control->date;
                $this->manager = $control->manager;

                $itemsData = is_array($control->items_data) ? $control->items_data : json_decode($control->items_data, true);
                if ($itemsData) {
                    // Ordenar secciones por el número al inicio del nombre (1 - ..., 2 - ..., etc.)
                    uksort($itemsData, function ($a, $b) {
                        return intval($a) - intval($b);
                    });
                    $this->items_data = $itemsData;
                } else {
                    $this->initItemsData();
                }

                $this->general_observations = $control->general_observations ?? '';
                $this->signature = $control->signature ?? '';
                $this->timestampText = $control->created_at->setTimezone('America/Argentina/Buenos_Aires')->format('d/m/Y - H:i') . ' hs';
                $this->previewMode = true;
                return; // no seguir con la lógica de "nuevo"
            }
        }

        // Modo nuevo reporte
        $this->timestampText = now()->setTimezone('America/Argentina/Buenos_Aires')->format('d/m/Y - H:i') . ' hs';

        if ($user) {
            $locationId = $user->location_id ?? session('admin_location_id');
            if ($locationId) {
                $this->location_id = $locationId;
                $location = \App\Models\Location::find($locationId);
                $this->branch = $location ? $location->name : '';
            }
            $this->manager = $user->name;
        }

        $this->initItemsData();
    }

    public function setRating($section, $item, $rating)
    {
        $this->items_data[$section][$item]['rating'] = $rating;
    }

    protected function initItemsData()
    {
        $structure = [
            '1 - Limpieza y Orden' => [
                'Mesas limpias', 'Sillas ordenadas', 'Piso limpio', 'Vereda limpia y ordenada', 'Baños en buen estado', 'Heladeras limpias',
            ],
            '2 - Mise en Place' => [
                'Alcuceros limpios', 'Cubiertos y vasos fajinados', 'Servilletas correctas', 'Tazas y platos limpios', 'Carta menú en buen estado',
            ],
            '3 - Bebidas' => [
                'Bebidas ordenadas en heladeras', 'Bebida correctamente fría', 'Heladeras limpias y funcionando',
            ],
            '4 - Ambiente del Local' => [
                'Iluminación correcta', 'Música ambiente adecuada', 'Pantallas con promociones activas',
            ],
            '5 - Personal' => [
                'Uniforme correcto', 'Buena presencia', 'Actitud amable con los clientes', 'Rapidez en la atención',
            ],
            '6 - Control de Baños' => [
                'Limpieza general', 'Papel higiénico', 'Jabón', 'Buen olor',
            ],
        ];

        foreach ($structure as $section => $items) {
            foreach ($items as $item) {
                $this->items_data[$section][$item] = [
                    'rating' => 0,
                    'obs' => ''
                ];
            }
        }
    }

    public function saveAndPreview()
    {
        $this->validate([
            'shift' => 'required',
        ]);

        if (!$this->location_id) {
            $this->addError('location_id', 'La sucursal no pudo ser identificada para este usuario.');
            return;
        }

        $this->date = now()->setTimezone('America/Argentina/Buenos_Aires')->toDateString();

        $data = [
            'location_id' => $this->location_id,
            'branch' => $this->branch,
            'shift' => $this->shift,
            'date' => $this->date,
            'manager' => $this->manager,
            'time_1' => $this->time_1 ?: null,
            'time_2' => $this->time_2 ?: null,
            'time_3' => $this->time_3 ?: null,
            'time_4' => $this->time_4 ?: null,
            'items_data' => $this->items_data,
            'general_observations' => $this->general_observations,
            'signature' => $this->manager,
        ];

        if ($this->savedId) {
            $control = \App\Models\SalonControl::find($this->savedId);
            $control->update($data);
        } else {
            $control = \App\Models\SalonControl::create($data);
            $this->savedId = $control->id;
            $this->timestampText = $control->created_at->setTimezone('America/Argentina/Buenos_Aires')->format('d/m/Y - H:i') . ' hs';
        }

        $this->previewMode = true;

        $this->dispatch('salon-control-saved');
    }

    public function edit()
    {
        $this->previewMode = false;
    }

    public function render()
    {
        $locations = \App\Models\Location::all();
        return view('livewire.salon-control-form', compact('locations'))->layout('layouts.app');
    }
}
