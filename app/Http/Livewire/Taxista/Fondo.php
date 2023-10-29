<?php

namespace App\Http\Livewire\Taxista;

use App\Models\Taxista;
use Livewire\Component;

class Fondo extends Component
{
    public Taxista $taxista;

    public function render()
    {
        return view('livewire.taxista.fondo');
    }
}
