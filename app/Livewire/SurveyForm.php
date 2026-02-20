<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SurveyEntry;

class SurveyForm extends Component
{
    public $dni;
    public $last_name;
    public $name;
    public $phone;
    public $email;
    public $visit_hour;
    public $visit_minute;

    public $brings_kids;
    public $kids_ages = [];
    public $useful_play_area;
    public $visit_more_often;

    public $submitted = false;

    protected $rules = [
        'dni' => 'required|numeric|digits_between:7,9',
        'last_name' => 'required|min:2',
        'name' => 'required|min:2',
        'phone' => 'required|numeric|min_digits:8',
        'email' => 'required|email',
        'visit_hour' => 'nullable|integer|min:0|max:23',
        'visit_minute' => 'nullable|integer|min:0|max:59',
        'brings_kids' => 'required',
        'kids_ages' => 'nullable|array',
        'useful_play_area' => 'required',
        'visit_more_often' => 'required',
    ];

    public function mount()
    {
        if (session()->has('survey_google_user')) {
            $user = session('survey_google_user');

            $this->email = $user['email'];

            $partesNombre = explode(' ', $user['name'], 2);
            $this->name = $partesNombre[0] ?? '';
            $this->last_name = $partesNombre[1] ?? '';
        }
    }

    public function save()
    {
        $this->validate();

        $visit_time = null;
        if ($this->visit_hour !== null && $this->visit_minute !== null && $this->visit_hour !== '' && $this->visit_minute !== '') {
            $visit_time = sprintf('%02d:%02d', (int)$this->visit_hour, (int)$this->visit_minute);
        }

        SurveyEntry::create([
            'dni' => $this->dni,
            'last_name' => $this->last_name,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'visit_time' => $visit_time,
            'brings_kids' => $this->brings_kids,
            'kids_ages' => $this->kids_ages,
            'useful_play_area' => $this->useful_play_area,
            'visit_more_often' => $this->visit_more_often,
        ]);

        $this->submitted = true;

        $this->reset(['dni', 'last_name', 'name', 'phone', 'visit_hour', 'visit_minute', 'brings_kids', 'kids_ages', 'useful_play_area', 'visit_more_often']);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.survey-form');
    }
}
