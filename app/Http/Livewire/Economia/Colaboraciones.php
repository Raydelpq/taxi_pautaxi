<?php

namespace App\Http\Livewire\Economia;

use App\Models\Viaje;
use Livewire\Component;

class Colaboraciones extends Component
{
    public $star , $end;

    public function render()
    {
        $viajes = Viaje::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])
                        ->where('colaborador_id','<>',null)
                        ->select('colaborador_id',\DB::raw("count('colaborador_id') as total"))
                        ->groupBy('colaborador_id')
                        ->orderBy('total','DESC')
                        ->get();
        
        return view('livewire.economia.colaboraciones',['viajes'=> $viajes]);
    }

    /*
    * Devuelve los datos para el cierre de una agencia dado su ID
    * @ $id identificador de la agencia 
    * return array
    */
    public function getViajesColaboracion($id){
        $datos = [];

        $datos['entrada'] = Viaje::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])
                    ->where(function($q) use ($id){
                        $q->where('colaborador_id',$id)->where('type_colaboracion','entrada');
                    })
                    ->selectRaw(" count(id) as Cantidad")
                    ->selectRaw(" sum((costo * moneda_valor) * descuento) as Monto")
                    ->selectRaw(" sum((costo * moneda_valor)) as Importe")
                    ->first();

        $datos['salida'] = Viaje::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])
                    ->where(function($q) use ($id){
                        $q->where('colaborador_id',$id)->where('type_colaboracion','salida');
                    })
                    ->selectRaw(" count(id) as Cantidad")
                    ->selectRaw(" sum((costo * moneda_valor) * descuento) as Monto")
                    ->selectRaw(" sum((costo * moneda_valor)) as Importe")
                    ->first();

        return $datos;
    }
} 
