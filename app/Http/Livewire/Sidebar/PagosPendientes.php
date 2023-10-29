<?php

namespace App\Http\Livewire\Sidebar;

use App\Models\Taxista;
use Livewire\Component;

class PagosPendientes extends Component
{   
    public $pendiente;

    public function mount(){

        $this->pendiente = Taxista::where('fondo','<=',150)->count(); 
    }

    public function render()
    {
        return view('livewire.sidebar.pagos-pendientes');
    }
}
