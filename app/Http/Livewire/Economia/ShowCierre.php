<?php

namespace App\Http\Livewire\Economia;

use App\Models\User;
use App\Models\Gasto;
use App\Models\Viaje;
use App\Models\Ingreso;
use App\Models\Cierre as ModelCierre;
use Livewire\Component;
use App\Jobs\SaveCierre;
use App\Jobs\ExportViajesExcel;
use App\Models\CierreGasto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Exports\ViajesExports;

class ShowCierre extends Component
{   
    public $cargado = false;

    public $lastCierre;

    public $fechas;

    public $empleados = [];
    public $listGatos = [];
    public $listViajes = [];
    public $listViajesEliminados = [];

    public $star , $end;

    public $ingresos;

    // Sobre viajes
    public $importeTotal = 0;
    public $montoTotal   = 0;
    public $viajesTotal  = 0;
    public $viajesEliminados = 0;

    public $viajesDiarios = [];
    public $cantidadDiarios = [];
    public $viajesDiariosEliminados = [];
    public $cantidadDiariosEliminados = [];

    public $gastos = 0;
    public $salarios = 0;

    protected $listeners = ['procesarFecha','loadState'];

    public $cierre;
    public function mount($id){

        $this->cierre = ModelCierre::find($id);
        $this->star = $this->cierre->star->format('Y-m-d');
        $this->end  = $this->cierre->end->format('Y-m-d');
    }

    public function render()
    {  
        return view('livewire.economia.show-cierre')->layoutData(['titulo' => "Cierre: {$this->star}-{$this->end}"]);
    }

    // Procesar Viajes
    public function procesarFecha(){

        $this->sumViajes();
        $this->gastos = $this->sumGastos();
        $this->sumSalarios();

        $this->cargado = true;
        $this->emit('endLoad');
    }


    // COnteo y suma en viajes
    private function sumViajes(){
        
        $this->importeTotal = $this->cierre->importe;
        $this->montoTotal = $this->cierre->ganancia;

        $this->viajesTotal = $this->cierre->viajes;
        $this->viajesEliminados = $this->cierre->viajes_eliminados;
        
    }

    // Suma de los Gastos en el periodo
    private function sumGastos(){
        return $this->cierre->gastos()->sum('valor'); 
    }

     // Suma de los Gastos en el periodo
     private function sumSalarios(){
        $this->empleados = $this->cierre->empleados;

        foreach($this->empleados as $empleado)
            $this->salarios += $empleado->salario;
     }

    // Devuelve la cantidad de viajes por cada dia del periodo, muestra los eliminados
    private function getViajesDiarios(){

        
        $this->listViajes    = $this->cierre->listViajes()->select('dia','cantidad')->get()->toArray();
        
        $this->listViajesEliminados = $this->cierre->eliminados()->select('dia','cantidad')->get()->toArray();
       
        foreach ($this->listViajes as $key => $value) {
            $this->viajesDiarios[$key]      = $value['dia'];
            $this->cantidadDiarios[$key]   = $value['cantidad']; 
        }

        
        foreach ($this->listViajesEliminados as $key => $value) {
            $this->viajesDiariosEliminados[$key]      = $value['dia'];
            $this->cantidadDiariosEliminados[$key]   = $value['cantidad']; 
        }

        //dd($this->viajesDiarios);
        $this->emit('paint',$this->viajesDiarios, $this->cantidadDiarios, $this->viajesDiariosEliminados,$this->cantidadDiariosEliminados);
        $this->emit('paintBalance',$this->gastos, $this->salarios, ( $this->montoTotal - ($this->gastos + $this->salarios)) );
    }

     // Cargar los Card
    public function loadState(){
        $this->listGatos = $this->cierre->gastos;
        $this->getViajesDiarios();

        $tmp = Ingreso::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])->selectRaw(" sum(valor) as ingresos")->first();
        //$this->ingresos = $tmp->ingresos;
    }

    public function save(){
        
        // Cierre
        $cierre                     = new ModelCierre();
        $cierre->star               = $this->star;
        $cierre->end                = $this->end;
        $cierre->importe            = $this->importeTotal;
        $cierre->ganancia           = $this->montoTotal;
        $cierre->viajes             = $this->viajesTotal;
        $cierre->viajese_liminados  = $this->viajesEliminados;
        $cierre->administrador_id   = Auth::user()->id;
        $cierre->save();


        SaveCierre::dispatch($cierre->id ,$this->listGatos,$this->empleados,$this->listViajes,$this->listViajesEliminados);
        

    }

    public function excel(){

        ExportViajesExcel::dispatch($this->star,$this->end);
    }
}
