<?php

namespace App\Http\Livewire\Economia;

use App\Models\Ingreso;
use App\Models\Cierre;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Ingresos extends Component
{

    public $lastCierre;

    public Ingreso $ingreso;

    protected $listeners = ['delete'];

    public $rules = [
        'ingreso.name' => 'required|min:3',
        'ingreso.valor' => 'required|numeric'
    ];

    public function mount(){
        $this->ingreso = new Ingreso();
    }

    public function resetInput(){
        $this->ingreso = new Ingreso();
    }

    public function render()
    {   
        
        if($this->lastCierre != null)
            $ingresos = Ingreso::whereDate('created_at','>',$this->lastCierre->end)->get();
        else
            $ingresos = Ingreso::get();

        return view('livewire.economia.ingresos',['ingresos' => $ingresos]);
    }

    public function save(){
        $this->validate();

        $this->ingreso->user_id = Auth::user()->id;

        if($this->ingreso->id == null){
            $this->ingreso->save();
            $this->emit('message','Ingreso Agregado','success');
        }else{
            $this->ingreso->update();
            $this->emit('message','Ingreso Actualizado','success');
        }

        $this->resetInput();
        $this->emit('closeAdd');
    }

    public function edit(Ingreso $ingreso){
        $this->ingreso = $ingreso;
        $this->emit('edit');
    }

    public function delete($id){

        Ingreso::find($id)->delete();
        $this->emit('message','Ingreso Eliminado','success');

    }
}
