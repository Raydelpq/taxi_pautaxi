<?php

namespace App\Http\Livewire\Economia;

use App\Models\Gasto;
use App\Models\Cierre;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Gastos extends Component
{

    public $lastCierre;

    public Gasto $gasto;

    protected $listeners = ['delete'];

    public $rules = [
        'gasto.name' => 'required|min:3',
        'gasto.valor' => 'required|numeric',
        'gasto.fijo' => '',
    ];

    public function mount(){
        $this->gasto = new Gasto();
    }

    public function resetInput(){
        $this->gasto = new Gasto();
    }

    public function render()
    {   
        
        if($this->lastCierre != null)
            $gastos = Gasto::where('fijo',true)->orWhereDate('created_at','>',$this->lastCierre->end)->get();
        else
            $gastos = Gasto::get();

        return view('livewire.economia.gastos',['gastos' => $gastos]);
    }

    public function save(){
        $this->validate();

        $this->gasto->user_id = Auth::user()->id;

        if($this->gasto->fijo)
            $this->gasto->fijo = true;
        else
            $this->gasto->fijo = false;

        if($this->gasto->id == null){
            $this->gasto->save();
            $this->emit('message','Gasto Agregado','success');
        }else{
            $this->gasto->update();
            $this->emit('message','Gasto Actualizado','success');
        }

        $this->resetInput();
        $this->emit('closeAdd');
    }

    public function edit(Gasto $gasto){
        $this->gasto = $gasto;
        $this->emit('edit');
    }

    public function delete($id){

        Gasto::find($id)->delete();
        $this->emit('message','Gasto Eliminado','success');

    }
}
