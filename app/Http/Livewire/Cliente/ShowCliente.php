<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class ShowCliente extends Component
{   
    use WithPagination; 

    public Cliente $cliente;

    public $title;

    public function mount($id){
        $this->cliente = Cliente::findOrFail($id);

        $this->title = "Viajes de: {$this->cliente->numero}";
    }

    public function render()
    {
        return view('livewire.cliente.show-cliente',['viajes' => $this->cliente->viajes()->orderBy('created_at','DESC')->paginate(15)])->layoutData(['titulo' => $this->title]);
    }
}
