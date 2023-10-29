<?php

namespace App\Http\Livewire\Taxista;

use Livewire\Component;

class CardTaxistas extends Component
{
    public $taxista;

    public function render()
    {
        return view('livewire.taxista.card-taxistas');
    }
}
