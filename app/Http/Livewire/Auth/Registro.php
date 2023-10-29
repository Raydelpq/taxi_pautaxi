<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Models\Taxista;
use Livewire\Component;
use App\Jobs\OptimizeImagen;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class Registro extends Component
{
    use WithFileUploads;
    
    public $avatar; 
    public $auto;

    public User $user;
    public Taxista $taxista;

    public $password;
    public $password_confirmation;

    public $condiciones;

    public $rules = [
        'user.name' => 'required|min:3',
        'user.apellidos' => 'required|min:6',
        'user.telefono' => 'required|unique:users,telefono', //regex:/(5)[0-9]{6}/
        'user.email' => 'required|email|unique:users,email',

        'taxista.marca' => 'required',
        'taxista.modelo' => 'required',
        'taxista.color' => 'required',
        'taxista.aire' => '',
        'taxista.lic_operativa' => '',

        'password'       => 'required|min:6',
        'password_confirmation'  => 'required_with:password|same:password',

        'avatar' => 'required|mimes:png,jpg',
        'auto' => 'required|mimes:png,jpg'
    ];

    protected $validationAttributes = [

        'user.name' => 'nombre',
        'user.telefono' => "teléfono",
        'user.email' => "correo",
        'password' => "contraseña",
        'password_confirmation' => "confirmar",

    ];

    public function mount(){
        
        $this->user = new User();
        $this->taxista = new Taxista();

        $this->taxista->aire = false;
        $this->taxista->lic_operativa = false;
        $this->condicioness = false;
    }

    public function render()
    {
        return view('livewire.auth.registro')->layout('layouts.auth');
    }

    //public function updated($only){ $this->validateOnly($only); }

    public function store(){
        $this->validate();

        $this->user->password = Hash::make($this->password);
        $this->user->save();

        $this->taxista->user_id = $this->user->id;
        $this->taxista->save();

        //$this->user = User::find(2);
        //$this->taxista = taxista::find(1);

        $this->user->assignRole('Taxista'); 
        $this->user->addMedia($this->avatar->getRealPath())->toMediaCollection('avatar');

        $this->taxista->addMedia($this->auto->getRealPath())->toMediaCollection('taxi');

        $imgAvatar = $this->user->getMedia('avatar')->first(); 
        OptimizeImagen::dispatch($imgAvatar->getPath());

        $imgTaxi = $this->taxista->getMedia('taxi')->first();
        OptimizeImagen::dispatch($imgTaxi->getPath());



        //s$this->emit('message','Usted se ha registrado correctamente','success');
        return redirect()->route('login')->with('status',"Ya fue registado, Ahora debe esperar ser Aceptado por algún Administrador"); 
    }
}
