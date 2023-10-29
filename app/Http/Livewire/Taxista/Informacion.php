<?php

namespace App\Http\Livewire\Taxista;

use App\Models\User;
use App\Models\Cambio;
use App\Models\Taxista;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Informacion extends Component
{
    public User $user;
    public Taxista $taxista;

    public function rules(){
        return [
            'user.name' => 'required',
            'user.apellidos' => 'required',
            'user.telefono' => 'required|unique:users,telefono,'.$this->user->id,
            'user.email' => '',
            'taxista.descuento' => ''
        ];
    }

    protected $validationAttributes = [

        'user.name' => 'nombre',
        'user.telefono' => "teléfono",
        'user.email' => "correo",

    ];

    public function render()
    {
        return view('livewire.taxista.informacion');
    }

    public function change(){
        
        $this->validate();

        if($this->user->email != '' && $this->user->email != null){
            $this->validate(['user.email' => 'email|unique:users,email,'.$this->user->id]);
            
        }else
        $this->user->email = null;
        
        if(Auth::user()->hasRole('Administrador') && $this->taxista->descuento > 0){
            $this->validate(['taxista.descuento' => 'numeric']);
            
        }else
            $this->taxista->descuento = 0.00; 

        $userOriginal = User::find($this->user->id);

        if(Auth::user()->id == $this->user->id){

            if($userOriginal->name != $this->user->name){
                $cambio = new Cambio();
                $cambio->taxista_id = $this->user->taxista->id;
                $cambio->campo = 'name';
                $cambio->valor = $this->user->name;
                $cambio->save();
            }

            if($userOriginal->apellidos != $this->user->apellidos){
                $cambio = new Cambio();
                $cambio->taxista_id = $this->user->taxista->id;
                $cambio->campo = 'apellidos';
                $cambio->valor = $this->user->apellidos;
                $cambio->save();
            }

            if($userOriginal->telefono != $this->user->telefono){
                $cambio = new Cambio();
                $cambio->taxista_id = $this->user->taxista->id;
                $cambio->campo = 'telefono';
                $cambio->valor = $this->user->telefono;
                $cambio->save();
            }
        }else{
            $this->user->update();
            $this->taxista->update();
        }

        $this->emitUp('updateData');
        $this->emit('message',"Informacion en Proceso de Actualización. Debe esperar a que sea aprobada",'success',5000);
    }
}
