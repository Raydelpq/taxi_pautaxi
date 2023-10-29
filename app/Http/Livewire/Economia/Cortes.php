<?php

namespace App\Http\Livewire\Economia;

use App\Models\Cierre;
use Livewire\Component;
use Livewire\WithPagination;

class Cortes extends Component
{   
    use WithPagination; 

    public function render()
    {   
        $cierres = Cierre::orderBy('created_at','Desc')->paginate(10);

        return view('livewire.economia.cortes',['cierres' => $cierres]);
    }
}
