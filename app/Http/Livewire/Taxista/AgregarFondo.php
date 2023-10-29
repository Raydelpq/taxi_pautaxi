<?php

namespace App\Http\Livewire\Taxista;

use App\Models\Fondo;
use App\Models\Taxista;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AgregarFondo extends Component
{   
    public Taxista $taxista;
    public Fondo $fondo;

    protected $rules =[
        'fondo.type' => 'required|in:Efectivo,Transferencia,Retiro',
        'fondo.saldo' => 'required|numeric'
    ];

    public function mount(){
        $this->fondo = new Fondo();
    }

    public function render()
    {
        return view('livewire.taxista.agregar-fondo');
    }

    public function resetInput(){
        $this->fondo = new Fondo();
        $this->fondo->saldo = null;
        $this->fondo->type = '';
    }

    public function procesar(){
        $this->validate();
        $user = Auth::user();

        $this->fondo->taxista_id = $this->taxista->id; 
        $this->fondo->comercial_id = $user->id; 
        $this->fondo->model = "App\Models\\".Auth::user()->roles()->first()->name; 

        $this->fondo->fondo = $this->taxista->fondo;

        if($this->fondo->type == 'Transferencia' || $this->fondo->type == 'Efectivo')
            $this->fondo->activo = ( $this->taxista->fondo + $this->fondo->saldo );
        else
            $this->fondo->activo = ( $this->taxista->fondo - $this->fondo->saldo );

        $this->taxista->fondo = $this->fondo->activo;

        $this->taxista->update();
        $this->fondo->save();
        $this->resetInput();

        $this->emitTo('taxista.show','updateData');
        $this->emitTo('taxista.registro-fondo','reload');
        $this->emit('message','Fondo Procesado','success');
    }
}
