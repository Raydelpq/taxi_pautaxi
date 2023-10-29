<?php

namespace App\Http\Livewire\Empleado;

use App\Models\User;
use Livewire\Component;
use App\Models\Comercial;
use App\Models\Administrador;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class Informacion extends Component
{
    public User $user;
    public $comercial;

    public $rol;

    public function rules(){
        return [
            'user.name' => 'required',
            'user.apellidos' => 'required',
            'user.telefono' => 'required|unique:users,telefono,'.$this->user->id,
            'user.email' => 'required|email|unique:users,email,'.$this->user->id,
            'comercial.salario_fijo' => '',
            'comercial.porciento_viaje' => '',
        ];
    }

    protected $validationAttributes = [

        'user.name' => 'nombre',
        'user.telefono' => "teléfono",
        'user.email' => "correo",
        'comercial.salario_fijo' => 'salario fijo',
        'comercial.porciento_viaje' => 'porciento de viaje',

    ];

    public function mount(){

        $this->rol = $this->user->roles()->first()->name;

        if($this->rol == 'Administrador')
            $this->comercial = Administrador::where('user_id',$this->user->id)->first();
        else
        if($this->rol == 'Comercial')
            $this->comercial = Comercial::where('user_id',$this->user->id)->first();
        
    }

    public function render()
    {   
        $roles = Role::where('name','<>','Taxista')->get();

        return view('livewire.empleado.informacion',['roles' => $roles]);
    }

    public function change(){
        $this->validate();

        if(Auth::user()->hasRole('Administrador')){
            $currentRol = $this->user->roles()->first()->name;
            if($currentRol != $this->rol)
            $this->user->removeRole($this->rol);
            $this->user->assignRole($currentRol); 
        }

        if($this->comercial->salario_fijo != '')
        $this->validate([
            'comercial.salario_fijo' => 'numeric',
        ]);

        if($this->comercial->porciento_viaje != '')
        $this->validate([
            'comercial.porciento_viaje' => 'numeric|max:50',
        ]);
       
        
        $this->user->update();
        $this->comercial->update();

        $this->emitUp('updateData');
        $this->emit('message',"Informacion Actualizada",'success');
    }
}
