<?php

namespace App\Http\Livewire\Taxista;

use App\Models\Taxista;
use Livewire\Component;
use Livewire\WithPagination;

class RegistroFondo extends Component
{   
    use WithPagination;

    public Taxista $taxista;

    protected $listeners = ['reload'];

    public function render()
    {   
        $fondos = $this->taxista->fondos()->paginate(10); 
        
        return view('livewire.taxista.registro-fondo',['fondos' => $fondos]); 
    }

    public function reload(){
        $this->render();
    }
}
