<?php

namespace App\Http\Livewire\Empleado;

use App\Models\User;
use Livewire\Component;
use App\Models\Comercial;
use App\Models\Administrador;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class CrearEmpleado extends Component
{   
    use WithFileUploads;
    
    public $avatar;
    public $avatarUrl;

    public $type = null;

    public $title = "Crear Empleado";

    public User $user;
    public $comercial;

    public $password;
    public $password_confirmation;

    public function mount(){
        $this->user = new user(); 

        if($this->user->getMedia('avatar')->first())
            $this->avatarUrl = $this->user->getMedia('avatar')->first()->getFullUrl();
        else
            $this->avatarUrl = asset('img/no-avatar.png');
    }

    public function rules(){
        return [
            'avatar' => 'required|mimes:jpg,png',
            'user.name' => 'required',
            'user.apellidos' => 'required',
            'user.telefono' => 'required|unique:users,telefono',
            'user.email' => 'email|unique:users,email',
            'comercial.salario_fijo' => '',
            'comercial.porciento_viaje' => '',
            'password'       => 'required|min:6',
            'password_confirmation'  => 'required_with:password|same:password',
        ];
    }

    protected $validationAttributes = [

        'avatar' => 'foto de perfil',
        'user.name' => 'nombre',
        'user.telefono' => "teléfono",
        'user.email' => "correo",
        'password' => 'Contraseña',
        'password_confirmation'  => 'Confirmar Contraseña',

    ];

    public function render()
    {
        return view('livewire.empleado.crear-empleado')->layoutData(['titulo' => $this->title]); 
    }

    public function changeType($type){

        $this->type = $type;

        if($this->type == 'Comercial'){
            $this->comercial = new Comercial();
        }else
        if($this->type == 'Administrador'){
            $this->comercial = new Administrador();
        }else
            $this->comercial = null;
    }

    public function resetInput(){
        $this->type = null;
        $this->avatar = null;
        $this->avatarUrl = asset('img/no-avatar.png');
        $this->password = '';
        $this->password_confirmation = '';
        $this->comercial = null;
        $this->user = new User();
    }

    public function save(){
        $this->validate();
        
        if($this->comercial->salario_fijo != '')
            $this->validate(['comercial.salario_fijo' => 'numeric']);
        else
            $this->comercial->salario_fijo = 0;
        
        if($this->comercial->porciento_viaje != '')
            $this->validate(['comercial.porciento_viaje' => 'numeric|min:0|max:100']);
        else
            $this->comercial->porciento_viaje = 0;

        $this->user->password = Hash::make($this->password);

        $this->user->save();
        
        $this->comercial->user_id = $this->user->id;
        $this->comercial->save();

        if($this->type == 'Comercial'){
            $this->user->assignRole('Comercial');
        }else
        if($this->type == 'Administrador'){
            $this->user->assignRole('Administrador');
        }

        $this->user->addMedia($this->avatar->getRealPath())->toMediaCollection('avatar');
        $this->resetInput();

        $this->emit('message','Empleado Creado Correctamente','success');
    }
}
