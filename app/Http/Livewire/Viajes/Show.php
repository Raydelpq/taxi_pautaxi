<?php

namespace App\Http\Livewire\Viajes;

use App\Models\Viaje;
use Livewire\Component;

class Show extends Component
{
    public Viaje $viaje;

    public function mount($id){
        $this->viaje = Viaje::findOrFail($id);

       // dd($this->viaje->comercial->name);
    }

    public function render()
    {
        return view('livewire.viajes.show')->layout('layouts.app',['titulo'=>'Moatrar Viaje']);
    }
}
