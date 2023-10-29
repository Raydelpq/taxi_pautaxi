<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ViajesDiarios extends Component
{   
    public $cargando = true;

    public $star = null;
    public $end = null;

    public $mis = false;

    public $labels = [];
    public $cantidad = [];

    protected $listeners = ['inicio'];

    public function render()
    {   $this->inicio();
        return view('livewire.dashboard.viajes-diarios');
    }

    public function inicio(){

        $user = Auth::user();

        if($user->hasRole('Administrador')){

            if(!$this->mis){

                if($this->star != null)
                    $viajesDiarios = DB::select(DB::raw("SELECT DAY(`created_at`) AS mes, COUNT(*) AS t FROM `viajes` WHERE `created_at` BETWEEN '{$this->star} 00:00:00' AND '{$this->end} 23:59:59' and `deleted_at` is null  GROUP BY DAY(`created_at`) "));
                else 
                    $viajesDiarios = DB::select(DB::raw("SELECT DAY(`created_at`) AS mes, COUNT(*) AS t FROM `viajes` WHERE `deleted_at` is null  GROUP BY DAY(`created_at`) "));
            }else{

                if($this->star != null)
                    $viajesDiarios = DB::select(DB::raw("SELECT DAY(`created_at`) AS mes, COUNT(*) AS t FROM `viajes` WHERE `created_at` BETWEEN '{$this->star} 00:00:00' AND '{$this->end} 23:59:59' and `comercial_id` = $user->id and `deleted_at` is null  GROUP BY DAY(`created_at`) "));
                else 
                    $viajesDiarios = DB::select(DB::raw("SELECT DAY(`created_at`) AS mes, COUNT(*) AS t FROM `viajes` WHERE `comercial_id` = $user->id and `deleted_at` is null  GROUP BY DAY(`created_at`) order by mes ASC "));
            }
        }else 
        if($user->hasRole('Comercial')){
            if($this->star != null)
                $viajesDiarios = DB::select(DB::raw("SELECT DAY(`created_at`) AS mes, COUNT(*) AS t FROM `viajes` WHERE `created_at` BETWEEN '{$this->star} 00:00:00' AND '{$this->end} 23:59:59' and `comercial_id` = $user->id and `deleted_at` is null  GROUP BY DAY(`created_at`) "));
            else 
                $viajesDiarios = DB::select(DB::raw("SELECT DAY(`created_at`) AS mes, COUNT(*) AS t FROM `viajes` WHERE `comercial_id` = $user->id and `deleted_at` is null  GROUP BY DAY(`created_at`) "));
        }else 
        if($user->hasRole('Taxista')){
            $id = $user->taxista->id;
            if($this->star != null)
                $viajesDiarios = DB::select(DB::raw("SELECT DAY(`created_at`) AS mes, COUNT(*) AS t FROM `viajes` WHERE `created_at` BETWEEN '{$this->star} 00:00:00' AND '{$this->end} 23:59:59' and `taxista_id` = $id and `deleted_at` is null  GROUP BY DAY(`created_at`) "));
            else 
                $viajesDiarios = DB::select(DB::raw("SELECT DAY(`created_at`) AS mes, COUNT(*) AS t FROM `viajes` WHERE `taxista_id` = $id and `deleted_at` is null  GROUP BY DAY(`created_at`) "));
        }

        
        $this->labels = [];
        $this->cantidad = [];
        foreach ($viajesDiarios as $key => $value) {
            $this->labels[$key] = $value->mes;
            $this->cantidad[$key] = $value->t; 
        }
        $this->emit('paintDiario',$this->labels,$this->cantidad);
        $this->cargando = false;
    }
}
