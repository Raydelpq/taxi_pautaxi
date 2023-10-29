<?php

namespace App\Jobs;

use App\Models\Cierre;
use App\Models\CierreGasto;
use App\Models\CierreViaje;
use App\Models\CierreSalario;
use Illuminate\Bus\Queueable;
use App\Models\CierreViajeEliminado;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SaveCierre implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cierre;

    public $listGatos;
    public $listEmpleados;
    public $listViajes;
    public $listViajesEliminados;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Cierre $cierre,$listGatos,$listEmpleados,$listViajes,$listViajesEliminados)
    {   
        $this->cierre               = $cierre;
        $this->listGatos            = $listGatos;
        $this->listEmpleados        = $listEmpleados;
        $this->listViajes           = $listViajes;
        $this->listViajesEliminados = $listViajesEliminados;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        // Guardar Gastos
        foreach($this->listGatos as $g){
            $cg = new CierreGasto();
            $cg->cierre_id = $this->cierre->id;
            $cg->name     = $g->name;
            $cg->valor    = $g->valor;
            $cg->save();
        } 

        //Guardar Salarios
        foreach($this->listEmpleados as $g){ 
           
            $cs = new CierreSalario();
            $cs->cierre_id = $this->cierre->id;
            $cs->user_id = $g->id;
            $cs->salario    = $g->comercial->getSalario($this->cierre->star->format('Y-m-d'),$this->cierre->end->format('Y-m-d'),$this->cierre->ganancia);
            $cs->save();
            
        } 

        // Guardar relacion de viajes
        foreach($this->listViajes as $g){ 
            $cv = new CierreViaje();
            $cv->cierre_id = $this->cierre->id;
            $cv->dia        = $g['dia'];
            $cv->cantidad   = $g['cant'];
            $cv->save();
        } 

        // Guardar relacion de viajes eliminados
        foreach($this->listViajesEliminados as $g){ 
            $cve = new CierreViajeEliminado();
            $cve->cierre_id = $this->cierre->id;
            $cve->dia        = $g['dia'];
            $cve->cantidad   = $g['cant'];
            $cve->save();
        } 
    }
}
