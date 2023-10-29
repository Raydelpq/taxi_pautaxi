<?php

namespace App\Http\Livewire\Configuracion\Horario;

use Livewire\Component;
use App\Models\RowHorario;
use App\Models\Horario as Model;

class Horario extends Component
{
    public Model $horario;

    public $auto = null;
    public $autos = ['Estándar','5 Plazas', 'Microbus', 'Microbus+'];

    public $rows;

    protected $rules = [
        'rows.*' => 'required',
    ];

    public function mount(){
        $this->horario = new Model();

        $this->rows['Estándar'] = [];
        $this->rows['5 Plazas'] = [];
        $this->rows['Microbus'] = [];
        $this->rows['Microbus+'] = [];
    }

    public function render()
    {
        $horarios = Model::all();
        return view('livewire.configuracion.horario.horario', compact('horarios')); 
    }

    public function setHorario(Model $horario){
        $this->horario = $horario;
    }

    public function setAuto($auto){
        $this->auto = $auto;
    }

    public function getHorario($a){
        $rows = RowHorario::where('horario_id',$this->horario->id)->where('auto',$a)->get()->toArray();

        foreach($rows as $r){
            //$this->rows[$a]
        }
    }
}
