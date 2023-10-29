<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Viaje;
use App\Models\Colaboracion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView; 

class ViajesExports implements FromView
{
    public $star, $end, $colaborador_id, $user_id;

    public function __construct($star,$end,$colaborador_id = null, $user_id = null){
        $this->star = $star;
        $this->end = $end;
        $this->colaborador_id = $colaborador_id;
        $this->user_id = $user_id;
    }

    public function view(): View
    {   
        $titulo = "Viajes {$this->star} - {$this->end}";
        
        $build = Viaje::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59']);

        if($this->user_id != null){
            $build->where(function($q){
                $q->where('comercial_id',$this->user_id);
            });
            /*$c = Colaboracion::find($this->colaborador_id);
            $titulo = "{$c->name} {$this->star} - {$this->end}";*/
        }

        if($this->colaborador_id != null){
            $build->where(function($q){
                $q->where('colaborador_id',$this->colaborador_id);
            });
            $c = Colaboracion::find($this->colaborador_id);

            $star = new Carbon($this->star);
            $end = new Carbon($this->end);

            $titulo = "{$c->name} {$star->format('d-m')} a {$end->format('d-m')}";
        }

        $viajes = $build->get();

        //dd($viajes);
        return view('pdf.excel', [
            'viajes' => $viajes,
            'titulo' => $titulo
        ]);
    }
}