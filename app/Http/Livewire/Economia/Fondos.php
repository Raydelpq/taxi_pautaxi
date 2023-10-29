<?php

namespace App\Http\Livewire\Economia;

use Carbon\Carbon;
use App\Models\Fondo;
use App\Models\Ingreso;
use App\Models\Cierre;
use App\Models\Taxista;
use Livewire\Component;

class Fondos extends Component
{
    public $fondoTotal = 0;
    public $deudaTotal = 0;
    public $ingresoSemanal = 0;

    public function mount(){
        $this->fondoTotal = Taxista::where('fondo','>',0)->sum('fondo');
        $this->deudaTotal = Taxista::where('fondo','<',0)->sum('fondo');

        $lastCierre = Cierre::orderBy('created_at','DESC')->first();

        $star = "2023-01-01 00:00:00";
        if($lastCierre != null){
            $f_fin = new Carbon($lastCierre->end);
            $star = $f_fin->addDay()->format('Y-m-d');
        }
        $end = date("Y-m-d");

        $temp = Fondo::whereBetween('created_at', [$star.' 00:00:00', $end.' 23:59:59'])
                                    ->selectRaw("sum(saldo) as ingresoSemalan")
                                    ->first();

        $taxistasEliminados = Taxista::onlyTrashed()
                                    ->whereBetween('deleted_at', [$star.' 00:00:00', $end.' 23:59:59'])
                                    ->selectRaw("sum(fondo) as fondos")
                                    ->first();    
        //dd( $temp->ingresoSemalan , $taxistasEliminados->fondos);

        $this->ingresoSemanal = $this->getIngresosSemanales();
    }

    public function render()
    {
        return view('livewire.economia.fondos');
    }

    public function getIngresosSemanales(){
        $lastCierre = Cierre::orderBy('created_at','DESC')->first();

        $star = "2023-01-01 00:00:00";
        if($lastCierre != null){
            $f_fin = new Carbon($lastCierre->end);
            $star = $f_fin->addDay()->format('Y-m-d');
        }
        $end = date("Y-m-d");

        $temp = Fondo::whereBetween('created_at', [$star.' 00:00:00', $end.' 23:59:59'])
                                    ->where('type','<>','Retiro')
                                    ->selectRaw("sum(saldo) as ingresoSemalan")
                                    ->first();

        $tempRetiro = Fondo::whereBetween('created_at', [$star.' 00:00:00', $end.' 23:59:59'])
                                    ->where('type','=','Retiro')
                                    ->selectRaw("sum(saldo) as retiroSemalan")
                                    ->first();
   
        //dd( $temp->ingresoSemalan , $taxistasEliminados->fondos);

        $tmp = Ingreso::whereBetween('created_at', [$star.' 00:00:00', $end.' 23:59:59'])->selectRaw(" sum(valor) as ingresos")->first();
        $this->ingresos = $tmp->ingresos;

       return ( $temp->ingresoSemalan - $tempRetiro->retiroSemalan ) +  $this->ingresos;
    }
}
