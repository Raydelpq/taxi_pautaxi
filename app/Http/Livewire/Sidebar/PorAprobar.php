<?php

namespace App\Http\Livewire\Sidebar;

use App\Models\Taxista;
use Livewire\Component;

class PorAprobar extends Component
{   
    public $aprobar;

    public function mount(){

        $this->aprobar = Taxista::where('aprobado',false)->count(); 
    }

    public function render()
    {
        return view('livewire.sidebar.por-aprobar');
    }
}
