<?php

namespace App\Http\Livewire\Configuracion;

use App\Models\Opcion;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Opciones extends Component
{   
    public $search;

    public $verify = false;
    public $password = '';

    public function render()
    {
        if($this->search == "")
            $opciones = Opcion::get();
        else
            $opciones = Opcion::where('label','LIKE',"%{$this->search}%")->get();

        return view('livewire.configuracion.opciones',['opciones' => $opciones])->layoutData(['titulo' => "Configuraciones"]);
    }

    public function save($id,$valor){

        $op = Opcion::find($id);
        $op->valor = $valor;
        $op->update();
        $this->emit("endSave{$id}");
        $this->emit('message',"({$op->label})\n Guardado",'success');
    }

    public function verificar(){
        $this->validate(['password' => 'required']);
        $p = Auth::user()->password;
        
        if( Hash::check($this->password, $p) ){
            $this->verify = true;
            $this->emit('message','Autorizo Concedido','success');
        }else
        $this->emit('message','Autorizo Denegado','warning');
    }
}
