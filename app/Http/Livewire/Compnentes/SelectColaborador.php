<?php

namespace App\Http\Livewire\Compnentes;

use Livewire\Component;

use App\Models\Colaboracion;

class SelectColaborador extends Component
{
    public $colaborador_id;

    protected $queryString = ['colaborador_id' => ['except' => '']];

    public function render()
    {
        return view('livewire.compnentes.select-colaborador',['colaboradores' => Colaboracion::all()]);
    }

    public function change(){
        $this->emit('reload',$this->colaborador_id);
    }
}
