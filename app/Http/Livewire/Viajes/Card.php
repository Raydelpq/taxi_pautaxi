<?php

namespace App\Http\Livewire\Viajes;

use App\Models\Viaje;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Card extends Component
{
    public Viaje $viaje; 

    protected $listeners = ['delete'];

    public function render()
    {
        return view('livewire.viajes.card');
    }

    public function delete(){
        if($this->viaje->taxista_id != null)
            $this->viaje->taxista->addSaldo($this->viaje); 
        $this->viaje->deleted_id = Auth::user()->id;
        $this->viaje->update();
        $this->viaje->delete();
        
        return redirect()->route('dashboard');
    }
}
