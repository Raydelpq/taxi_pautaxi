<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Viaje;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Balance extends Component
{
    public $star = null;
    public $end = null;

    protected $listeners = ['inicio'];

    public function render()
    {
        return view('livewire.dashboard.balance');
    }

    public function inicio(){ 

        $user = Auth::user();

        if($user->hasRole('Administrador')){

            if($this->star != null)
                $suma = Viaje::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])
                        ->where('taxista_id','<>',null)
                        ->selectRaw(" sum( (costo * moneda_valor) * descuento) as Monto")
                        ->selectRaw(" sum( (costo * moneda_valor)) as Importe")
                        ->first();
            else
                $suma = Viaje::where('taxista_id','<>',null)
                        ->selectRaw(" sum( (costo * moneda_valor) * descuento) as Monto")
                        ->selectRaw(" sum( (costo * moneda_valor)) as Importe")
                        ->first();
        }else{
            // Es Taxista
            if($this->star != null)
                $suma = Viaje::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])
                        ->where('taxista_id', $user->taxista->id)
                        ->selectRaw(" sum( (costo * moneda_valor) * descuento) as Monto")
                        ->selectRaw(" sum( (costo * moneda_valor)) as Importe")
                        ->first();
            else
                $suma = Viaje::where('taxista_id', $user->taxista->id)
                        ->selectRaw(" sum( (costo * moneda_valor) * descuento) as Monto")
                        ->selectRaw(" sum( (costo * moneda_valor)) as Importe")
                        ->first();
        }

        $importeTotal = $suma->Importe;
        $montoTotal = $suma->Monto;
        $this->emit('paintBalance',$importeTotal,$montoTotal); 
    }
}
