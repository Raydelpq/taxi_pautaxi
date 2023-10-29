<?php

namespace App\Http\Livewire\Sidebar;

use App\Models\Viaje;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MisViajes extends Component
{
    public $pendiente = false;

    public function mount(){
        $user = Auth::user();

        if(!$user->hasRole('Taxista'))
            $this->pendiente = Viaje::where('comercial_id',$user->id)->where('taxista_id',null)->count() > 0 ? true : false;  
            
    }

    public function render()
    {
        return view('livewire.sidebar.mis-viajes');
    }
}
