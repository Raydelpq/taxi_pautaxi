<?php

namespace App\Http\Livewire\Horarios;

use App\Models\Horario;
use App\Models\Auto;
use App\Models\AutoHorario;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Horarios extends Component
{
    use WithPagination;

    public Horario $horario;
    public $horarios;
    public Auto $auto;
    public $autos;

    public $km;
    public $minimo;

    public function rules() {

        return  [
            'horario.name' => 'required',
            'horario.inicio' => 'required|date_format:H:i',
            'horario.fin' => 'required|date_format:H:i|after:horario.inicio',
            'auto.name' => '',
            //'auto.precio_min' => '',
            'km.*.value' => '',
            'minimo.*.value' => ''
        ];

    }

    protected $messages = [
        'horario.fin.after' => 'El campo fin debe ser una hora superior a la de Inicio.',
    ];

    protected $validationAttributes = [
        'auto.name' => 'nombre'
    ];

    public function mount(){
        $this->horario = new Horario();
        $this->horarios = Horario::get();
        $this->auto = new Auto();
        $this->autos = Auto::get();
        $this->horario->inicio = '00:00';
        $this->horario->fin = '00:00';
        $this->km = [];
        $this->minimo = [];
    }

    public function render()
    {   
        return view('livewire.horarios.horarios',['horarios' => $this->horarios, 'autos' => $this->autos])->layoutData(['titulo'=>'Horarios y Autos']);
    }

    public function resetInput(){
        $this->horario = new Horario();
        $this->horario->inicio = '00:00';
        $this->horario->fin = '00:00';
    }

    public function resetInputAuto(){
        $this->auto = new Auto();
        $this->km= [];
        $this->minimo= [];
    }

    // Guardar Horario
    public function save(){
        $this->validate();

        $this->horario->inicio .= ':00';
        $this->horario->fin .= ':59';
        $this->horario->save();

        $this->resetInput();
        $this->render();
        $this->emit('closeAdd_H');
        $this->emit('message',"Horario Actualizado",'success');
    }

    // Guardar Auto
    public function saveAuto(){
        $this->validate([
            'auto.name' => 'required',
            //'auto.*.value' => 'required|numeric',
            //'km' => 'required|array',
        ]);
        
        //dd($this->km,$this->minimo);

        //validar km de horarios
        if(count($this->km) != count($this->horarios) ){
            $this->emit('message','Debe Agregar el valor de los kms en cada Horario','warning');
            return null;
        }

        if(count($this->minimo) != count($this->minimo) ){
            $this->emit('message','Debe completar los precios mínimos en cada horario','warning');
            return null;
        }

        if($this->auto->id == null)
            $update = false;
        else
            $update = true;
        
        if(!$update)
            $this->auto->save();
        else
            $this->auto->update();

        foreach($this->km as $key => $km){

            foreach($km as $horario_id => $k){
                
                if(!$update){
                    $autoH = new AutoHorario();
                    $autoH->auto_id = $this->auto->id;
                    $autoH->horario_id = $horario_id;
                    $autoH->km = $k;
                    $autoH->minimo = $this->minimo[$key][$horario_id];
                    $autoH->save();
                }else{
                    $autoH = AutoHorario::where('auto_id',$this->auto->id)->where('horario_id',$horario_id)->first();
                    $autoH->km = $k;
                    $autoH->minimo = $this->minimo[$key][$horario_id];
                    $autoH->update();
                }
            }

        }

        $this->resetInputAuto();
        $this->render();
        $this->emit('closeAdd_A');
        $this->emit('message',"Auto Guardado",'success');
    }

    public function edit(Horario $c){
        $this->horario = $c;
        $this->render();
        $this->emit('edit_H');
        //$this->emit('message',"Horario ({$c->name}) Actualizado",'success');
    }

    public function delete(Horario $c){
        $c->delete();
        $this->render();
        $this->emit('message','Horario Eliminada','success');
    }

    public function editAuto(Auto $c){
        $this->auto = $c;
        $this->km = [];
        foreach($this->auto->horarios as $index => $km){
            $this->km[$index][$km->pivot->horario_id] =  $km->pivot->km;
            $this->minimo[$index][$km->pivot->horario_id] =  $km->pivot->minimo;
        }
        $this->render();
        $this->emit('edit_A');
        //$this->emit('message',"Auto ({$c->name}) Actualizado",'success');
    }

    public function deleteAuto(Auto $c){
        $c->delete();
        $this->render();
        $this->emit('message','Auto Eliminada','success');
    }
}
