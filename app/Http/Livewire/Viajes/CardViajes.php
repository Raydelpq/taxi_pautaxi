<?php

namespace App\Http\Livewire\Viajes;

use Livewire\Component;

class CardViajes extends Component
{
    public $viaje;

    public function render()
    {
        return view('livewire.viajes.card-viajes');
    }
}
