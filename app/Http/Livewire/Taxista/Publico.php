<?php

namespace App\Http\Livewire\Taxista;

use App\Models\Taxista;
use Livewire\Component;

class Publico extends Component
{   
    public $taxista;
    public $titulo;

    public function mount($id){

        $this->taxista = Taxista::findOrFail($id);
        $this->titulo = $this->taxista->user->name." ".$this->taxista->user->apellidos;

        
    }

    public function render()
    {
        return view('livewire.taxista.publico')->layout('layouts.public', ['title' => $this->titulo,'taxista'=>$this->taxista]);
    }
}
