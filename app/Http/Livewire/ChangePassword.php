<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Component
{   
    public User $user;

    public $password;
    public $password_confirmation;

    protected $rules = [
        'password'       => 'required|min:6',
        'password_confirmation'  => 'required_with:password|same:password',
    ];

    protected $validationAttributes = [

        'password' => 'Contraseña',
        'password_confirmation'  => 'Confirmar Contraseña',

    ];

    public function resetInput(){
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function render()
    {
        return view('livewire.change-password');
    }

    public function change(){
        $this->validate();

        $this->user->password = Hash::make($this->password);
        $this->user->update();
        $this->resetInput();
        $this->emit('message',"Contraseña Actualizada",'success'); 
    }

}
