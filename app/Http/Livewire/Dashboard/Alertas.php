<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\User;
use App\Models\Taxista;
use App\Models\Cambio;
use Livewire\Component;

class Alertas extends Component
{   
    public $nuevos = false;
    public $pagos  = false;
    public $cambios  = false;


    public function mount()
    {   // Determina si hay taxistas por aprobar
        $this->nuevos = User::join('taxistas', 'users.id', '=', 'taxistas.user_id')
                            ->select('taxistas.id')
                            ->whereHas('roles',function($q){ 
                                $q->where('name','Taxista'); 
                            })->where('aprobado',false)->count() > 0 ? true: false;
        
        // Determina si hay taxistas con deudas
        $this->pagos = Taxista::where('fondo','<=',150)->count() > 0 ? true: false;

        // Determina si cambios
        $this->cambios = Cambio::get()->count() > 0 ? true: false;
    }

    public function render()
    {   
        return view('livewire.dashboard.alertas');
    }
}
