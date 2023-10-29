<?php

namespace App\Http\Livewire\Economia;

use App\Models\Cierre;
use Livewire\Component;
use Illuminate\Http\Request;

class Economia extends Component
{   
    public $opcion;

    public $title = "Gestion Económica";

    protected $queryString = ['opcion'];

    protected $listeners = ['load'];

    public Cierre $lastCierre;

    public function mount(Request $request){

        $c = Cierre::orderBy('created_at','DESC')->first();
        if($c != null)
            $this->lastCierre = $c;

        if($request->opcion)
            $this->opcion = $request->opcion;
        else
            $this->opcion = "cortes";
    }

    public function render()
    {
        return view('livewire.economia.economia')->layoutData(['titulo' => $this->title]);
    }

    public function changeOpcion($op){
        $this->opcion = $op;
    }

    public function load(){}
}
