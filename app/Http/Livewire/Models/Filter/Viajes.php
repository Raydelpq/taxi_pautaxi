<?php

namespace App\Http\Livewire\Models\Filter;

use App\Models\Taxista;
use Livewire\Component;
use App\Models\Comercial;
use App\Models\Administrador;

class Viajes extends Component
{   
    public $modo;
    public $data;

    public $global = true;
    public $tipo_usuario;
    public $user_id;

    public $selected = false;

    protected $listeners= ['setFilter'];

    public function mount(){
        $this->modo = '';
        $this->data = date('Y-m-d');
        $this->tipo_usuario = null;
        $this->user_id = null;
    }

    public function render()
    {
        return view('livewire.models.filter.viajes');
    }

    public function filtrar(){  
        
        if($this->global)
            return redirect()->route('viajes.list',['modo' => $this->modo,'data' => $this->data,'global' => $this->global] );

        return redirect()->route('viajes.list',['modo' => $this->modo,'data' => $this->data,'global' => $this->global,'tipo_usuario' => $this->tipo_usuario, 'user_id' => $this->user_id] );

    }

    private function resetValues(){
        $this->global = true;
        $this->modo = '';
        $this->data = '';
        $this->tipo_usuario = null;
        $this->user_id = null;
    }

    // Modifica valores para filtra los viajes
    public function setFilter($global,$tipo_usuario = null,$user_id = null,$selected = false){

        $this->global = $global;
        if(!$global){
            $this->tipo_usuario = $tipo_usuario;

            if($tipo_usuario == 'Comercial')
                //$this->user_id = Comercial::where('user_id',$user_id)->first()->id;
                $this->user_id = $user_id;
            else 
            if($tipo_usuario == 'Administrador')
                //$this->user_id = Administrador::where('user_id',$user_id)->first()->id;
                $this->user_id = $user_id;
            else
                //$this->user_id = Taxista::where('user_id',$user_id)->first()->id;
                $this->user_id = $user_id;
            

            $this->selected = true;
        }

    }
}
