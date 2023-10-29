<?php

namespace App\Http\Livewire\Colaboracion;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\Colaboracion as Colaborador;

class Colaboracion extends Component
{
    use WithPagination;

    public Colaborador $colaborador;

    protected $rules = [
        'colaborador.name' => 'required'
    ];

    protected $messages = [
        'colaborador.tag' => 'Esta Agencia ya fue Agregada'
    ];

    public function mount(){
        $this->colaborador = new Colaborador();
    }

    public function render()
    {   
        $colaboradores = Colaborador::paginate(20);

        return view('livewire.colaboracion.colaboracion',['colaboradores' => $colaboradores])->layoutData(['titulo'=>'Colaboradores']);
    }

    public function resetInput(){
        $this->colaborador = new Colaborador();
    }

    public function save(){
        $this->validate();

        $this->colaborador->tag = Str::slug($this->colaborador->name);

        $this->validate(['colaborador.tag' => 'required|unique:colaboracions,tag']);

        if($this->colaborador->id == null){
            $this->colaborador->save();
            $this->emit('message','Colaborador Editado','success');
        }else{
            $this->colaborador->update();
            $this->emit('message','Colaborador Agregado','success');
        }

        $this->resetInput();
        $this->emit('closeAdd');
    }


    public function edit(Colaborador $c){
        $this->colaborador = $c;
        $this->emit('edit');
    }

    public function delete(Colaborador $c){
        $c->delete();
        $this->emit('message','Colaborador Eliminado','success');
    }
}
