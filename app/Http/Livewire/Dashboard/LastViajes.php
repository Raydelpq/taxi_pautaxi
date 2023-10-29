<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Viaje;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LastViajes extends Component
{
    
    public $star, $end;

    public function render()
    {   
        $user = Auth::user();

        $build = null;
        if(Auth::user()->hasRole('Administrador'))
            $build = Viaje::orderBy('created_at','Desc'); 
        else
        if(Auth::user()->hasRole('Comercial')){
            $build = Viaje::orderBy('created_at','Desc')->where('comercial_id',$user->id);
        }else
        if(Auth::user()->hasRole('Taxista')){
            $build = Viaje::orderBy('created_at','Desc')->where('taxista_id',$user->taxista->id);
        }

        if($this->star != null)
            $build->whereBetween('created_at',[$this->star." 00:00:00",$this->end." 23:59:59"]);

        $viajes = $build->get()->take(5);

        return view('livewire.dashboard.last-viajes',['viajes' => $viajes]);
    }
}
